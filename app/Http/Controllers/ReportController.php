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
use PDF;
use Excel;

class ReportController extends Controller
{
  public function index(Request $request){
    $customthemesetting = customthemesetting();
      $data['webpage']='Order Report';
      $data['action']='Order Report';
      $data['menu']='';
      //echo "call..";die;
      $payment_details = $request->payment_details;
      if($request->report_date=="today"){
        $fromdate = Carbon::today()->format('Y-m-d H:i:s');
        $todate = Carbon::parse($fromdate)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
      }elseif($request->report_date=="yesterday"){
        $fromdate = date('Y-m-d', strtotime('-1 days'));
        $todate = Carbon::yesterday()->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
      }elseif($request->report_date=="tomorrow"){
        $fromdate = date('Y-m-d', strtotime('+1 days'));
        $todate = Carbon::tomorrow()->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
      }elseif($request->report_date=="lastweek"){
        $fromdate = date('Y-m-d', strtotime('-7 days'));
        $todate = Carbon::today()->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
      }elseif($request->report_date=="nextweek"){
        //$fromdate = Carbon::tomorrow()->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        $fromdate = date('Y-m-d', strtotime('+1 days'));
        $todate = date('Y-m-d', strtotime('+7 days'));
        /*echo $fromdate."**";
        echo $todate;
        die;*/
      }else{
        //if($request->fromdate==null){$fromdate = date('Y-m-d', strtotime('-30 days'));}else{
          $fromdate = date('Y-m-d', strtotime($request->fromdate));
        //}
        //if($request->todate==null){$todate = date("Y-m-d");}else{
          $todate = Carbon::parse($request->todate)->addHours(23)->addMinute(59)->format('Y-m-d H:i:s');
        //}
      }
      $order_report=array();
      $payment_total_report=array();
      $payment_total_report['cash']=0;
      $payment_total_report['paypal']=0;
      $payment_total_report['check']=0;
      $payment_total_report['creditcard']=0;
      $payment_total_report['cash_refund']=0;
      $payment_total_report['paypal_refund']=0;
      $payment_total_report['check_refund']=0;
      $payment_total_report['creditcard_refund']=0;

      $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and main_categories_id=1 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
      for($i=0;$i<count($order_data);$i++){
        $order_report[$i]['id']=$order_data[$i]->id;
        $order_report[$i]['user_email']=$order_data[$i]->users_email;
        $order_report[$i]['name']=$order_data[$i]->name;
        $order_report[$i]['mobile']=$order_data[$i]->mobile;
        $order_report[$i]['order_status']=$order_data[$i]->order_status;
        $order_report[$i]['payment_method']=$order_data[$i]->payment_method;
        $order_report[$i]['delivery_date']=Carbon::parse($order_data[$i]->delivery_date)->format($customthemesetting->datetime_format);
        $order_report[$i]['created_at']=Carbon::parse($order_data[$i]->created_at)->format($customthemesetting->datetime_format);
        $order_report[$i]['grand_total']=$customthemesetting->currency.$order_data[$i]->grand_total;

        $order_report[$i]['amount_received']=$order_data[$i]->amount_received;
        $product_order_data = DB::select('SELECT * FROM orderproducts WHERE order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        for($k=0;$k<count($product_order_data);$k++){
          $order_report[$i]['products'][$k]['pid']=$product_order_data[$k]->p_id;
          $order_report[$i]['products'][$k]['pprice']=$customthemesetting->currency.$product_order_data[$k]->p_price;
          $order_report[$i]['products'][$k]['pname']=$product_order_data[$k]->p_name;
          $order_report[$i]['products'][$k]['pcode']=$product_order_data[$k]->p_code;
          $order_report[$i]['products'][$k]['pqty']=$product_order_data[$k]->p_qty;
        }

        $productpayment_data = DB::select('SELECT * FROM orderpayments WHERE payment_status="Paid" and order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        $total_amount_received=0;
        $order_report[$i]['payment_details_s']="no";
        for($k=0;$k<count($productpayment_data);$k++){
          $order_report[$i]['payment_details_s']="yes";
          $order_report[$i]['payment_details'][$k]['payment_details_amount']=$customthemesetting->currency.$productpayment_data[$k]->payment_amount;
          $order_report[$i]['payment_details'][$k]['payment_details_type']=$productpayment_data[$k]->payment_type;
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
        $order_report[$i]['total_amount_received']=$total_amount_received;

        $productpayment_data_refund = DB::select('SELECT * FROM orderpayments WHERE payment_status="Refund" and order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        $total_amount_refund=0;
        $order_report[$i]['payment_details_r']="no";
        for($k=0;$k<count($productpayment_data_refund);$k++){
          $order_report[$i]['payment_details_r']="yes";
          $order_report[$i]['payment_details_refund'][$k]['payment_details_amount_refund']=$customthemesetting->currency.$productpayment_data_refund[$k]->payment_amount;
          $order_report[$i]['payment_details_refund'][$k]['payment_details_type_refund']=$productpayment_data_refund[$k]->payment_type;
          $total_amount_refund=$total_amount_refund+$productpayment_data_refund[$k]->payment_amount;
            if($productpayment_data_refund[$k]->payment_type=="Cash"){
                $payment_total_report['cash_refund']=$payment_total_report['cash_refund']+$productpayment_data_refund[$k]->payment_amount;
            }elseif($productpayment_data_refund[$k]->payment_type=="Paypal"){
                $payment_total_report['paypal_refund']=$payment_total_report['paypal_refund']+$productpayment_data_refund[$k]->payment_amount;
            }elseif($productpayment_data_refund[$k]->payment_type=="Check"){
                $payment_total_report['check_refund']=$payment_total_report['check_refund']+$productpayment_data_refund[$k]->payment_amount;
            }else{
                $payment_total_report['creditcard_refund']=$payment_total_report['creditcard_refund']+$productpayment_data_refund[$k]->payment_amount;
            }
        }
        $order_report[$i]['total_amount_refund']=$total_amount_refund;
      }

      $data['order_report']=$order_report;


      $catering_order_report=array();
      $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and main_categories_id=2 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
      for($i=0;$i<count($order_data);$i++){
        $catering_order_report[$i]['id']=$order_data[$i]->id;
        $catering_order_report[$i]['user_email']=$order_data[$i]->users_email;
        $catering_order_report[$i]['name']=$order_data[$i]->name;
        $catering_order_report[$i]['mobile']=$order_data[$i]->mobile;
        $catering_order_report[$i]['order_status']=$order_data[$i]->order_status;
        $catering_order_report[$i]['payment_method']=$order_data[$i]->payment_method;
        $catering_order_report[$i]['delivery_date']=Carbon::parse($order_data[$i]->delivery_date)->format($customthemesetting->datetime_format);
        $catering_order_report[$i]['created_at']=Carbon::parse($order_data[$i]->created_at)->format($customthemesetting->datetime_format);
        $catering_order_report[$i]['grand_total']=$customthemesetting->currency.$order_data[$i]->grand_total;
        $catering_order_report[$i]['amount_received']=$order_data[$i]->amount_received;
        $product_order_data = DB::select('SELECT * FROM orderproducts WHERE order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        for($k=0;$k<count($product_order_data);$k++){
          $catering_order_report[$i]['products'][$k]['pid']=$product_order_data[$k]->p_id;
          $catering_order_report[$i]['products'][$k]['pprice']=$customthemesetting->currency.$product_order_data[$k]->p_price;
          $catering_order_report[$i]['products'][$k]['pname']=$product_order_data[$k]->p_name;
          $catering_order_report[$i]['products'][$k]['pcode']=$product_order_data[$k]->p_code;
          $catering_order_report[$i]['products'][$k]['pqty']=$product_order_data[$k]->p_qty;
        }

        $productpayment_data = DB::select('SELECT * FROM orderpayments WHERE payment_status="Paid" and order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        $total_amount_received_cat=0;
        $catering_order_report[$i]['payment_details_s']="no";
        for($k=0;$k<count($productpayment_data);$k++){
          $catering_order_report[$i]['payment_details_s']="yes";
          $catering_order_report[$i]['payment_details'][$k]['payment_details_amount']=$customthemesetting->currency.$productpayment_data[$k]->payment_amount;
          $catering_order_report[$i]['payment_details'][$k]['payment_details_type']=$productpayment_data[$k]->payment_type;
          $total_amount_received_cat=$total_amount_received_cat+$productpayment_data[$k]->payment_amount;
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
        $catering_order_report[$i]['total_amount_received']=$total_amount_received_cat;

        $productpayment_data_refund = DB::select('SELECT * FROM orderpayments WHERE payment_status="Refund" and order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        $total_amount_refund_cat=0;
        $catering_order_report[$i]['payment_details_r']="no";
        for($k=0;$k<count($productpayment_data_refund);$k++){
          $catering_order_report[$i]['payment_details_r']="yes";
          $catering_order_report[$i]['payment_details_refund'][$k]['payment_details_amount_refund']=$customthemesetting->currency.$productpayment_data_refund[$k]->payment_amount;
          $catering_order_report[$i]['payment_details_refund'][$k]['payment_details_type_refund']=$productpayment_data_refund[$k]->payment_type;
          $total_amount_refund_cat=$total_amount_refund_cat+$productpayment_data_refund[$k]->payment_amount;
            if($productpayment_data[$k]->payment_type=="Cash"){
                $payment_total_report['cash_refund']=$payment_total_report['cash_refund']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Paypal"){
                $payment_total_report['paypal_refund']=$payment_total_report['paypal_refund']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Check"){
                $payment_total_report['check_refund']=$payment_total_report['check_refund']+$productpayment_data[$k]->payment_amount;
            }else{
                $payment_total_report['creditcard_refund']=$payment_total_report['creditcard_refund']+$productpayment_data[$k]->payment_amount;
            }
        }
        $catering_order_report[$i]['total_amount_refund']=$total_amount_refund_cat;
      }
      $data['catering_order_report']=$catering_order_report;
      //echo count($data['catering_order_report']);die;

      $menu_order_report=array();
      $order_data = DB::select('SELECT * FROM orders WHERE order_status!="Canceled" and main_categories_id=3 and (delivery_date >= "'.$fromdate.'" and delivery_date <= "'.$todate.'") and deleted_at is NULL order by delivery_date desc');
      for($i=0;$i<count($order_data);$i++){
        $menu_order_report[$i]['id']=$order_data[$i]->id;
        $menu_order_report[$i]['user_email']=$order_data[$i]->users_email;
        $menu_order_report[$i]['name']=$order_data[$i]->name;
        $menu_order_report[$i]['mobile']=$order_data[$i]->mobile;
        $menu_order_report[$i]['order_status']=$order_data[$i]->order_status;
        $menu_order_report[$i]['payment_method']=$order_data[$i]->payment_method;
        $menu_order_report[$i]['delivery_date']=Carbon::parse($order_data[$i]->delivery_date)->format($customthemesetting->datetime_format);
        $menu_order_report[$i]['created_at']=Carbon::parse($order_data[$i]->created_at)->format($customthemesetting->datetime_format);
        $menu_order_report[$i]['grand_total']=$customthemesetting->currency.$order_data[$i]->grand_total;
        $menu_order_report[$i]['amount_received']=$order_data[$i]->amount_received;
        $product_order_data = DB::select('SELECT * FROM orderproducts WHERE order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        for($k=0;$k<count($product_order_data);$k++){
          $menu_order_report[$i]['products'][$k]['pid']=$product_order_data[$k]->p_id;
          $menu_order_report[$i]['products'][$k]['pprice']=$customthemesetting->currency.$product_order_data[$k]->p_price;
          $menu_order_report[$i]['products'][$k]['pname']=$product_order_data[$k]->p_name;
          $menu_order_report[$i]['products'][$k]['pcode']=$product_order_data[$k]->p_code;
          $menu_order_report[$i]['products'][$k]['pqty']=$product_order_data[$k]->p_qty;
        }
        $productpayment_data = DB::select('SELECT * FROM orderpayments WHERE payment_status="Paid" and order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        $total_amount_received=0;
        $menu_order_report[$i]['payment_details_s']="no";
        for($k=0;$k<count($productpayment_data);$k++){
          $menu_order_report[$i]['payment_details_s']="yes";
          $menu_order_report[$i]['payment_details'][$k]['payment_details_amount']=$customthemesetting->currency.$productpayment_data[$k]->payment_amount;
          $menu_order_report[$i]['payment_details'][$k]['payment_details_type']=$productpayment_data[$k]->payment_type;
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
        $menu_order_report[$i]['total_amount_received']=$total_amount_received;

        $productpayment_data_refund = DB::select('SELECT * FROM orderpayments WHERE payment_status="Refund" and order_id='.$order_data[$i]->id.' and deleted_at is NULL ');
        $total_amount_refund=0;
        $menu_order_report[$i]['payment_details_r']="no";
        for($k=0;$k<count($productpayment_data_refund);$k++){
          $menu_order_report[$i]['payment_details_r']="yes";
          $menu_order_report[$i]['payment_details_refund'][$k]['payment_details_amount_refund']=$customthemesetting->currency.$productpayment_data_refund[$k]->payment_amount;
          $menu_order_report[$i]['payment_details_refund'][$k]['payment_details_type_refund']=$productpayment_data_refund[$k]->payment_type;
          $total_amount_refund=$total_amount_refund+$productpayment_data_refund[$k]->payment_amount;
            if($productpayment_data[$k]->payment_type=="Cash"){
                $payment_total_report['cash_refund']=$payment_total_report['cash_refund']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Paypal"){
                $payment_total_report['paypal_refund']=$payment_total_report['paypal_refund']+$productpayment_data[$k]->payment_amount;
            }elseif($productpayment_data[$k]->payment_type=="Check"){
                $payment_total_report['check_refund']=$payment_total_report['check_refund']+$productpayment_data[$k]->payment_amount;
            }else{
                $payment_total_report['creditcard_refund']=$payment_total_report['creditcard_refund']+$productpayment_data[$k]->payment_amount;
            }
        }
        $menu_order_report[$i]['total_amount_refund']=$total_amount_refund;
      }
      $data['menu_order_report']=$menu_order_report;
      $data['payment_details_show']=$payment_details;
      $data['payment_total_report']=$payment_total_report;

      $data['report_day_type']=$request->report_date;
      $data['report_payment_type']=$payment_details;
      $data['report_fromdate']=Carbon::parse($fromdate)->format($customthemesetting->datetime_format);
      $data['report_todate']=Carbon::parse($todate)->format($customthemesetting->datetime_format);
      //echo "call...";
      //die;
      return view('admin.report.order')->with($data);
  }

  public function datepdf(Request $request){

      $order_reports = json_decode($request->order_reports);
      $catering_order_reports = json_decode($request->catering_order_reports);
      $menu_order_reports = json_decode($request->menu_order_reports);
      $payment_details_show = $request->payment_details_show;
      $payment_total_report = json_decode($request->payment_total_report);
      $customthemesetting = customthemesetting();


      $contents='';
      $contents.='<style>';
      $contents.='h1{color: navy;font-family: times;font-size: 24px;text-decoration: underline;}';
      $contents.='table tr td{font-size: large;}';
      $contents.='table tr th{font-size: large;}';
      $contents.='h3{font-size: x-large;}';
      $contents.='p{font-size: large;}';
      //$contents.='.table td, .table th {padding: 5px;}';
      //$contents.='.table thead th {vertical-align: top;}';
      //$contents.='.table thead th {border-bottom: none;}';
      //$contents.='table.jambo_table {border: 1px solid #000;}';
      //$contents.='.table td, .table th {border-top: 1px solid #000;}';
      //$contents.='.table thead th,.table tbody td {border-left: 1px solid #000;}';
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

      if($payment_details_show=="yes"){
      $contents.='<div class="table-responsive">';
      $contents.='<table border="0.2" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
      $contents.='<tr>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Cash :'.$customthemesetting->currency.$payment_total_report->cash.'</div>';
      $contents.='</th>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Check :'.$customthemesetting->currency.$payment_total_report->check.'</div>';
      $contents.='</th>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Credit Card :'.$customthemesetting->currency.$payment_total_report->creditcard.'</div>';
      $contents.='</th>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Paypal :'.$customthemesetting->currency.$payment_total_report->paypal.'</div>';
      $contents.='</th>';
      $contents.='</tr>';
      //$contents.='</table>';
      //$contents.='</div>';
      //$contents.='<div class="table-responsive">';
      //$contents.='<table border="0.2" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
      $contents.='<tr>';
      $contents.='<th colspan="3" width="75%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Total Amount Received :</div>';
      $contents.='</th>';
      $contents.='<th colspan="1" width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>';
          $total = $payment_total_report->cash+$payment_total_report->check+$payment_total_report->creditcard+$payment_total_report->paypal;
          $contents.=$customthemesetting->currency.$total;
      $contents.='</div>';
      $contents.='</th>';
      $contents.='</tr>';
      $contents.='<tr>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Cash :'.$customthemesetting->currency.$payment_total_report->cash_refund.'</div>';
      $contents.='</th>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Check :'.$customthemesetting->currency.$payment_total_report->check_refund.'</div>';
      $contents.='</th>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Credit Card :'.$customthemesetting->currency.$payment_total_report->creditcard_refund.'</div>';
      $contents.='</th>';
      $contents.='<th width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Paypal :'.$customthemesetting->currency.$payment_total_report->paypal_refund.'</div>';
      $contents.='</th>';
      $contents.='</tr>';
      $contents.='<tr>';
      $contents.='<th colspan="3" width="75%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Total Amount Refund :</div>';
      $contents.='</th>';
      $contents.='<th colspan="1" width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>';
          $total_refund = $payment_total_report->cash_refund+$payment_total_report->check_refund+$payment_total_report->creditcard_refund+$payment_total_report->paypal_refund;
          $contents.=$customthemesetting->currency.$total_refund;
      $contents.='</div>';
      $contents.='</th>';
      $contents.='</tr>';
      $contents.='<tr>';
      $contents.='<th colspan="3" width="75%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>Total Amount :</div>';
      $contents.='</th>';
      $contents.='<th colspan="1" width="25%" bgcolor="#A020F0" style="color:#fff;">';
      $contents.='<div>';
          $final_amt = $total-$total_refund;
          $contents.=$customthemesetting->currency.$final_amt;
      $contents.='</div>';
      $contents.='</th>';
      $contents.='</tr>';
      $contents.='</table>';
      $contents.='</div>';
      }

      if(count($order_reports)>=1){
      //tiffin
      $contents.='<div class="table-responsive">';
      $contents.='<table border="0.2" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
      //$contents.='<thead>';
      $contents.='<tr>';
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Tiffin</div>';
      $contents.='</th>';
      $contents.='<th rowspan="1" colspan="4" width="35%">Name</th>';
      if($payment_details_show=="yes"){
        $contents.='<th rowspan="2" colspan="4" width="25%">';
        $contents.='<div>Item, Item, Item</div>';
        $contents.='</th>';
      }else{
        $contents.='<th rowspan="2" colspan="4" width="35%">';
        $contents.='<div>Item, Item, Item</div>';
        $contents.='</th>';
      }
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Time</div>';
      $contents.='</th>';
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Paid</div>';
      $contents.='</th>';
      if($payment_details_show=="yes"){
        $contents.='<th rowspan="2" colspan="1" width="10%">';
        $contents.='<div>Payment</div>';
        $contents.='</th>';
      }
      $contents.='</tr>';
      $contents.='<tr>';
      $contents.='<th rowspan="1" colspan="3" width="20%">Email</th>';
      $contents.='<th width="15%">Phone</th>';
      $contents.='</tr>';
      //$contents.='</thead>';
      //$contents.='<tbody>';
      foreach($order_reports as $data){
      $contents.='<tr>';
      if($data->amount_received=="Yes"){
      $contents.='<td rowspan="2" colspan="1"><div>#'.$data->id.' <br> Picked up</div></td>';
      }else{
      $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;"><div>#'.$data->id.' <br> Not picked up</div></td>';
      }
      $contents.='<td rowspan="1" colspan="4"><div>'.$data->name.'</div></td>';
      $contents.='<td rowspan="2" colspan="4"><div>';
      for($k=0;$k<count($data->products);$k++){
      if($k==0){
      $contents.=$data->products[$k]->pname;
      }else{
      $contents.=", ".$data->products[$k]->pname;
      }
      }
      $contents.='</div></td>';
      $contents.='<td rowspan="2" colspan="1"><div>'.$data->delivery_date.'</div></td>';
      if($data->amount_received=="Yes"){
        if($payment_details_show=="yes"){
            $amt_r = $data->total_amount_received-$data->total_amount_refund;
            $contents.='<td rowspan="2" colspan="1">'.$customthemesetting->currency.$amt_r."/".$data->grand_total.' <br> Paid </td>';
        }else{
            $contents.='<td rowspan="2" colspan="1"> Paid </td>';
        }
      }else{
        if($payment_details_show=="yes"){
            $amt_r = $data->total_amount_received-$data->total_amount_refund;
            $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;">'.$customthemesetting->currency.$amt_r."/".$data->grand_total.' <br> Unpaid</td>';
        }else{
            $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;"> Unpaid</td>';
        }
      }
      if($payment_details_show=="yes"){
        $contents.="<td rowspan='2' colspan='1'><div>";
        if($data->payment_details_s=="yes"){
        $contents.="Received : <br>";
        for($k=0;$k<count($data->payment_details);$k++){
            $contents.=$data->payment_details[$k]->payment_details_type." : ".$data->payment_details[$k]->payment_details_amount."\n";
        }
        }
        if($data->payment_details_r=="yes"){
        $contents.="<br>Refund : <br>";
        for($k=0;$k<count($data->payment_details_refund);$k++){
            $contents.=$data->payment_details_refund[$k]->payment_details_type_refund." : ".$data->payment_details_refund[$k]->payment_details_amount_refund."\n";
        }
        }
        $contents.="</div></td>";
      }
      $contents.='</tr>';

      $contents.='<tr>';
      $contents.='<td rowspan="1" colspan="3">'.$data->user_email.'</td>';
      $contents.='<td>'.$data->mobile.'</td>';
      $contents.='</tr>';
      }
      //$contents.='</tbody>';
      $contents.='</table>';
      $contents.='</div>';
      }

      if(count($catering_order_reports)>=1){
      //catering
      $contents.='<div class="table-responsive">';
      $contents.='<table id="" border="0.2" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
      //$contents.='<thead>';
      $contents.='<tr>';
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Catering</div>';
      $contents.='</th>';
      $contents.='<th rowspan="1" colspan="4" width="35%">Name</th>';
      if($payment_details_show=="yes"){
        $contents.='<th rowspan="2" colspan="4" width="25%">';
        $contents.='<div>Item, Item, Item</div>';
        $contents.='</th>';
      }else{
        $contents.='<th rowspan="2" colspan="4" width="35%">';
        $contents.='<div>Item, Item, Item</div>';
        $contents.='</th>';
      }
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Time</div>';
      $contents.='</th>';
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Paid</div>';
      $contents.='</th>';
      if($payment_details_show=="yes"){
        $contents.='<th rowspan="2" colspan="1" width="10%">';
        $contents.='<div>Payment</div>';
        $contents.='</th>';
      }
      $contents.='</tr>';
      $contents.='<tr>';
      $contents.='<th rowspan="1" colspan="3" width="20%">Email</th>';
      $contents.='<th width="15%">Phone</th>';
      $contents.='</tr>';
      //$contents.='</thead>';
      //$contents.='<tbody>';
      foreach($catering_order_reports as $data){
      $contents.='<tr>';
      if($data->amount_received=="Yes"){
      $contents.='<td rowspan="2" colspan="1"><div>#'.$data->id.' <br> Picked up</div></td>';
      }else{
      $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;"><div>#'.$data->id.' <br> Not picked up</div></td>';
      }
      $contents.='<td rowspan="1" colspan="4"><div>'.$data->name.'</div></td>';
      $contents.='<td rowspan="2" colspan="4"><div>';
      for($k=0;$k<count($data->products);$k++){
      if($k==0){
      $contents.=$data->products[$k]->pname;
      }else{
      $contents.=", ".$data->products[$k]->pname;
      }
      }
      $contents.='</div></td>';
      $contents.='<td rowspan="2" colspan="1"><div>'.$data->delivery_date.'</div></td>';
      if($data->amount_received=="Yes"){
        if($payment_details_show=="yes"){
          $amt_r = $data->total_amount_received-$data->total_amount_refund;
          $contents.='<td rowspan="2" colspan="1">'.$customthemesetting->currency.$amt_r."/".$data->grand_total.' <br> Paid </td>';
        }else{
          $contents.='<td rowspan="2" colspan="1"> Paid</td>';
        }
      }else{
        if($payment_details_show=="yes"){
          $amt_r = $data->total_amount_received-$data->total_amount_refund;
          $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;">'.$customthemesetting->currency.$amt_r."/".$data->grand_total.' <br> Unpaid</td>';
        }else{
          $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;"> Unpaid</td>';
        }
      }
      if($payment_details_show=="yes"){
        $contents.="<td rowspan='2' colspan='1'><div>";
        if($data->payment_details_s=="yes"){
        $contents.="Received : <br>";
        for($k=0;$k<count($data->payment_details);$k++){
            $contents.=$data->payment_details[$k]->payment_details_type." : ".$data->payment_details[$k]->payment_details_amount."\n";
        }
        }
        if($data->payment_details_r=="yes"){
        $contents.="<br>Refund : <br>";
        for($k=0;$k<count($data->payment_details_refund);$k++){
            $contents.=$data->payment_details_refund[$k]->payment_details_type_refund." : ".$data->payment_details_refund[$k]->payment_details_amount_refund."\n";
        }
        }
        $contents.="</div></td>";
      }
      $contents.='</tr>';

      $contents.='<tr>';
      $contents.='<td rowspan="1" colspan="3">'.$data->user_email.'</td>';
      $contents.='<td>'.$data->mobile.'</td>';
      $contents.='</tr>';
      }
      //$contents.='</tbody>';
      $contents.='</table>';
      $contents.='</div>';
      }

      if(count($menu_order_reports)>=1){
      //menu
      $contents.='<div class="table-responsive">';
      $contents.='<table border="0.2" width="100%" cellpadding="1" cellspacing="0" class="table-striped jambo_table table table-bordered">';
      //$contents.='<thead>';
      $contents.='<tr>';
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Menu</div>';
      $contents.='</th>';
      $contents.='<th rowspan="1" colspan="4" width="35%">Name</th>';
      if($payment_details_show=="yes"){
        $contents.='<th rowspan="2" colspan="4" width="25%">';
        $contents.='<div>Item, Item, Item</div>';
        $contents.='</th>';
      }else{
        $contents.='<th rowspan="2" colspan="4" width="35%">';
        $contents.='<div>Item, Item, Item</div>';
        $contents.='</th>';
      }
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Time</div>';
      $contents.='</th>';
      $contents.='<th rowspan="2" colspan="1" width="10%">';
      $contents.='<div>Paid</div>';
      $contents.='</th>';
      if($payment_details_show=="yes"){
        $contents.='<th rowspan="2" colspan="1" width="10%">';
        $contents.='<div>Payment</div>';
        $contents.='</th>';
      }
      $contents.='</tr>';
      $contents.='<tr>';
      $contents.='<th rowspan="1" colspan="3" width="20%">Email</th>';
      $contents.='<th width="15%">Phone</th>';
      $contents.='</tr>';
      //$contents.='</thead>';
      //$contents.='<tbody>';
      foreach($menu_order_reports as $data){
      $contents.='<tr>';
      if($data->amount_received=="Yes"){
      $contents.='<td rowspan="2" colspan="1"><div>#'.$data->id.' <br> Picked up</div></td>';
      }else{
      $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;"><div>#'.$data->id.' <br> Not picked up</div></td>';
      }
      $contents.='<td rowspan="1" colspan="4"><div>'.$data->name.'</div></td>';
      $contents.='<td rowspan="2" colspan="4"><div>';
      for($k=0;$k<count($data->products);$k++){
      if($k==0){
      $contents.=$data->products[$k]->pname;
      }else{
      $contents.=", ".$data->products[$k]->pname;
      }
      }
      $contents.='</div></td>';
      $contents.='<td rowspan="2" colspan="1"><div>'.$data->delivery_date.'</div></td>';
      if($data->amount_received=="Yes"){
        if($payment_details_show=="yes"){
          $amt_r = $data->total_amount_received-$data->total_amount_refund;
          $contents.='<td rowspan="2" colspan="1">'.$customthemesetting->currency.$amt_r."/".$data->grand_total.' <br> Paid </td>';
        }else{
          $contents.='<td rowspan="2" colspan="1"> Paid</td>';
        }
      }else{
        if($payment_details_show=="yes"){
          $amt_r = $data->total_amount_received-$data->total_amount_refund;
          $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;">'.$customthemesetting->currency.$amt_r."/".$data->grand_total.' <br> Unpaid</td>';
        }else{
          $contents.='<td rowspan="2" colspan="1" bgcolor="#A020F0" style="color:#fff;"> Unpaid</td>';
        }
      }
      if($payment_details_show=="yes"){
        $contents.="<td rowspan='2' colspan='1'><div>";
        if($data->payment_details_s=="yes"){
        $contents.="Received : <br>";
        for($k=0;$k<count($data->payment_details);$k++){
            $contents.=$data->payment_details[$k]->payment_details_type." : ".$data->payment_details[$k]->payment_details_amount."\n";
        }
        }
        if($data->payment_details_r=="yes"){
        $contents.="<br>Refund : <br>";
        for($k=0;$k<count($data->payment_details_refund);$k++){
            $contents.=$data->payment_details_refund[$k]->payment_details_type_refund." : ".$data->payment_details_refund[$k]->payment_details_amount_refund."\n";
        }
        }
        $contents.="</div></td>";
      }
      $contents.='</tr>';

      $contents.='<tr>';
      $contents.='<td rowspan="1" colspan="3">'.$data->user_email.'</td>';
      $contents.='<td>'.$data->mobile.'</td>';
      $contents.='</tr>';
      }
      //$contents.='</tbody>';
      $contents.='</table>';
      $contents.='</div>';
      }

       PDF::SetTitle(time().'_order_report');
       PDF::AddPage();
       //PDF::setPrintHeader(false);
       //PDF::setPrintFooter(false);
       PDF::SetFont('helvetica', '', 6, '', true);
       //PDF::writeHTMLCell(0, 0, '', '', $contents, 0, 1, 0, true, '', true);
       PDF::writeHTML($contents, true, false, true, false, '');
       //$filename=$data['user']->name.'_'.$data['user']->profile->reference_no.'_Payslip_For_'.date('F',strtotime($date)).'_'.date('Y',strtotime($date)).'.pdf';
       $filename=time().'_order_report'.'.pdf';
       PDF::Output($filename,'I');
  }

  public function dateexcel(Request $request){

  }

}
