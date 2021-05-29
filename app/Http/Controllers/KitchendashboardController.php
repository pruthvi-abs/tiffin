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

class KitchendashboardController extends Controller
{

    public function index(){
    	  $data['webpage']='Kitchen Dashboard';
        $data['action']='Kitchen Dashboard';
        $data['menu']='';
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

        return view('admin.dashboard.kitchendashboard')->with($data);
    }

}
