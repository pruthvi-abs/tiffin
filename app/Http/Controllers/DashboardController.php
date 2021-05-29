<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Photo;
use App\Role;
use App\Order;
use App\Product;
use App\Orderproduct;
use App\Orderpayments;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class DashboardController extends Controller
{

    public function index()
    {
    	  $data['webpage']='Dashboard';
        $data['action']='Dashboard';
        $data['menu']='';
        //echo "call..";die;
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

        $fromdate = Carbon::today()->format('Y-m-d H:i:s');
        $todate = Carbon::parse($fromdate)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $total_amount_received=0;
        $payment_total_report=array();
        $payment_total_report['cash']=0;
        $payment_total_report['paypal']=0;
        $payment_total_report['check']=0;
        $payment_total_report['creditcard']=0;
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and main_categories_id=1 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
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
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and main_categories_id=2 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
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
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and main_categories_id=3 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
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

        return view('admin.dashboard.admindashboard')->with($data);
    }


    public function yearlydashboard(Request $request)
    {
        $data['webpage']='Yearly Dashboard';
        $data['action']='Yearly Dashboard';
        $data['menu']='';
        $year = $request->year;
        $data['selectedyear']=$year;

        $data['totalorder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->count();

        // Count Data
        $data['todaytotalorder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->count();
        $data['todaytiffinorder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('main_categories_id',1)->count();
        $data['todaymenuorder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('main_categories_id',3)->count();
        $data['todaycateringorder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('main_categories_id',2)->count();

        $data['todaytotalorderpicked']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('order_pickup','Yes')->count();
        $data['todaytiffinorderpicked']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('main_categories_id',1)->where('order_pickup','Yes')->count();
        $data['todaymenuorderpicked']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('main_categories_id',3)->where('order_pickup','Yes')->count();
        $data['todaycateringorderpicked']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('main_categories_id',2)->where('order_pickup','Yes')->count();

        $total_amount_received=0;
        $g_total=0;
        $payment_total_report=array();
        $payment_total_report['cash']=0;
        $payment_total_report['paypal']=0;
        $payment_total_report['check']=0;
        $payment_total_report['creditcard']=0;
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and  YEAR(delivery_date)="'.$year.'" and main_categories_id=1 and deleted_at is NULL order by delivery_date desc');
        for($i=0;$i<count($order_data);$i++){
          $g_total = $g_total + $order_data[$i]->grand_total;
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
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and  YEAR(delivery_date)="'.$year.'" and main_categories_id=2 and deleted_at is NULL order by delivery_date desc');
        for($i=0;$i<count($order_data);$i++){
          $g_total = $g_total + $order_data[$i]->grand_total;
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
        $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and  YEAR(delivery_date)="'.$year.'" and main_categories_id=3 and deleted_at is NULL order by delivery_date desc');
        for($i=0;$i<count($order_data);$i++){
          $g_total = $g_total + $order_data[$i]->grand_total;
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
        $data['g_total']=$g_total;

        ///// Graph Data
        $data['poporder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('payment_method','POP')->count();
        $data['paypalorder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('payment_method','Paypal')->count();
        $data['acceptorder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('order_status','Accepted')->count();
        $data['pickuporder']=Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$year)->where('order_status','Picked up')->count();


        ///// Bar Chart - revenue ( Current Yearly basis )( Monthly )
        $orderpayment_history_data=array();
        for($month=1;$month<=12;$month++){
          $current_year_cash=0;
          $current_year_creditcard=0;
          $current_year_check=0;
          $current_year_paypal=0;
          $orderpayment_data = Order::where('order_status','!=','Canceled')->whereMonth('delivery_date','=',$month)->whereYear('delivery_date','=',$year)->get();
          for($i=0;$i<count($orderpayment_data);$i++){
            $orderpayments_his_data = Orderpayments::where('order_id',$orderpayment_data[$i]->id)->get();
            for($p=0;$p<count($orderpayments_his_data);$p++){
              if($orderpayments_his_data[$p]->payment_type=="Paypal"){
                $current_year_paypal = $current_year_paypal + $orderpayments_his_data[$p]->payment_amount;
              }elseif($orderpayments_his_data[$p]->payment_type=="Credit Card"){
                $current_year_creditcard = $current_year_creditcard + $orderpayments_his_data[$p]->payment_amount;
              }elseif($orderpayments_his_data[$p]->payment_type=="Check"){
                $current_year_check = $current_year_check + $orderpayments_his_data[$p]->payment_amount;
              }else{
                $current_year_cash = $current_year_cash + $orderpayments_his_data[$p]->payment_amount;
              }
            }
          }
          $orderpayment_history_data[$month]['name'] = date("F", mktime(0, 0, 0, $month, 10));
          $orderpayment_history_data[$month]['paypal'] = $current_year_paypal;
          $orderpayment_history_data[$month]['creditcard'] = $current_year_creditcard;
          $orderpayment_history_data[$month]['check'] = $current_year_check;
          $orderpayment_history_data[$month]['cash'] = $current_year_cash;
        }
        $data['orderpayment_history_data']=$orderpayment_history_data;


        ///// Bar Chart - revenue ( Last 5 year Yearly basis )( Monthly )
        $year_orderpayment_history_data=array();
        $curr_y = $year-4;
        for($y=1;$y<=5;$y++){
          $current_year_cash=0;
          $current_year_creditcard=0;
          $current_year_check=0;
          $current_year_paypal=0;
          $orderpayment_data = Order::where('order_status','!=','Canceled')->whereYear('delivery_date','=',$curr_y)->get();
          for($i=0;$i<count($orderpayment_data);$i++){
            $orderpayments_his_data = Orderpayments::where('order_id',$orderpayment_data[$i]->id)->get();
            for($p=0;$p<count($orderpayments_his_data);$p++){
              if($orderpayments_his_data[$p]->payment_type=="Paypal"){
                $current_year_paypal = $current_year_paypal + $orderpayments_his_data[$p]->payment_amount;
              }elseif($orderpayments_his_data[$p]->payment_type=="Credit Card"){
                $current_year_creditcard = $current_year_creditcard + $orderpayments_his_data[$p]->payment_amount;
              }elseif($orderpayments_his_data[$p]->payment_type=="Check"){
                $current_year_check = $current_year_check + $orderpayments_his_data[$p]->payment_amount;
              }else{
                $current_year_cash = $current_year_cash + $orderpayments_his_data[$p]->payment_amount;
              }
            }
          }
          $year_orderpayment_history_data[$y]['name'] = $curr_y;
          $year_orderpayment_history_data[$y]['paypal'] = $current_year_paypal;
          $year_orderpayment_history_data[$y]['creditcard'] = $current_year_creditcard;
          $year_orderpayment_history_data[$y]['check'] = $current_year_check;
          $year_orderpayment_history_data[$y]['cash'] = $current_year_cash;
          $curr_y++;
        }
        $data['year_orderpayment_history_data']=$year_orderpayment_history_data;


        ///// Menu Product - revenue ( Current Yearly basis )( Monthly )
        $product_history_data=array();
        $product_data = Product::where('main_categories_id','=','3')->get();
        for($i=0;$i<count($product_data);$i++){
          $orderproduct_history_data=array();
          $orderproduct_his_count = Orderproduct::where('p_id',$product_data[$i]->id)->count();
          if($orderproduct_his_count <= 0){
            for($month=1;$month<=12;$month++){
              $total_amt=0;
              $orderproduct_history_data[$month]['total_amt'] = $total_amt;
            }
          }else{
            $orderproduct_his_data = Orderproduct::where('p_id',$product_data[$i]->id)->get();
              for($month=1;$month<=12;$month++){
                $total_amt=0;
                for($p=0;$p<count($orderproduct_his_data);$p++){
                $sql = 'SELECT * FROM orders WHERE id="'.$orderproduct_his_data[$p]->order_id.'" and order_status!="Canceled" and  YEAR(delivery_date)="'.$year.'" and  MONTH(delivery_date)="'.$month.'" and deleted_at is NULL';
                $order_his_data = Order::whereYear('delivery_date','=',$year)->whereMonth('delivery_date','=',$month)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->get();
                $order_his_count = Order::whereYear('delivery_date','=',$year)->whereMonth('delivery_date','=',$month)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->count();
                if($order_his_count >= 1){
                  for($l=0;$l<count($order_his_data);$l++){
                    $total_amt = $total_amt + ($orderproduct_his_data[$p]->p_price*$orderproduct_his_data[$p]->p_qty);
                  }
                }
              }
              $orderproduct_history_data[$month]['total_amt'] = $total_amt;
            }
          }
          $product_history_data[$i]['name']=$product_data[$i]->p_name;
          $product_history_data[$i]['price_data']=$orderproduct_history_data;
        }
        $data['product_history_data']=$product_history_data;



        ///// Tiffin Product - revenue ( Current Yearly basis )( Monthly )
        $tiffin_product_history_data=array();
        $product_data = Product::where('main_categories_id','=','1')->get();
        for($i=0;$i<count($product_data);$i++){
          $orderproduct_history_data=array();
          $orderproduct_his_data = Orderproduct::where('p_id',$product_data[$i]->id)->get();
          $orderproduct_his_count = Orderproduct::where('p_id',$product_data[$i]->id)->count();
          if($orderproduct_his_count <= 0){
            for($month=1;$month<=12;$month++){
              $total_amt=0;
              $orderproduct_history_data[$month]['total_amt'] = $total_amt;
            }
          }else{
              for($month=1;$month<=12;$month++){
                $total_amt=0;
                $inner=0;
                for($p=0;$p<count($orderproduct_his_data);$p++){
                $sql = 'SELECT * FROM orders WHERE id="'.$orderproduct_his_data[$p]->order_id.'" and order_status!="Canceled" and  YEAR(delivery_date)="'.$year.'" and  MONTH(delivery_date)="'.$month.'" and deleted_at is NULL';
                $order_his_data = Order::whereYear('delivery_date','=',$year)->whereMonth('delivery_date','=',$month)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->get();
                $order_his_count = Order::whereYear('delivery_date','=',$year)->whereMonth('delivery_date','=',$month)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->count();
                if($order_his_count >= 1){
                  $inner++;
                  for($l=0;$l<count($order_his_data);$l++){
                    $total_amt = $total_amt + ($orderproduct_his_data[$p]->p_price*$orderproduct_his_data[$p]->p_qty);
                  }
                }
              }
              $orderproduct_history_data[$month]['total_amt'] = $total_amt;
            }
          }
          $tiffin_product_history_data[$i]['name']=$product_data[$i]->p_name;
          $tiffin_product_history_data[$i]['price_data']=$orderproduct_history_data;
        }
        $data['tiffin_product_history_data']=$tiffin_product_history_data;

        ///// Catering Product - revenue ( Current Yearly basis )( Monthly )
        $catering_product_history_data=array();
        $product_data = Product::where('main_categories_id','=','2')->get();
        for($i=0;$i<count($product_data);$i++){
          $orderproduct_history_data=array();
          $orderproduct_his_data = Orderproduct::where('p_id',$product_data[$i]->id)->get();
          $orderproduct_his_count = Orderproduct::where('p_id',$product_data[$i]->id)->count();
          if($orderproduct_his_count <= 0){
            for($month=1;$month<=12;$month++){
              $total_amt=0;
              $orderproduct_history_data[$month]['total_amt'] = $total_amt;
            }
          }else{
              for($month=1;$month<=12;$month++){
                $total_amt=0;
                $inner=0;
                for($p=0;$p<count($orderproduct_his_data);$p++){
                $sql = 'SELECT * FROM orders WHERE id="'.$orderproduct_his_data[$p]->order_id.'" and order_status!="Canceled" and  YEAR(delivery_date)="'.$year.'" and  MONTH(delivery_date)="'.$month.'" and deleted_at is NULL';
                $order_his_data = Order::whereYear('delivery_date','=',$year)->whereMonth('delivery_date','=',$month)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->get();
                $order_his_count = Order::whereYear('delivery_date','=',$year)->whereMonth('delivery_date','=',$month)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->count();
                if($order_his_count >= 1){
                  $inner++;
                  for($l=0;$l<count($order_his_data);$l++){
                    $total_amt = $total_amt + ($orderproduct_his_data[$p]->p_price*$orderproduct_his_data[$p]->p_qty);
                  }
                }
              }
              $orderproduct_history_data[$month]['total_amt'] = $total_amt;
            }
          }
          $catering_product_history_data[$i]['name']=$product_data[$i]->p_name;
          $catering_product_history_data[$i]['price_data']=$orderproduct_history_data;
        }
        $data['catering_product_history_data']=$catering_product_history_data;

        $monthdata=array();
        for($month=1,$o=0;$month<=12;$month++,$o++){
          $monthdata[$o] = date("F", mktime(0, 0, 0, $month, 10));
        }
        $data['month_data']=$monthdata;

        ///// Menu Product - revenue ( Last 5 Year )
        $year_product_history_data=array();
        $product_data = Product::where('main_categories_id','=','3')->get();
        for($i=0;$i<count($product_data);$i++){
          $curr_year = $year-4;
          $orderproduct_history_data=array();
          $orderproduct_his_count = Orderproduct::where('p_id',$product_data[$i]->id)->count();
          if($orderproduct_his_count <= 0){
            for($y=1;$y<=5;$y++){
              $total_amt=0;
              $orderproduct_history_data[$y]['total_amt'] = $total_amt;
              $orderproduct_history_data[$y]['curr_year'] = $curr_year;
              $curr_year++;
            }
          }else{
            $orderproduct_his_data = Orderproduct::where('p_id',$product_data[$i]->id)->get();
              for($y=1;$y<=5;$y++){
                $total_amt=0;
                for($p=0;$p<count($orderproduct_his_data);$p++){
                $sql = 'SELECT * FROM orders WHERE id="'.$orderproduct_his_data[$p]->order_id.'" and order_status!="Canceled" and  YEAR(delivery_date)="'.$curr_year.'" and  MONTH(delivery_date)="'.$month.'" and deleted_at is NULL';
                $order_his_data = Order::whereYear('delivery_date','=',$curr_year)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->get();
                $order_his_count = Order::whereYear('delivery_date','=',$curr_year)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->count();
                if($order_his_count >= 1){
                  for($l=0;$l<count($order_his_data);$l++){
                    $total_amt = $total_amt + ($orderproduct_his_data[$p]->p_price*$orderproduct_his_data[$p]->p_qty);
                  }
                }
              }
              $orderproduct_history_data[$y]['total_amt'] = $total_amt;
              $orderproduct_history_data[$y]['curr_year'] = $curr_year;
              $curr_year++;
            }
          }
          $year_product_history_data[$i]['name']=$product_data[$i]->p_name;
          $year_product_history_data[$i]['price_data']=$orderproduct_history_data;
        }
        $data['year_product_history_data']=$year_product_history_data;

        ///// Tiffin Product - revenue ( Last 5 Year )
        $year_tiffin_product_history_data=array();
        $product_data = Product::where('main_categories_id','=','1')->get();
        for($i=0;$i<count($product_data);$i++){
          $curr_year = $year-4;
          $orderproduct_history_data=array();
          $orderproduct_his_count = Orderproduct::where('p_id',$product_data[$i]->id)->count();
          if($orderproduct_his_count <= 0){
            for($y=1;$y<=5;$y++){
              $total_amt=0;
              $orderproduct_history_data[$y]['total_amt'] = $total_amt;
              $orderproduct_history_data[$y]['curr_year'] = $curr_year;
              $curr_year++;
            }
          }else{
            $orderproduct_his_data = Orderproduct::where('p_id',$product_data[$i]->id)->get();
              for($y=1;$y<=5;$y++){
                $total_amt=0;
                for($p=0;$p<count($orderproduct_his_data);$p++){
                $sql = 'SELECT * FROM orders WHERE id="'.$orderproduct_his_data[$p]->order_id.'" and order_status!="Canceled" and  YEAR(delivery_date)="'.$curr_year.'" and  MONTH(delivery_date)="'.$month.'" and deleted_at is NULL';
                $order_his_data = Order::whereYear('delivery_date','=',$curr_year)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->get();
                $order_his_count = Order::whereYear('delivery_date','=',$curr_year)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->count();
                if($order_his_count >= 1){
                  for($l=0;$l<count($order_his_data);$l++){
                    $total_amt = $total_amt + ($orderproduct_his_data[$p]->p_price*$orderproduct_his_data[$p]->p_qty);
                  }
                }
              }
              $orderproduct_history_data[$y]['total_amt'] = $total_amt;
              $orderproduct_history_data[$y]['curr_year'] = $curr_year;
              $curr_year++;
            }
          }
          $year_tiffin_product_history_data[$i]['name']=$product_data[$i]->p_name;
          $year_tiffin_product_history_data[$i]['price_data']=$orderproduct_history_data;
        }
        $data['year_tiffin_product_history_data']=$year_tiffin_product_history_data;


        ///// Tiffin Product - revenue ( Last 5 Year )
        $year_catering_product_history_data=array();
        $product_data = Product::where('main_categories_id','=','2')->get();
        for($i=0;$i<count($product_data);$i++){
          $curr_year = $year-4;
          $orderproduct_history_data=array();
          $orderproduct_his_count = Orderproduct::where('p_id',$product_data[$i]->id)->count();
          if($orderproduct_his_count <= 0){
            for($y=1;$y<=5;$y++){
              $total_amt=0;
              $orderproduct_history_data[$y]['total_amt'] = $total_amt;
              $orderproduct_history_data[$y]['curr_year'] = $curr_year;
              $curr_year++;
            }
          }else{
            $orderproduct_his_data = Orderproduct::where('p_id',$product_data[$i]->id)->get();
              for($y=1;$y<=5;$y++){
                $total_amt=0;
                for($p=0;$p<count($orderproduct_his_data);$p++){
                $sql = 'SELECT * FROM orders WHERE id="'.$orderproduct_his_data[$p]->order_id.'" and order_status!="Canceled" and  YEAR(delivery_date)="'.$curr_year.'" and  MONTH(delivery_date)="'.$month.'" and deleted_at is NULL';
                $order_his_data = Order::whereYear('delivery_date','=',$curr_year)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->get();
                $order_his_count = Order::whereYear('delivery_date','=',$curr_year)->where('id',$orderproduct_his_data[$p]->order_id)->where('order_status','!=',"Canceled")->count();
                if($order_his_count >= 1){
                  for($l=0;$l<count($order_his_data);$l++){
                    $total_amt = $total_amt + ($orderproduct_his_data[$p]->p_price*$orderproduct_his_data[$p]->p_qty);
                  }
                }
              }
              $orderproduct_history_data[$y]['total_amt'] = $total_amt;
              $orderproduct_history_data[$y]['curr_year'] = $curr_year;
              $curr_year++;
            }
          }
          $year_catering_product_history_data[$i]['name']=$product_data[$i]->p_name;
          $year_catering_product_history_data[$i]['price_data']=$orderproduct_history_data;
        }
        $data['year_catering_product_history_data']=$year_catering_product_history_data;


        $curr_year = $year-4;
        $yeardata=array();
        for($y=0;$y<=4;$y++){
          $yeardata[$y] = $curr_year;
          $curr_year++;
        }
        $data['year_data']=$yeardata;


        return view('admin.dashboard.yearlyadmindashboard')->with($data);
      }

}
