<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Photo;
use App\Role;
use App\Order;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class CompanydashboardController extends Controller
{

    public function index(){
    	  $data['webpage']='Sales Dashboard';
        $data['action']='Sales Dashboard';
        $data['menu']='';
        $data['role']=Role::count();
        $data['totalusers']=User::count();
        $data['totalorder']=Order::count();
        //$today=date('Y-m-d');

        $fromdate_today = Carbon::today()->format('Y-m-d H:i:s');
        $todate_today = Carbon::parse($fromdate_today)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $data['todaytotalorder']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->count();
        $data['todaytiffinorder']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('main_categories_id',1)->count();
        $data['todaymenuorder']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('main_categories_id',3)->count();
        $data['todaycateringorder']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('main_categories_id',2)->count();

        $data['todaytotalorderpicked']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('order_pickup','Yes')->count();
        $data['todaytiffinorderpicked']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('main_categories_id',1)->where('order_pickup','Yes')->count();
        $data['todaymenuorderpicked']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('main_categories_id',3)->where('order_pickup','Yes')->count();
        $data['todaycateringorderpicked']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('main_categories_id',2)->where('order_pickup','Yes')->count();

        $data['adminuser']=User::where('role_id',1)->count();
        $data['salesuser']=User::where('role_id',2)->count();
        $data['kitchenuser']=User::where('role_id',3)->count();
        $data['counteruser']=User::where('role_id',4)->count();
        $data['frontuser']=User::where('role_id',5)->count();
        $data['unpaidorder']=Order::where('amount_received','No')->count();
        $data['paidorder']=Order::where('amount_received','Yes')->count();
        $data['acceptorder']=Order::where('order_status','Accepted')->count();
        $data['pickuporder']=Order::where('order_status','Picked up')->count();

        $order_history_data=array();
        $order_data = DB::select('SELECT count(*) as total_order, MONTH(created_at) as month, YEAR(created_at) as year FROM orders WHERE order_status!="Canceled" and  (created_at < Now() and created_at > DATE_ADD(Now(), INTERVAL- 6 MONTH)) and deleted_at is null GROUP BY MONTH(created_at), YEAR(created_at)');
        for($i=0;$i<count($order_data);$i++){
          $order_history_data[$i]['month'] = date("F", mktime(0, 0, 0, $order_data[$i]->month, 1))." - ".$order_data[$i]->year;
          $order_history_data[$i]['order'] = $order_data[$i]->total_order;
        }
        $data['order_history_data']=$order_history_data;
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');

        $data['tiffintodayacceptorder'] = DB::select('SELECT * FROM orders WHERE delivery_date like "%'.$start_date.'%" and main_categories_id=1 and order_status="Accepted" and deleted_at is null order by id');
        $data['cateringtodayacceptorder'] = DB::select('SELECT * FROM orders WHERE delivery_date like "%'.$start_date.'%" and main_categories_id=2 and order_status="Accepted" and deleted_at is null order by id');
        $data['menutodayacceptorder'] = DB::select('SELECT * FROM orders WHERE delivery_date like "%'.$start_date.'%" and main_categories_id=3 and order_status="Accepted" and deleted_at is null order by id');

        $data['todayacceptorder'] = DB::select('SELECT * FROM orders WHERE delivery_date like "%'.$start_date.'%" and order_status="Accepted" and deleted_at is null order by id');
        $data['todaypendingorder'] = DB::select('SELECT * FROM orders WHERE delivery_date like "%'.$start_date.'%" and order_status="Pending" and deleted_at is null order by id');

        $fromdate = Carbon::today()->format('Y-m-d H:i:s');
        $todate = Carbon::parse($fromdate)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $total_amount_received=0;
        $payment_total_report=array();
        $payment_total_report['cash']=0;
        $payment_total_report['paypal']=0;
        $payment_total_report['check']=0;
        $payment_total_report['creditcard']=0;
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and  main_categories_id=1 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
        for($i=0;$i<count($order_data);$i++){
          $productpayment_data = DB::select('SELECT * FROM orderpayments WHERE order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
          for($k=0;$k<count($productpayment_data);$k++){
            $total_amount_received=$total_amount_received+$productpayment_data[$k]->payment_amount;
              if($productpayment_data[$k]->payment_type=="Cash"){
                  $payment_total_report['cash']=$payment_total_report['cash']+$productpayment_data[$k]->payment_amount;
              }elseif($productpayment_data[$k]->payment_type=="Paypal"){
                  $payment_total_report['paypal']=$payment_total_report['paypal']+$productpayment_data[$k]->payment_amount;
              }elseif($productpayment_data[$k]->payment_type=="Check"){
                  $payment_total_report['check']=$payment_total_report['check']+$productpayment_data[$k]->payment_amount;
              }else{
                  $payment_total_report['creditcard']=$payment_total_report['creditcard']+$productpayment_data[$k]->payment_amount;
              }
          }
        }
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and  main_categories_id=2 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
        for($i=0;$i<count($order_data);$i++){
          $productpayment_data = DB::select('SELECT * FROM orderpayments WHERE order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
          for($k=0;$k<count($productpayment_data);$k++){
            $total_amount_received=$total_amount_received+$productpayment_data[$k]->payment_amount;
            if($productpayment_data[$k]->payment_type=="Cash"){
                $payment_total_report['cash']=$payment_total_report['cash']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Paypal"){
                $payment_total_report['paypal']=$payment_total_report['paypal']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Check"){
                $payment_total_report['check']=$payment_total_report['check']+$productpayment_data[$k]->payment_amount;
            }else{
                $payment_total_report['creditcard']=$payment_total_report['creditcard']+$productpayment_data[$k]->payment_amount;
            }
          }
        }
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and  main_categories_id=3 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
        for($i=0;$i<count($order_data);$i++){
          $productpayment_data = DB::select('SELECT * FROM orderpayments WHERE order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
          for($k=0;$k<count($productpayment_data);$k++){
            $total_amount_received=$total_amount_received+$productpayment_data[$k]->payment_amount;
            if($productpayment_data[$k]->payment_type=="Cash"){
                $payment_total_report['cash']=$payment_total_report['cash']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Paypal"){
                $payment_total_report['paypal']=$payment_total_report['paypal']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Check"){
                $payment_total_report['check']=$payment_total_report['check']+$productpayment_data[$k]->payment_amount;
            }else{
                $payment_total_report['creditcard']=$payment_total_report['creditcard']+$productpayment_data[$k]->payment_amount;
            }
          }
        }

        $data['payment_total_amount']=$total_amount_received;
        $data['payment_total_report']=$payment_total_report;

        // Today's Tiffin Order
        $fromdate_today = Carbon::today()->format('Y-m-d H:i:s');
        $todate_today = Carbon::parse($fromdate_today)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $data['todaytiffinorder']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_today)->where('delivery_date','<=',$todate_today)->where('main_categories_id',1)->where('order_pickup','No')->count();

        // Tomorrow's Tiffin Order
        $fromdate_tomorrow = date('Y-m-d', strtotime('+1 days'));
        $todate_tomorrow = Carbon::tomorrow()->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $data['tomorrowtiffinorder']=Order::where('order_status','!=','Canceled')->where('delivery_date','>=',$fromdate_tomorrow)->where('delivery_date','<=',$todate_tomorrow)->where('main_categories_id',1)->where('order_pickup','No')->count();

        // Today's Menu Order
        $fromdate_today = Carbon::today()->format('Y-m-d H:i:s');
        $todate_today = Carbon::parse($fromdate_today)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $todaymenuorder=DB::select("SELECT DISTINCT(po.p_id) as p_id FROM orderproducts as po INNER JOIN orders as o ON o.id=po.order_id where o.order_status!='Canceled' and main_categories_id=3 and order_pickup='No' and (delivery_date>='".$fromdate_today."'  and delivery_date<='".$todate_today."')");
        $todaymenu_array = array();
        for($p=0;$p<count($todaymenuorder);$p++){
          $p_id = $todaymenuorder[$p]->p_id;
          $data_qty = DB::select("SELECT sum(p_qty) as qty FROM orderproducts where deleted_at is null and p_id='".$p_id."'");
          $todaymenu_array[$p]['qty']=$data_qty[0]->qty;
          $data_name = DB::select("SELECT DISTINCT(p_name) as name FROM orderproducts where deleted_at is null and p_id='".$p_id."'");
          $todaymenu_array[$p]['name']=$data_name[0]->name;
        }
        $data['todaymenu']=$todaymenu_array;

        // Tomorrow's Menu Order
        $fromdate_tomorrow = date('Y-m-d', strtotime('+1 days'));
        $todate_tomorrow = Carbon::tomorrow()->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $fromdate_today = Carbon::today()->format('Y-m-d H:i:s');
        $todate_today = Carbon::parse($fromdate_today)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $todaymenuorder=DB::select("SELECT DISTINCT(po.p_id) as p_id FROM orderproducts as po INNER JOIN orders as o ON o.id=po.order_id where o.order_status!='Canceled' and main_categories_id=3 and order_pickup='No' and (delivery_date>='".$fromdate_tomorrow."'  and delivery_date<='".$todate_tomorrow."')");
        $tomorrowmenu_array = array();
        for($p=0;$p<count($todaymenuorder);$p++){
          $p_id = $todaymenuorder[$p]->p_id;
          $data_qty = DB::select("SELECT sum(p_qty) as qty FROM orderproducts where deleted_at is null and p_id='".$p_id."'");
          $tomorrowmenu_array[$p]['qty']=$data_qty[0]->qty;
          $data_name = DB::select("SELECT DISTINCT(p_name) as name FROM orderproducts where deleted_at is null and p_id='".$p_id."'");
          $tomorrowmenu_array[$p]['name']=$data_name[0]->name;
        }
        $data['tomorrowmenu']=$tomorrowmenu_array;

        return view('admin.dashboard.salesdashboard')->with($data);
    }

}
