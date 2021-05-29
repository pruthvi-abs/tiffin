<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;
use App\Order;
use App\Orderpayments;
use App\Orderproduct;
use PDF;

class OrderController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='All Orders';
        $data['action']='All Orders';
        $data['menu']='master';
        return view('admin.order.index')->with($data);
    }
    function getOrder()
    {
      $customthemesetting = customthemesetting();
        $orders=Order::select('id','main_categories_id','users_email','name','mobile','coupon_code','coupon_amount','payment_method','order_status','amount_received','payer_id','grand_total','delivery_date','order_pickup','created_at')->orderByDesc('delivery_date')->get();
        $Order_data=array();
        $i=1;
        foreach($orders as $Order){
          $Order_data[$i]['sr_no']=$i;
          $Order_data[$i]['ord_id']="#".$Order->id;

          // Not Use ( Same logic implement in frontend )
            $cancel="No";
            if($Order->main_categories_id==1){
              //tiffin
                $cutofftime = $customthemesetting->order_cutoff_time;
                $delivery_date = Carbon::parse($Order->delivery_date)->format('Y-m-d');
                if($delivery_date>date("Y-m-d")){
                  if($cutofftime>date("H:i:s")){
                    $cancel="Yes";
                  }
                }
            }elseif($Order->main_categories_id==2){
              //catering
              $cu = $customthemesetting->catering_cancel_cutoff_time;
              $fdate=date('Y-m-d H:i:s');
              $cutoffdate = Carbon::parse($fdate)->addHours($cu)->format('Y-m-d H:i:s');
              if($Order->delivery_date > $cutoffdate){
                $cancel="Yes";
              }
            }else{
              //Menu
              if($Order->delivery_date > date("Y-m-d H:i:s")){
                $cancel="Yes";
              }
            }

          $Order_data[$i]['id']=$Order->id.",".$Order->order_pickup.",".$Order->order_status;
          $Order_data[$i]['users_email']=$Order->users_email;
          $Order_data[$i]['name']=$Order->name;
          $Order_data[$i]['mobile']=$Order->mobile;
          $Order_data[$i]['coupon_code']=$Order->coupon_code;
          $Order_data[$i]['coupon_amount']=$customthemesetting->currency.$Order->coupon_amount;
          if($Order->payment_method=="Paypal"){
            $Order_data[$i]['payment_method']=$Order->payment_method." (".$Order->payer_id.")";
          }else{
            $Order_data[$i]['payment_method']=$Order->payment_method;
          }
          $Order_data[$i]['order_status']=$Order->order_status;
          /*if($Order->order_status=="Accepted" || $Order->order_status=="Rejected"){$Order_data[$i]['s_id']="";}else{$Order_data[$i]['s_id']=$Order->id;}*/
          $Order_data[$i]['grand_total']=$customthemesetting->currency.$Order->grand_total;
          $Order_data[$i]['delivery_date']=Carbon::parse($Order->delivery_date)->format($customthemesetting->datetime_format);

          $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Paid")->orderByDesc('id')->get();
          $amount_count=0;
          foreach($orderpayments as $orderpayment){
            $amount_count=$amount_count+$orderpayment->payment_amount;
          }

          $payment_s = "";
          // Pay & Refund Logic
          if($Order->order_status=="Canceled"){
            /*
            if($Order->payment_method=="Paypal"){
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }

              if($aaamount_count>=$amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refunded";
                $payment_s="Refunded";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }
            }else{
            */
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }
              if($amount_count<=0){
                $Order_data[$i]['p_id']=$Order->id.",Canceled";
                $payment_s="Canceled";
              }else{
                if($aaamount_count>=$amount_count){
                  $Order_data[$i]['p_id']=$Order->id.",Refunded";
                  $payment_s="Refunded";
                }else{
                  $Order_data[$i]['p_id']=$Order->id.",Refund";
                  $payment_s="Refund";
                }
              }
            //}
          }else{
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }else{
              if($Order->grand_total < $f_amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }else{
                //if($Order->amount_received=="No"){
                    $Order_data[$i]['p_id']=$Order->id.",Pay";
                    $payment_s="Pay";
                /*}else{
                  $Order_data[$i]['p_id']=$Order->id.",Paid";
                  $payment_s="Paid";
                }*/
              }
            }

            /*
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }elseif($aaamount_count>$amount_count){
              $Order_data[$i]['p_id']=$Order->id.",Refunded";
              $payment_s="Refunded";
            }else{
              if($Order->amount_received=="No"){
                  $Order_data[$i]['p_id']=$Order->id.",Pay";
                  $payment_s="Pay";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Paid";
                $payment_s="Paid";
              }
            }
            */


          }

          if($Order->order_status=="Canceled"){
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            if($amount_count==0){
              $remaining_total_amt = $amount_count;
            }else{
              $remaining_total_amt = $amount_count-$aaamount_count;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;

          }else{
            //$remaining_total_amt = $Order->grand_total - $amount_count;
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==0){
              $remaining_total_amt =  $Order->grand_total-$amount_count;
            }elseif($Order->grand_total > $f_amount_count){
              $remaining_total_amt =  $Order->grand_total-($amount_count-$aaamount_count);
            }else{
              $remaining_total_amt =  ($amount_count-$aaamount_count)-$Order->grand_total;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;
          }


          $Order_data[$i]['order_pickup']=$Order->id.",".$Order->order_pickup.",".$Order->order_status.",".$payment_s;
          if($Order->amount_received=="Yes"){
            $Order_data[$i]['amount_received']="Paid";
          }else{
            $Order_data[$i]['amount_received']="Unpaid";
          }
          if($Order->main_categories_id==1){
            $Order_data[$i]['main_categories_id']="Tiffin";
          }elseif($Order->main_categories_id==2){
            $Order_data[$i]['main_categories_id']="Catering";
          }else{
            $Order_data[$i]['main_categories_id']="Menu";
          }
          $Order_data[$i]['created_at']=Carbon::parse($Order->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Order_data)->make(true);
    }

    // Today Order
    public function todayorder()
    {
        //
        $data['webpage']='Todays Orders';
        $data['action']='Todays Orders';
        $data['menu']='master';
        return view('admin.order.todayindex')->with($data);
    }
    function getTodayOrder()
    {
      $customthemesetting = customthemesetting();
        $fromdate = Carbon::today()->format('Y-m-d H:i:s');
        $todate = Carbon::parse($fromdate)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $orders=Order::select('id','main_categories_id','users_email','name','mobile','coupon_code','coupon_amount','payment_method','order_status','amount_received','payer_id','grand_total','delivery_date','order_pickup','created_at')
                        ->where('delivery_date','>=',$fromdate)
                        ->where('delivery_date','<=',$todate)
                        ->orderBy('name')
                        ->get();
        $Order_data=array();
        $i=1;
        foreach($orders as $Order){
          $Order_data[$i]['sr_no']=$i;
          $Order_data[$i]['ord_id']="#".$Order->id;

          // Not Use ( Same logic implement in frontend )
            $cancel="No";
            if($Order->main_categories_id==1){
              //tiffin
                $cutofftime = $customthemesetting->order_cutoff_time;
                $delivery_date = Carbon::parse($Order->delivery_date)->format('Y-m-d');
                if($delivery_date>date("Y-m-d")){
                  if($cutofftime>date("H:i:s")){
                    $cancel="Yes";
                  }
                }
            }elseif($Order->main_categories_id==2){
              //catering
              $cu = $customthemesetting->catering_cancel_cutoff_time;
              $fdate=date('Y-m-d H:i:s');
              $cutoffdate = Carbon::parse($fdate)->addHours($cu)->format('Y-m-d H:i:s');
              if($Order->delivery_date > $cutoffdate){
                $cancel="Yes";
              }
            }else{
              //Menu
              if($Order->delivery_date > date("Y-m-d H:i:s")){
                $cancel="Yes";
              }
            }

          $Order_data[$i]['id']=$Order->id.",".$Order->order_pickup.",".$Order->order_status;
          $Order_data[$i]['users_email']=$Order->users_email;
          $Order_data[$i]['name']=$Order->name;
          $Order_data[$i]['mobile']=$Order->mobile;
          $Order_data[$i]['coupon_code']=$Order->coupon_code;
          $Order_data[$i]['coupon_amount']=$customthemesetting->currency.$Order->coupon_amount;
          if($Order->payment_method=="Paypal"){
            $Order_data[$i]['payment_method']=$Order->payment_method." (".$Order->payer_id.")";
          }else{
            $Order_data[$i]['payment_method']=$Order->payment_method;
          }
          $Order_data[$i]['order_status']=$Order->order_status;
          /*if($Order->order_status=="Accepted" || $Order->order_status=="Rejected"){$Order_data[$i]['s_id']="";}else{$Order_data[$i]['s_id']=$Order->id;}*/
          $Order_data[$i]['grand_total']=$customthemesetting->currency.$Order->grand_total;
          $Order_data[$i]['delivery_date']=Carbon::parse($Order->delivery_date)->format($customthemesetting->datetime_format);

          $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Paid")->orderByDesc('id')->get();
          $amount_count=0;
          foreach($orderpayments as $orderpayment){
            $amount_count=$amount_count+$orderpayment->payment_amount;
          }

          $payment_s = "";
          // Pay & Refund Logic
          if($Order->order_status=="Canceled"){
            /*
            if($Order->payment_method=="Paypal"){
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }

              if($aaamount_count>=$amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refunded";
                $payment_s="Refunded";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }
            }else{
            */
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }
              if($amount_count<=0){
                $Order_data[$i]['p_id']=$Order->id.",Canceled";
                $payment_s="Canceled";
              }else{
                if($aaamount_count>=$amount_count){
                  $Order_data[$i]['p_id']=$Order->id.",Refunded";
                  $payment_s="Refunded";
                }else{
                  $Order_data[$i]['p_id']=$Order->id.",Refund";
                  $payment_s="Refund";
                }
              }
            //}
          }else{
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }else{
              if($Order->grand_total < $f_amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }else{
                //if($Order->amount_received=="No"){
                    $Order_data[$i]['p_id']=$Order->id.",Pay";
                    $payment_s="Pay";
                /*}else{
                  $Order_data[$i]['p_id']=$Order->id.",Paid";
                  $payment_s="Paid";
                }*/
              }
            }

            /*
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }elseif($aaamount_count>$amount_count){
              $Order_data[$i]['p_id']=$Order->id.",Refunded";
              $payment_s="Refunded";
            }else{
              if($Order->amount_received=="No"){
                  $Order_data[$i]['p_id']=$Order->id.",Pay";
                  $payment_s="Pay";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Paid";
                $payment_s="Paid";
              }
            }
            */


          }

          if($Order->order_status=="Canceled"){
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            if($amount_count==0){
              $remaining_total_amt = $amount_count;
            }else{
              $remaining_total_amt = $amount_count-$aaamount_count;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;

          }else{
            //$remaining_total_amt = $Order->grand_total - $amount_count;
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==0){
              $remaining_total_amt =  $Order->grand_total-$amount_count;
            }elseif($Order->grand_total > $f_amount_count){
              $remaining_total_amt =  $Order->grand_total-($amount_count-$aaamount_count);
            }else{
              $remaining_total_amt =  ($amount_count-$aaamount_count)-$Order->grand_total;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;
          }


          $Order_data[$i]['order_pickup']=$Order->id.",".$Order->order_pickup.",".$Order->order_status.",".$payment_s;
          if($Order->amount_received=="Yes"){
            $Order_data[$i]['amount_received']="Paid";
          }else{
            $Order_data[$i]['amount_received']="Unpaid";
          }
          if($Order->main_categories_id==1){
            $Order_data[$i]['main_categories_id']="Tiffin";
          }elseif($Order->main_categories_id==2){
            $Order_data[$i]['main_categories_id']="Catering";
          }else{
            $Order_data[$i]['main_categories_id']="Menu";
          }
          $Order_data[$i]['created_at']=Carbon::parse($Order->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Order_data)->make(true);
    }

    // Tomorrow Order
    public function tomorroworder()
    {
        //
        $data['webpage']='Tomorrow Orders';
        $data['action']='Tomorrow Orders';
        $data['menu']='master';
        return view('admin.order.tomorrowindex')->with($data);
    }
    function getTomorrowOrder()
    {
      $customthemesetting = customthemesetting();
        $fromdate = date('Y-m-d', strtotime('+1 days'));
        $todate = Carbon::tomorrow()->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $orders=Order::select('id','main_categories_id','users_email','name','mobile','coupon_code','coupon_amount','payment_method','order_status','amount_received','payer_id','grand_total','delivery_date','order_pickup','created_at')
                        ->where('delivery_date','>=',$fromdate)
                        ->where('delivery_date','<=',$todate)
                        ->orderBy('name')
                        ->get();
        $Order_data=array();
        $i=1;
        foreach($orders as $Order){
          $Order_data[$i]['sr_no']=$i;
          $Order_data[$i]['ord_id']="#".$Order->id;

          // Not Use ( Same logic implement in frontend )
            $cancel="No";
            if($Order->main_categories_id==1){
              //tiffin
                $cutofftime = $customthemesetting->order_cutoff_time;
                $delivery_date = Carbon::parse($Order->delivery_date)->format('Y-m-d');
                if($delivery_date>date("Y-m-d")){
                  if($cutofftime>date("H:i:s")){
                    $cancel="Yes";
                  }
                }
            }elseif($Order->main_categories_id==2){
              //catering
              $cu = $customthemesetting->catering_cancel_cutoff_time;
              $fdate=date('Y-m-d H:i:s');
              $cutoffdate = Carbon::parse($fdate)->addHours($cu)->format('Y-m-d H:i:s');
              if($Order->delivery_date > $cutoffdate){
                $cancel="Yes";
              }
            }else{
              //Menu
              if($Order->delivery_date > date("Y-m-d H:i:s")){
                $cancel="Yes";
              }
            }

          $Order_data[$i]['id']=$Order->id.",".$Order->order_pickup.",".$Order->order_status;
          $Order_data[$i]['users_email']=$Order->users_email;
          $Order_data[$i]['name']=$Order->name;
          $Order_data[$i]['mobile']=$Order->mobile;
          $Order_data[$i]['coupon_code']=$Order->coupon_code;
          $Order_data[$i]['coupon_amount']=$customthemesetting->currency.$Order->coupon_amount;
          if($Order->payment_method=="Paypal"){
            $Order_data[$i]['payment_method']=$Order->payment_method." (".$Order->payer_id.")";
          }else{
            $Order_data[$i]['payment_method']=$Order->payment_method;
          }
          $Order_data[$i]['order_status']=$Order->order_status;
          /*if($Order->order_status=="Accepted" || $Order->order_status=="Rejected"){$Order_data[$i]['s_id']="";}else{$Order_data[$i]['s_id']=$Order->id;}*/
          $Order_data[$i]['grand_total']=$customthemesetting->currency.$Order->grand_total;
          $Order_data[$i]['delivery_date']=Carbon::parse($Order->delivery_date)->format($customthemesetting->datetime_format);

          $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Paid")->orderByDesc('id')->get();
          $amount_count=0;
          foreach($orderpayments as $orderpayment){
            $amount_count=$amount_count+$orderpayment->payment_amount;
          }

          $payment_s = "";
          // Pay & Refund Logic
          if($Order->order_status=="Canceled"){
            /*
            if($Order->payment_method=="Paypal"){
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }

              if($aaamount_count>=$amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refunded";
                $payment_s="Refunded";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }
            }else{
            */
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }
              if($amount_count<=0){
                $Order_data[$i]['p_id']=$Order->id.",Canceled";
                $payment_s="Canceled";
              }else{
                if($aaamount_count>=$amount_count){
                  $Order_data[$i]['p_id']=$Order->id.",Refunded";
                  $payment_s="Refunded";
                }else{
                  $Order_data[$i]['p_id']=$Order->id.",Refund";
                  $payment_s="Refund";
                }
              }
            //}
          }else{
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }else{
              if($Order->grand_total < $f_amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }else{
                //if($Order->amount_received=="No"){
                    $Order_data[$i]['p_id']=$Order->id.",Pay";
                    $payment_s="Pay";
                /*}else{
                  $Order_data[$i]['p_id']=$Order->id.",Paid";
                  $payment_s="Paid";
                }*/
              }
            }

            /*
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }elseif($aaamount_count>$amount_count){
              $Order_data[$i]['p_id']=$Order->id.",Refunded";
              $payment_s="Refunded";
            }else{
              if($Order->amount_received=="No"){
                  $Order_data[$i]['p_id']=$Order->id.",Pay";
                  $payment_s="Pay";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Paid";
                $payment_s="Paid";
              }
            }
            */


          }

          if($Order->order_status=="Canceled"){
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            if($amount_count==0){
              $remaining_total_amt = $amount_count;
            }else{
              $remaining_total_amt = $amount_count-$aaamount_count;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;

          }else{
            //$remaining_total_amt = $Order->grand_total - $amount_count;
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==0){
              $remaining_total_amt =  $Order->grand_total-$amount_count;
            }elseif($Order->grand_total > $f_amount_count){
              $remaining_total_amt =  $Order->grand_total-($amount_count-$aaamount_count);
            }else{
              $remaining_total_amt =  ($amount_count-$aaamount_count)-$Order->grand_total;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;
          }


          $Order_data[$i]['order_pickup']=$Order->id.",".$Order->order_pickup.",".$Order->order_status.",".$payment_s;
          if($Order->amount_received=="Yes"){
            $Order_data[$i]['amount_received']="Paid";
          }else{
            $Order_data[$i]['amount_received']="Unpaid";
          }
          if($Order->main_categories_id==1){
            $Order_data[$i]['main_categories_id']="Tiffin";
          }elseif($Order->main_categories_id==2){
            $Order_data[$i]['main_categories_id']="Catering";
          }else{
            $Order_data[$i]['main_categories_id']="Menu";
          }
          $Order_data[$i]['created_at']=Carbon::parse($Order->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Order_data)->make(true);
    }

    // Next Week Order
    public function nextweekorder()
    {
        //
        $data['webpage']='Next 7 Days Orders';
        $data['action']='Next 7 Days Orders';
        $data['menu']='master';
        return view('admin.order.nextweekindex')->with($data);
    }
    function getNextWeekOrder()
    {
      $customthemesetting = customthemesetting();
        $fromdate = date('Y-m-d', strtotime('+1 days'));
        $todate = date('Y-m-d', strtotime('+7 days'));
        $orders=Order::select('id','main_categories_id','users_email','name','mobile','coupon_code','coupon_amount','payment_method','order_status','amount_received','payer_id','grand_total','delivery_date','order_pickup','created_at')
                        ->where('delivery_date','>=',$fromdate)
                        ->where('delivery_date','<=',$todate)
                        ->orderBy('name')
                        ->get();
        $Order_data=array();
        $i=1;
        foreach($orders as $Order){
          $Order_data[$i]['sr_no']=$i;
          $Order_data[$i]['ord_id']="#".$Order->id;

          // Not Use ( Same logic implement in frontend )
            $cancel="No";
            if($Order->main_categories_id==1){
              //tiffin
                $cutofftime = $customthemesetting->order_cutoff_time;
                $delivery_date = Carbon::parse($Order->delivery_date)->format('Y-m-d');
                if($delivery_date>date("Y-m-d")){
                  if($cutofftime>date("H:i:s")){
                    $cancel="Yes";
                  }
                }
            }elseif($Order->main_categories_id==2){
              //catering
              $cu = $customthemesetting->catering_cancel_cutoff_time;
              $fdate=date('Y-m-d H:i:s');
              $cutoffdate = Carbon::parse($fdate)->addHours($cu)->format('Y-m-d H:i:s');
              if($Order->delivery_date > $cutoffdate){
                $cancel="Yes";
              }
            }else{
              //Menu
              if($Order->delivery_date > date("Y-m-d H:i:s")){
                $cancel="Yes";
              }
            }

          $Order_data[$i]['id']=$Order->id.",".$Order->order_pickup.",".$Order->order_status;
          $Order_data[$i]['users_email']=$Order->users_email;
          $Order_data[$i]['name']=$Order->name;
          $Order_data[$i]['mobile']=$Order->mobile;
          $Order_data[$i]['coupon_code']=$Order->coupon_code;
          $Order_data[$i]['coupon_amount']=$customthemesetting->currency.$Order->coupon_amount;
          if($Order->payment_method=="Paypal"){
            $Order_data[$i]['payment_method']=$Order->payment_method." (".$Order->payer_id.")";
          }else{
            $Order_data[$i]['payment_method']=$Order->payment_method;
          }
          $Order_data[$i]['order_status']=$Order->order_status;
          /*if($Order->order_status=="Accepted" || $Order->order_status=="Rejected"){$Order_data[$i]['s_id']="";}else{$Order_data[$i]['s_id']=$Order->id;}*/
          $Order_data[$i]['grand_total']=$customthemesetting->currency.$Order->grand_total;
          $Order_data[$i]['delivery_date']=Carbon::parse($Order->delivery_date)->format($customthemesetting->datetime_format);

          $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Paid")->orderByDesc('id')->get();
          $amount_count=0;
          foreach($orderpayments as $orderpayment){
            $amount_count=$amount_count+$orderpayment->payment_amount;
          }

          $payment_s = "";
          // Pay & Refund Logic
          if($Order->order_status=="Canceled"){
            /*
            if($Order->payment_method=="Paypal"){
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }

              if($aaamount_count>=$amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refunded";
                $payment_s="Refunded";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }
            }else{
            */
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }
              if($amount_count<=0){
                $Order_data[$i]['p_id']=$Order->id.",Canceled";
                $payment_s="Canceled";
              }else{
                if($aaamount_count>=$amount_count){
                  $Order_data[$i]['p_id']=$Order->id.",Refunded";
                  $payment_s="Refunded";
                }else{
                  $Order_data[$i]['p_id']=$Order->id.",Refund";
                  $payment_s="Refund";
                }
              }
            //}
          }else{
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }else{
              if($Order->grand_total < $f_amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }else{
                //if($Order->amount_received=="No"){
                    $Order_data[$i]['p_id']=$Order->id.",Pay";
                    $payment_s="Pay";
                /*}else{
                  $Order_data[$i]['p_id']=$Order->id.",Paid";
                  $payment_s="Paid";
                }*/
              }
            }

            /*
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }elseif($aaamount_count>$amount_count){
              $Order_data[$i]['p_id']=$Order->id.",Refunded";
              $payment_s="Refunded";
            }else{
              if($Order->amount_received=="No"){
                  $Order_data[$i]['p_id']=$Order->id.",Pay";
                  $payment_s="Pay";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Paid";
                $payment_s="Paid";
              }
            }
            */


          }

          if($Order->order_status=="Canceled"){
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            if($amount_count==0){
              $remaining_total_amt = $amount_count;
            }else{
              $remaining_total_amt = $amount_count-$aaamount_count;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;

          }else{
            //$remaining_total_amt = $Order->grand_total - $amount_count;
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==0){
              $remaining_total_amt =  $Order->grand_total-$amount_count;
            }elseif($Order->grand_total > $f_amount_count){
              $remaining_total_amt =  $Order->grand_total-($amount_count-$aaamount_count);
            }else{
              $remaining_total_amt =  ($amount_count-$aaamount_count)-$Order->grand_total;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;
          }


          $Order_data[$i]['order_pickup']=$Order->id.",".$Order->order_pickup.",".$Order->order_status.",".$payment_s;
          if($Order->amount_received=="Yes"){
            $Order_data[$i]['amount_received']="Paid";
          }else{
            $Order_data[$i]['amount_received']="Unpaid";
          }
          if($Order->main_categories_id==1){
            $Order_data[$i]['main_categories_id']="Tiffin";
          }elseif($Order->main_categories_id==2){
            $Order_data[$i]['main_categories_id']="Catering";
          }else{
            $Order_data[$i]['main_categories_id']="Menu";
          }
          $Order_data[$i]['created_at']=Carbon::parse($Order->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Order_data)->make(true);
    }

    // Next Month Order
    public function nextmonthorder()
    {
        //
        $data['webpage']='Next 30 Days Orders';
        $data['action']='Next 30 Days Orders';
        $data['menu']='master';
        return view('admin.order.nextmonthindex')->with($data);
    }
    function getNextmonthOrder()
    {
      $customthemesetting = customthemesetting();
        $fromdate = date('Y-m-d', strtotime('+1 days'));
        $todate = date('Y-m-d', strtotime('+30 days'));
        $orders=Order::select('id','main_categories_id','users_email','name','mobile','coupon_code','coupon_amount','payment_method','order_status','amount_received','payer_id','grand_total','delivery_date','order_pickup','created_at')
                        ->where('delivery_date','>=',$fromdate)
                        ->where('delivery_date','<=',$todate)
                        ->orderBy('name')
                        ->get();
        $Order_data=array();
        $i=1;
        foreach($orders as $Order){
          $Order_data[$i]['sr_no']=$i;
          $Order_data[$i]['ord_id']="#".$Order->id;

          // Not Use ( Same logic implement in frontend )
            $cancel="No";
            if($Order->main_categories_id==1){
              //tiffin
                $cutofftime = $customthemesetting->order_cutoff_time;
                $delivery_date = Carbon::parse($Order->delivery_date)->format('Y-m-d');
                if($delivery_date>date("Y-m-d")){
                  if($cutofftime>date("H:i:s")){
                    $cancel="Yes";
                  }
                }
            }elseif($Order->main_categories_id==2){
              //catering
              $cu = $customthemesetting->catering_cancel_cutoff_time;
              $fdate=date('Y-m-d H:i:s');
              $cutoffdate = Carbon::parse($fdate)->addHours($cu)->format('Y-m-d H:i:s');
              if($Order->delivery_date > $cutoffdate){
                $cancel="Yes";
              }
            }else{
              //Menu
              if($Order->delivery_date > date("Y-m-d H:i:s")){
                $cancel="Yes";
              }
            }

          $Order_data[$i]['id']=$Order->id.",".$Order->order_pickup.",".$Order->order_status;
          $Order_data[$i]['users_email']=$Order->users_email;
          $Order_data[$i]['name']=$Order->name;
          $Order_data[$i]['mobile']=$Order->mobile;
          $Order_data[$i]['coupon_code']=$Order->coupon_code;
          $Order_data[$i]['coupon_amount']=$customthemesetting->currency.$Order->coupon_amount;
          if($Order->payment_method=="Paypal"){
            $Order_data[$i]['payment_method']=$Order->payment_method." (".$Order->payer_id.")";
          }else{
            $Order_data[$i]['payment_method']=$Order->payment_method;
          }
          $Order_data[$i]['order_status']=$Order->order_status;
          /*if($Order->order_status=="Accepted" || $Order->order_status=="Rejected"){$Order_data[$i]['s_id']="";}else{$Order_data[$i]['s_id']=$Order->id;}*/
          $Order_data[$i]['grand_total']=$customthemesetting->currency.$Order->grand_total;
          $Order_data[$i]['delivery_date']=Carbon::parse($Order->delivery_date)->format($customthemesetting->datetime_format);

          $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Paid")->orderByDesc('id')->get();
          $amount_count=0;
          foreach($orderpayments as $orderpayment){
            $amount_count=$amount_count+$orderpayment->payment_amount;
          }

          $payment_s = "";
          // Pay & Refund Logic
          if($Order->order_status=="Canceled"){
            /*
            if($Order->payment_method=="Paypal"){
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }

              if($aaamount_count>=$amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refunded";
                $payment_s="Refunded";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }
            }else{
            */
              $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
              $aaamount_count=0;
              foreach($orderpayments as $orderpayment){
                $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
              }
              if($amount_count<=0){
                $Order_data[$i]['p_id']=$Order->id.",Canceled";
                $payment_s="Canceled";
              }else{
                if($aaamount_count>=$amount_count){
                  $Order_data[$i]['p_id']=$Order->id.",Refunded";
                  $payment_s="Refunded";
                }else{
                  $Order_data[$i]['p_id']=$Order->id.",Refund";
                  $payment_s="Refund";
                }
              }
            //}
          }else{
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }else{
              if($Order->grand_total < $f_amount_count){
                $Order_data[$i]['p_id']=$Order->id.",Refund";
                $payment_s="Refund";
              }else{
                //if($Order->amount_received=="No"){
                    $Order_data[$i]['p_id']=$Order->id.",Pay";
                    $payment_s="Pay";
                /*}else{
                  $Order_data[$i]['p_id']=$Order->id.",Paid";
                  $payment_s="Paid";
                }*/
              }
            }

            /*
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==$Order->grand_total){
              $Order_data[$i]['p_id']=$Order->id.",Paid";
              $payment_s="Paid";
            }elseif($aaamount_count>$amount_count){
              $Order_data[$i]['p_id']=$Order->id.",Refunded";
              $payment_s="Refunded";
            }else{
              if($Order->amount_received=="No"){
                  $Order_data[$i]['p_id']=$Order->id.",Pay";
                  $payment_s="Pay";
              }else{
                $Order_data[$i]['p_id']=$Order->id.",Paid";
                $payment_s="Paid";
              }
            }
            */


          }

          if($Order->order_status=="Canceled"){
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            if($amount_count==0){
              $remaining_total_amt = $amount_count;
            }else{
              $remaining_total_amt = $amount_count-$aaamount_count;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;

          }else{
            //$remaining_total_amt = $Order->grand_total - $amount_count;
            $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$Order->id)->where('payment_status',"Refund")->orderByDesc('id')->get();
            $aaamount_count=0;
            foreach($orderpayments as $orderpayment){
              $aaamount_count=$aaamount_count+$orderpayment->payment_amount;
            }
            $f_amount_count = $amount_count-$aaamount_count;
            if($f_amount_count==0){
              $remaining_total_amt =  $Order->grand_total-$amount_count;
            }elseif($Order->grand_total > $f_amount_count){
              $remaining_total_amt =  $Order->grand_total-($amount_count-$aaamount_count);
            }else{
              $remaining_total_amt =  ($amount_count-$aaamount_count)-$Order->grand_total;
            }
            $Order_data[$i]['remaining_total_amt']=$customthemesetting->currency.$remaining_total_amt;
          }


          $Order_data[$i]['order_pickup']=$Order->id.",".$Order->order_pickup.",".$Order->order_status.",".$payment_s;
          if($Order->amount_received=="Yes"){
            $Order_data[$i]['amount_received']="Paid";
          }else{
            $Order_data[$i]['amount_received']="Unpaid";
          }
          if($Order->main_categories_id==1){
            $Order_data[$i]['main_categories_id']="Tiffin";
          }elseif($Order->main_categories_id==2){
            $Order_data[$i]['main_categories_id']="Catering";
          }else{
            $Order_data[$i]['main_categories_id']="Menu";
          }
          $Order_data[$i]['created_at']=Carbon::parse($Order->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Order_data)->make(true);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        //
        $data['webpage']='Orders';
        $data['action']='Orders';
        $data['menu']='master';
        $data['orders']=Order::where('id',$id)->first();
        $data['orderproduct']=Orderproduct::where('order_id',$id)->get();
        $data['orderpayment']=Orderpayments::where('order_id',$id)->orderByDesc('id')->get();
        return view('admin.order.view')->with($data);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
    }
    public function deleteorderpayments($id)
    {
      $order_data = Orderpayments::select('order_id')->where('id',$id)->first();
      // Orders back transaction
      $orders=Order::findOrFail($order_data->order_id);
      $orders->amount_received = "No";
      $orders->save();
      // order payment delete
      $orderpayments=Orderpayments::findOrFail($id)->delete();
      $error=0;
      return $error;
    }
    /* -------------------------------------- */
    public function editorderproduct($id,Request $request)
    {
      $order_product_data = Orderproduct::findOrFail($id);
      $old_qty = $order_product_data->p_qty;
      $order_product_data->p_qty = $request->p_qty;
      $p_price = $old_qty*$order_product_data->p_price;
      $order_product_data->save();

      $order_products_data = Orderproduct::select('p_price','p_qty')->where('order_id',$request->order_id)->get();
      $finalamount=0;
      for($k=0;$k<count($order_products_data);$k++){
        $finalamount=$finalamount+$order_products_data[$k]->p_qty*$order_products_data[$k]->p_price;
      }

      $orders=Order::findOrFail($request->order_id);
      $orders->grand_total=$finalamount;
      $orders->save();

      return redirect('order/'.$request->order_id)->with('success','Product cart updated successfully');
    }

    public function editorderproductcatering(Request $request)
    {
      $order_products_data = Orderproduct::select('id','p_price','p_qty')->where('order_id',$request->order_id)->get();
      $finalamount=0;
      for($k=0;$k<count($order_products_data);$k++){
        $order_product_data = Orderproduct::findOrFail($order_products_data[$k]->id);
        $order_product_data->p_qty = $request->p_qty;
        $order_product_data->save();
        $finalamount=$finalamount+$request->p_qty*$order_products_data[$k]->p_price;
      }

      $orders=Order::findOrFail($request->order_id);
      $orders->grand_total=$finalamount;
      $orders->save();
      return redirect('order/'.$request->order_id)->with('success','Product cart updated successfully');
    }

    public function deleteorderproduct($id,Request $request)
    {
      $orderpayments=Orderproduct::findOrFail($id)->delete();

      $total_order_products_data = Orderproduct::select('p_price','p_qty')->where('order_id',$request->order_id)->get();
      $finalamount=0;
      for($k=0;$k<count($total_order_products_data);$k++){
        $finalamount=$finalamount+$total_order_products_data[$k]->p_qty*$total_order_products_data[$k]->p_price;
      }
      $orders=Order::findOrFail($request->order_id);
      $orders->grand_total=$finalamount;
      $orders->save();
      $error=0;
      return $error;
    }

    public function refundorderpaid(Request $request)
    {
      $customthemesetting = customthemesetting();

      $order_payment = new Orderpayments;
      $order_payment->order_id = $request->refund_order_id;
      $order_payment->payment_type = $request->refund_payment_type;
      $order_payment->payment_details = $request->refund_payment_details;
      $order_payment->payment_amount = $request->refund_payment_amount;
      $order_payment->payment_date = Carbon::parse($request->refund_payment_date)->format('Y-m-d H:i:s');
      $order_payment->notes = $request->refund_notes;
      $order_payment->payment_status = $request->refund_payment_status;
      $order_payment->save();

      $order_amt_rec = Order::findOrFail($request->refund_order_id);
      $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('payment_status',"Paid")->where('order_id',$request->order_id)->orderByDesc('id')->get();
      $amount_count=0;
      foreach($orderpayments as $orderpayment){
        $amount_count=$amount_count+$orderpayment->r_payment_amount;
      }
      if($amount_count>=$order_amt_rec->grand_total){
        $order_amt_rec->amount_received="Yes";
        $order_amt_rec->save();
      }else{
        $order_amt_rec->amount_received="No";
        $order_amt_rec->save();
      }

      return redirect('order/'.$request->refund_order_id)->with('success','Payment Refund information added successfully');
    }

    public function backaddtiffinproduct(Request $request){

    }
    public function backaddmenuproduct(Request $request){
      $find_order_products_data = Orderproduct::where('order_id',$request->curr_order_id)->where('p_id',$request->product_id)->count();
      if($find_order_products_data<=0){
          $order_product_data = new Orderproduct;
          $order_product_data->order_id = $request->curr_order_id;
          $order_product_data->p_id = $request->product_id;
          $order_product_data->p_code = $request->p_code;
          $order_product_data->p_name = $request->p_name;
          $order_product_data->p_price = $request->p_price;
          $order_product_data->p_qty = $request->p_qty;
          $order_product_data->save();
      }else{
          $find_id = Orderproduct::select('id')->where('order_id',$request->curr_order_id)->where('p_id',$request->product_id)->first();
          $order_product_data = Orderproduct::findOrFail($find_id->id);
          $order_product_data->p_code = $request->p_code;
          $order_product_data->p_name = $request->p_name;
          $order_product_data->p_price = $request->p_price;
          $order_product_data->p_qty = $request->p_qty;
          $order_product_data->save();
      }

      $total_order_products_data = Orderproduct::select('p_price','p_qty')->where('order_id',$request->curr_order_id)->get();
      $finalamount=0;
      for($k=0;$k<count($total_order_products_data);$k++){
        $finalamount=$finalamount+$total_order_products_data[$k]->p_qty*$total_order_products_data[$k]->p_price;
      }

      $orders=Order::findOrFail($request->curr_order_id);
      $orders->grand_total=$finalamount;
      $orders->save();

      return redirect('order/'.$request->curr_order_id)->with('success','Product cart updated successfully');
    }
    public function backaddcateringproduct(Request $request){
      $find_order_products_data = Orderproduct::where('order_id',$request->curr_order_id)->where('p_id',$request->product_id)->count();
      if($find_order_products_data<=0){
          $order_product_data = new Orderproduct;
          $order_product_data->order_id = $request->curr_order_id;
          $order_product_data->p_id = $request->product_id;
          $order_product_data->p_code = $request->p_code;
          $order_product_data->p_name = $request->p_name;
          $order_product_data->p_price = $request->p_price;
          $order_product_data->p_qty = $request->p_qty;
          $order_product_data->save();
      }else{
          $find_id = Orderproduct::select('id')->where('order_id',$request->curr_order_id)->where('p_id',$request->product_id)->first();
          $order_product_data = Orderproduct::findOrFail($find_id->id);
          $order_product_data->p_code = $request->p_code;
          $order_product_data->p_name = $request->p_name;
          $order_product_data->p_price = $request->p_price;
          $order_product_data->p_qty = $request->p_qty;
          $order_product_data->save();
      }

      $total_order_products_data = Orderproduct::select('p_price','p_qty')->where('order_id',$request->curr_order_id)->get();
      $finalamount=0;
      for($k=0;$k<count($total_order_products_data);$k++){
        $finalamount=$finalamount+$total_order_products_data[$k]->p_qty*$total_order_products_data[$k]->p_price;
      }

      $orders=Order::findOrFail($request->curr_order_id);
      $orders->grand_total=$finalamount;
      $orders->save();

      return redirect('order/'.$request->curr_order_id)->with('success','Product cart updated successfully');
    }

    /* -------------------------------- */

    public function orderpick(Request $request, $id)
    {
      $customthemesetting = customthemesetting();
      if($request->order_pickup=="No"){
        $order_paid = Order::findOrFail($request->order_id);
        $order_paid->amount_received = "Yes";
        $order_paid->order_pickup = "Yes";
        $order_paid->order_status = "Picked up";
        $order_paid->save();
      }else{
        $order_paid = Order::findOrFail($request->order_id);
        $order_paid->order_pickup = "No";
        $order_paid->order_status = "Accepted";
        $order_paid->save();
      }
      $error=0;
      return $error;
      //return redirect('order')->with('success','Payment information added successfully');
    }

    public function orderpaid(Request $request, $id)
    {
      $customthemesetting = customthemesetting();

      $order_payment = new Orderpayments;
      $order_payment->order_id = $request->order_id;
      $order_payment->payment_type = $request->payment_type;
      //$order_payment->account_type = $request->account_type;
      $order_payment->payment_details = $request->payment_details;
      $order_payment->payment_amount = $request->payment_amount;
      $order_payment->payment_date = Carbon::parse($request->payment_date)->format('Y-m-d H:i:s');
      $order_payment->notes = $request->notes;
      $order_payment->save();

      $order_amt_rec = Order::findOrFail($request->order_id);
      $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('payment_status',"Paid")->where('order_id',$request->order_id)->orderByDesc('id')->get();
      $amount_count=0;
      foreach($orderpayments as $orderpayment){
        $amount_count=$amount_count+$orderpayment->payment_amount;
      }
      if($amount_count>=$order_amt_rec->grand_total){
        $order_amt_rec->amount_received="Yes";
        $order_amt_rec->save();
      }else{
        $order_amt_rec->amount_received="No";
        $order_amt_rec->save();
      }

      if($request->order_pickup!=NULL){
        $order_paid = Order::findOrFail($request->order_id);
        $order_paid->order_pickup = "Yes";
        $order_paid->order_status = "Picked up";
        $order_paid->save();
      }
      //return redirect('order')->with('success','Payment information added successfully');
      return back()->with('success','Payment information added successfully');
    }

    public function orderrefund(Request $request, $id)
    {
      $customthemesetting = customthemesetting();

      $order_payment = new Orderpayments;
      $order_payment->order_id = $request->r_order_id;
      $order_payment->payment_type = $request->r_payment_type;
      $order_payment->payment_details = $request->r_payment_details;
      $order_payment->payment_amount = $request->r_payment_amount;
      $order_payment->payment_date = Carbon::parse($request->r_payment_date)->format('Y-m-d H:i:s');
      $order_payment->notes = $request->r_notes;
      $order_payment->payment_status = $request->r_payment_status;
      $order_payment->save();

      $order_amt_rec = Order::findOrFail($request->r_order_id);
      $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('payment_status',"Paid")->where('order_id',$request->order_id)->orderByDesc('id')->get();
      $amount_count=0;
      foreach($orderpayments as $orderpayment){
        $amount_count=$amount_count+$orderpayment->r_payment_amount;
      }
      if($amount_count>=$order_amt_rec->grand_total){
        $order_amt_rec->amount_received="Yes";
        $order_amt_rec->save();
      }else{
        $order_amt_rec->amount_received="No";
        $order_amt_rec->save();
      }

      /*
      $order_paid = Order::findOrFail($request->order_id);
      $order_paid->refund_payment_method = "Yes";
      $order_paid->order_status = "Picked up";
      $order_paid->save();
      */
      //return redirect('order')->with('success','Payment information added successfully');
      return back()->with('success','Payment information added successfully');
    }


    public function orderpaidedit(Request $request, $id)
    {
      $customthemesetting = customthemesetting();

      $order_payment = Orderpayments::findOrFail($id);
      $order_payment->payment_type = $request->payment_type;
      $order_payment->payment_details = $request->payment_details;
      $order_payment->payment_amount = $request->payment_amount;
      $order_payment->payment_date = Carbon::parse($request->payment_date)->format('Y-m-d H:i:s');
      $order_payment->notes = $request->notes;
      $order_payment->save();

      $order_amt_rec = Order::findOrFail($request->order_id);
      $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('payment_status',"Paid")->where('order_id',$request->order_id)->orderByDesc('id')->get();
      $amount_count=0;
      foreach($orderpayments as $orderpayment){
        $amount_count=$amount_count+$orderpayment->payment_amount;
      }
      if($amount_count>=$order_amt_rec->grand_total){
        $order_amt_rec->amount_received="Yes";
        $order_amt_rec->save();
      }else{
        $order_amt_rec->amount_received="No";
        $order_amt_rec->save();
      }
      return redirect('order/'.$request->order_id)->with('success','Payment information added successfully');
    }



    public function orderpaidadd(Request $request)
    {
      $customthemesetting = customthemesetting();

      $order_payment = new Orderpayments;
      $order_payment->order_id = $request->add_order_id;
      $order_payment->payment_type = $request->add_payment_type;
      $order_payment->payment_details = $request->add_payment_details;
      $order_payment->payment_amount = $request->add_payment_amount;
      $order_payment->payment_date = Carbon::parse($request->add_payment_date)->format('Y-m-d H:i:s');
      $order_payment->notes = $request->add_notes;
      $order_payment->payment_status = $request->add_payment_status;
      $order_payment->save();

      $order_amt_rec = Order::findOrFail($request->add_order_id);
      $orderpayments=Orderpayments::select('id','order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes')->where('order_id',$request->add_order_id)->orderByDesc('id')->get();
      $amount_count=0;
      foreach($orderpayments as $orderpayment){
        $amount_count=$amount_count+$orderpayment->payment_amount;
      }
      if($amount_count>=$order_amt_rec->grand_total){
        $order_amt_rec->amount_received="Yes";
        $order_amt_rec->save();
      }else{
        $order_amt_rec->amount_received="No";
        $order_amt_rec->save();
      }
      return redirect('order/'.$request->add_order_id)->with('success','Payment information added successfully');
    }


    public function datepdf(Request $request){

        $order_data = json_decode($request->orders);
        $orderproduct_data = json_decode($request->orderproduct);
        $orderpayment_data = json_decode($request->orderpayment);

        $customthemesetting = customthemesetting();
        $total_price=0;

        $contents='';
        $contents.='<style>';
        $contents.='h1{color: navy;font-family: times;font-size: 24px;text-decoration: underline;}';
        $contents.='table tr td{font-size: large;}';
        $contents.='table tr th{font-size: large;}';
        $contents.='h3{font-size: x-large;}';
        $contents.='p{font-size: large;}';
        $contents.='</style>';
        $logo_url=url('/')."/public/websitelogo/".$customthemesetting->tenant_image;
        $contents.='<div class="table-responsive">';
        $contents.='<table id="" width="100%" cellpadding="2" cellspacing="2" class="table table-bordered">';
        $contents.='<tr>';
        $contents.='<td>';
        $contents.='<img src="';
        $contents.=$logo_url;
        $contents.='" >';
        $contents.='</td>';
        $contents.='<td>';
        $contents.='</td>';
        $contents.='<td style="text-align:center;" colspan="2">';
        $contents.='<h3>';
        $contents.=$customthemesetting->tenant_title;
        $contents.='</h3>';
        $contents.="<br><strong>Order Report</strong>";
        $contents.='</td>';
        $contents.='<td>';
        $contents.='</td>';
        $contents.='<td>';
        $contents.=$customthemesetting->front_mobile."<br>";
        $contents.=$customthemesetting->front_email."<br>";
        $contents.='</td>';
        $contents.='</tr>';
        $contents.='</table>';
        $contents.='</div>';

        $contents.='<div class="table-responsive">';
        $contents.='<table id="" width="100%" cellpadding="2" cellspacing="2" class="table table-bordered">';
        $contents.='<tr>';
        $contents.='<td style="text-align:left;" colspan="6">';
        $contents.='<p><strong>Order ID</strong> : #'.$order_data->id;
        $contents.='<br><strong>Order Status</strong> : '.$order_data->order_status;
        $contents.='<br><strong>Order Date</strong> : '.Carbon::parse($order_data->created_at)->format($customthemesetting->datetime_format);
        if($order_data->payment_method=="Paypal"){
         $contents.='<br><strong>Payment Mode</strong> : '.$order_data->payment_method.' ('.$order_data->payer_id.')';
 		    }else{
         $contents.='<br><strong>Payment Mode</strong> : '.$order_data->payment_method;
 		    }
        $delivery_date = Carbon::parse($order_data->delivery_date)->format($customthemesetting->datetime_format);
        $contents.='<br><strong>Payment Received</strong> : '.$delivery_date.'</p>';
        $contents.='</td>';
        $contents.='</tr>';
        $contents.='</table>';
        $contents.='</div>';

        $contents.='<div class="table-responsive">';
        //style="border-color:#ccc;"
        $contents.='<table border="0.2" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
        //$contents.='<thead>';
        $contents.='<tr>';
        $contents.='<td>Sr No</td>';
        $contents.='<td colspan="2">Name</td>';
        $contents.='<td>Price</td>';
        $contents.='<td>Quantity</td>';
        $contents.='<td>Total</td>';
        $contents.='</tr>';
        //$contents.='</thead>';
        //$contents.='<tbody>';
        $i=1;
        foreach($orderproduct_data as $data){
          $total_price = $total_price + ($data->p_qty*$data->p_price);
        $contents.='<tr>';
          $contents.='<td>'.$i.'</td>';
          $contents.='<td colspan="2">'.$data->p_name.'</td>';
          $contents.='<td>'.$data->p_qty.'</td>';
          $contents.='<td>'.$data->p_price.'</td>';
          $contents.='<td>'.$customthemesetting->currency.$data->p_qty*$data->p_price.'</td>';
          $contents.='</tr>';
          $i++;
        }

        $contents.='<tr>';
        $contents.='<td colspan="4">&nbsp;</td>';
        $contents.='<td colspan="2">';
        //border="1"
        //style="border-color:#ccc;"
        $contents.='<table border="0.1" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
                $contents.='<tr>';
                $contents.='<td>Cart Sub Total</td>';
                $contents.='<td>'.$customthemesetting->currency.$total_price.'</td>';
                $contents.='</tr>';
                if($order_data->coupon_amount > 0){
                      $contents.='<tr>';
                          $contents.='<td>Coupon Discount</td>';
                          $contents.='<td>'.$customthemesetting->currency.$order_data->coupon_amount.'</td>';
                      $contents.='</tr>';
                      $contents.='<tr>';
                          $contents.='<td>Total</td>';
                          $contents.='<td>'.$customthemesetting->currency.$total_price.'</td>';
                      $contents.='</tr>';
                }else{
                      $contents.='<tr>';
                          $contents.='<td>Total</td>';
                          $contents.='<td>'.$customthemesetting->currency.$total_price.'</td>';
                      $contents.='</tr>';
                }
                $contents.='</table>';
            $contents.='</td>';
        $contents.='</tr>';

        //$contents.='</tbody>';
        $contents.='</table>';

        if(count($orderpayment_data)>=1){
        $contents.='<h4>Payment Details</h4>';
        $contents.='<div class="table-responsive">';
        $contents.='<table border="0.2" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
        $contents.='<tr>';
        $contents.='<td>Sr No</td>';
        $contents.='<td>Type</td>';
        $contents.='<td>Details</td>';
        $contents.='<td>Amount</td>';
        $contents.='<td>Date</td>';
        $contents.='</tr>';
        $j=1;
        foreach($orderpayment_data as $data){

            $contents.='<tr>';
            $contents.='<td>'.$j.'</td>';
            $contents.='<td>'.$data->payment_type.'</td>';
            $contents.='<td>'.$data->payment_details.'</td>';
            $contents.='<td>'.$customthemesetting->currency.$data->payment_amount.'</td>';
            $pay_date = Carbon::parse($data->payment_date)->format($customthemesetting->datetime_format);
            $contents.='<td>'.$pay_date.'</td>';
            $contents.='</tr>';
          $j++;
         }
         $contents.='</table>';
         $contents.='</div>';
       }


         PDF::SetTitle(time().'bill_print');
         PDF::AddPage();
         //PDF::setPrintHeader(false);
         //PDF::setPrintFooter(false);
         PDF::SetFont('helvetica', '', 6, '', true);
         //PDF::writeHTMLCell(0, 0, '', '', $contents, 0, 1, 0, true, '', true);
         PDF::writeHTML($contents, true, false, true, false, '');
         //$filename=$data['user']->name.'_'.$data['user']->profile->reference_no.'_Payslip_For_'.date('F',strtotime($date)).'_'.date('Y',strtotime($date)).'.pdf';
         $filename=time().'_print_invoice'.'.pdf';
         PDF::Output($filename,'I');
    }

    public function sendmail(Request $request){

        $order_data = json_decode($request->orders);
        $orderproduct_data = json_decode($request->orderproduct);
        $orderpayment_data = json_decode($request->orderpayment);
        $customthemesetting = customthemesetting();
        $total_price=0;

        $mail = DB::table('theme_settings')->where('id',1)->first();
        if ($mail){
          $config = array(
              'driver'     => $mail->smtp_transport_exp,
              'host'       => $mail->smtp_server,
              'port'       => $mail->smtp_port,
              'from'       => array('address' => $mail->smtp_from_email, 'name' => $mail->smtp_from_name),
              'encryption' => $mail->smtp_encryption,
              'username'   => $mail->smtp_email,
              'password'   => $mail->smtp_email_pass,
              'sendmail'   => '/usr/sbin/sendmail -bs',
              'pretend'    => false,
          );
          Config::set('mail', $config);
        }

        // User Mail
        $to_name = $order_data->name;
        $to_email = $order_data->users_email;
        $mail_data['username'] = $order_data->name;
        $mail_data['customthemesetting'] = $customthemesetting;
        $mail_data['orderproduct_data'] = $orderproduct_data;
        $mail_data['orderpayment_data'] = $orderpayment_data;
        $mail_data['order_data'] = $order_data;
        $subject = "Prasadam - Invoice #".$order_data->id;
        Mail::send('admin.mail.ordersendmail', $mail_data, function($message) use ($to_name, $to_email, $subject) {
          $message->to($to_email, $to_name)->subject($subject);
        });

        // Admin Mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['username'] = "Admin";
        $mail_data['customthemesetting'] = $customthemesetting;
        $mail_data['orderproduct_data'] = $orderproduct_data;
        $mail_data['orderpayment_data'] = $orderpayment_data;
        $mail_data['order_data'] = $order_data;
        $subject = "Prasadam - Invoice #".$order_data->id;
        Mail::send('admin.mail.ordersendmail', $mail_data, function($message) use ($to_name, $to_email, $subject) {
          $message->to($to_email, $to_name)->subject($subject);
        });

        $redirect_url = 'order/'.$order_data->id;
        return redirect($redirect_url)->with('success','Invoice Mail sent successfully');
    }

    public function orderreject(Request $request, $id){
        $orders=Order::findOrFail($id);
        $payment_method = $orders->payment_method;
        $user_name = $orders->name;
        $user_email = $orders->users_email;
        $orders->cancel_reason = $request->cancel_reason;
        $orders->cancel_notes = $request->c_notes;
        $orders->order_status = "Canceled";
        $orders->save();
        $customthemesetting = customthemesetting();
        $mail = DB::table('theme_settings')->where('id',1)->first();
        if($mail){
          $config = array(
              'driver'     => $mail->smtp_transport_exp,
              'host'       => $mail->smtp_server,
              'port'       => $mail->smtp_port,
              'from'       => array('address' => $mail->smtp_from_email, 'name' => $mail->smtp_from_name),
              'encryption' => $mail->smtp_encryption,
              'username'   => $mail->smtp_email,
              'password'   => $mail->smtp_email_pass,
              'sendmail'   => '/usr/sbin/sendmail -bs',
              'pretend'    => false,
          );
          Config::set('mail', $config);
        }
        /* Mail Start */
        $to_name = $user_name;
        $to_email = $user_email;
        $mail_data['name'] = $user_name;
        $mail_data['email'] = $user_email;
        $mail_data['order_id'] = $id;
        $mail_data['payment_method'] = $payment_method;
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.cancelorderuser', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - Cancel Order');
        });

        //Admin Mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['name'] = $user_name;
        $mail_data['email'] = $user_email;
        $mail_data['customthemesetting'] = $customthemesetting;
        $mail_data['order_id'] = $id;
        $mail_data['payment_method'] = $payment_method;
        Mail::send('admin.mail.cancelorderadmin', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - Cancel Order');
        });
        return back()->with('message','Order Canceled Successfully');
        //$error=0;
        //return $error;
    }
    /*
    public function orderaccept($id)
    {
      $customthemesetting = customthemesetting();
        $order_reject = Order::findOrFail($id);

        $mail = DB::table('theme_settings')->where('id',1)->first();
        if ($mail){
          $config = array(
              'driver'     => $mail->smtp_transport_exp,
              'host'       => $mail->smtp_server,
              'port'       => $mail->smtp_port,
              'from'       => array('address' => $mail->smtp_from_email, 'name' => $mail->smtp_from_name),
              'encryption' => $mail->smtp_encryption,
              'username'   => $mail->smtp_email,
              'password'   => $mail->smtp_email_pass,
              'sendmail'   => '/usr/sbin/sendmail -bs',
              'pretend'    => false,
          );
          Config::set('mail', $config);
        }
        // User Mail
        $to_name = $order_reject->name;
        $to_email = $order_reject->users_email;
        $mail_data['order_id'] = $id;
        $mail_data['username'] = $order_reject->name;
        Mail::send('admin.mail.orderaccept', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - Order Accepted');
        });

        //Admin Mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['order_id'] = $id;
        $mail_data['username'] = "Admin";
        Mail::send('admin.mail.orderaccept', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - Order Accepted');
        });

        $order_reject->order_status = "Accepted";
        $order_reject->save();
        $error=0;
        return $error;
    }
    */

}
