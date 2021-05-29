<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Photo;
use App\Role;
use App\Order;
use App\Orderproduct;
use App\Orderpayments;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Config;
use PDF;
use Excel;

class UsersController extends Controller
{
    public function index(){
      if(Auth::check()){
        return redirect('/userdashboard');
      }else{
        return view('front.auth.login');
      }
    }
    public function reg(){
      if(Auth::check()){
        return redirect('/userdashboard');
      }else{
        return view('front.auth.register');
      }
    }

    public function register(Request $request){
      $customthemesetting = customthemesetting();
      if(Auth::check()){
        return redirect('/userdashboard');
      }else{
        $this->validate($request,[
           'name'=>'required|string|max:255',
            'email'=>'required|string|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);
        $input_data=$request->all();
        $pass = $input_data['password'];
        $input_data['password']=Hash::make($input_data['password']);
        $input_data['role_id']=5;
        $input_data['is_active']=1;
        User::create($input_data);

        // Mail Remaining
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
        $to_name = $input_data['name'];
        $to_email = $input_data['email'];
        $mail_data['name'] = $input_data['name'];
        $mail_data['password'] = $pass;
        $mail_data['email'] = $input_data['email'];
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.userregister', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - User Registered');
        });

        //Admin Mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['name'] = $input_data['name'];
        //$mail_data['password'] = $request->password;
        $mail_data['email'] = $input_data['email'];
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.adminuserregister', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - User Registered');
        });


        //return back()->with('message','Registered Successfully!');
        return redirect('/userlogin')->with('message','Registered Successfully!');
      }
    }

    public function login(Request $request){
      if(Auth::check()){
        return redirect('/userdashboard');
      }else{
        $input_data=$request->all();
        if(Auth::attempt(['email'=>$input_data['email'],'password'=>$input_data['password']])){
            Session::put('frontSession',$input_data['email']);
            return redirect('/');
        }else{
            return back()->with('message','Account is not Valid!');
        }
      }
    }
    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        return redirect('/');
    }

    public function account(){
      if(Auth::check()){
        $data['userleftmenu']="account";
        $data['countries']=DB::table('countries')->get();
        $data['user_login']=User::where('id',Auth::id())->first();
        return view('front.auth.account')->with($data);
      }else{
        return view('front.auth.login');
      }
    }
    public function updateprofile(Request $request,$id){
      if(Auth::check()){
        $this->validate($request,[
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'mobile'=>'required',
        ]);
        $input_data=$request->all();
        DB::table('users')->where('id',$id)->update(['name'=>$input_data['name'],
            'address'=>$input_data['address'],
            'city'=>$input_data['city'],
            'state'=>$input_data['state'],
            'country'=>$input_data['country'],
            'pincode'=>$input_data['pincode'],
            'mobile'=>$input_data['mobile']]);
        return redirect('/myaccount')->with('message','Update Profile already!');
      }else{
        return view('front.auth.login');
      }
    }

    public function userupdatepassword(){
      if(Auth::check()){
        $data['userleftmenu']="changepassword";
        $data['user_login']=User::where('id',Auth::id())->first();
        return view('front.auth.updatepass')->with($data);
      }else{
        return view('front.auth.login');
      }
    }
    public function updatepassword(Request $request,$id){
      $customthemesetting = customthemesetting();
      if(Auth::check()){
        $oldPassword=User::where('id',$id)->first();
        $input_data=$request->all();
        if($input_data['password']==""){
          if($oldPassword->password==""){
            $this->validate($request,[
               'newPassword'=>'required|min:6|max:12|confirmed'
            ]);
            $new_pass=Hash::make($input_data['newPassword']);
            User::where('id',$id)->update(['password'=>$new_pass]);

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
            /* Mail Start */
            $to_name = $oldPassword->name;
            $to_email = $oldPassword->email;
            $mail_data['name'] = $oldPassword->name;
            $mail_data['customthemesetting'] = $customthemesetting;
            Mail::send('admin.mail.changepassword', $mail_data, function($message) use ($to_name, $to_email) {
              $message->to($to_email, $to_name)->subject('Changed Password');
            });

            return redirect('/userupdatepassword')->with('message','Your Password has been updated.');
          }else{
            return redirect('/userupdatepassword')->with('oldpassword','Old Password is Inconrrect!');
          }
        }else{
          if(Hash::check($input_data['password'],$oldPassword->password)){
              $this->validate($request,[
                 'newPassword'=>'required|min:6|max:12|confirmed'
              ]);
              $new_pass=Hash::make($input_data['newPassword']);
              User::where('id',$id)->update(['password'=>$new_pass]);
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
              /* Mail Start */
              $to_name = $oldPassword->name;
              $to_email = $oldPassword->email;
              $mail_data['name'] = $oldPassword->name;
              $mail_data['customthemesetting'] = $customthemesetting;
              Mail::send('admin.mail.changepassword', $mail_data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Changed Password');
              });

              return redirect('/userupdatepassword')->with('message','Your Password has been updated.');
          }else{
              return redirect('/userupdatepassword')->with('oldpassword','Old Password is Inconrrect!');
          }
        }
      }else{
        return view('front.auth.login');
      }
    }

    public function userdashboard(){
      if(Auth::check()){
        $data['userleftmenu']="userdashboard";
        $data['user_login']=User::where('id',Auth::id())->first();
        $data['orders']=Order::where('users_id',Auth::id())->orderByDesc('id')->limit(5)->get();
        return view('front.auth.userdashboard')->with($data);
      }else{
        return view('front.auth.login');
      }
    }
    public function myorder(){
      if(Auth::check()){
        $data['userleftmenu']="myorder";
        $data['orders']=Order::where('users_id',Auth::id())->orderByDesc('id')->get();
        return view('front.auth.myorder')->with($data);
      }else{
        return view('front.auth.login');
      }
    }
    

    public function mycancelorder($id){
      if(Auth::check()){
        $orders=Order::findOrFail($id);
        $payment_method = $orders->payment_method;
        $orders->order_status = "Canceled";
        $orders->save();

        $customthemesetting = customthemesetting();
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
        /* Mail Start */
        $to_name = Auth::user()->name;
        $to_email = Auth::user()->email;
        $mail_data['name'] = Auth::user()->name;
        $mail_data['email'] = Auth::user()->email;
        $mail_data['order_id'] = $id;
        $mail_data['payment_method'] = $payment_method;
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.cancelorderuser', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - Cancel Order');
        });

        //Admin Mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['name'] = Auth::user()->name;
        $mail_data['email'] = Auth::user()->email;
        $mail_data['customthemesetting'] = $customthemesetting;
        $mail_data['order_id'] = $id;
        $mail_data['payment_method'] = $payment_method;
        Mail::send('admin.mail.cancelorderadmin', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - Cancel Order');
        });

        return back()->with('message','Order Canceled Successfully');
      }else{
        return view('front.auth.login');
      }
    }

    public function myvieworder($id){
      if(Auth::check()){
        $data['userleftmenu']="myorder";
        $data['orders']=Order::where('users_id',Auth::id())->where('id',$id)->orderByDesc('id')->first();
        $data['orderproduct']=Orderproduct::where('order_id',$id)->get();
        $data['orderpayment']=Orderpayments::where('order_id',$id)->orderByDesc('id')->get();
        return view('front.auth.myvieworder')->with($data);
      }else{
        return view('front.auth.login');
      }
    }

    public function myvieworderdatepdf(Request $request){

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
        $contents.='<br><strong>Order Date</strong> : '.$order_data->created_at;
        if($order_data->payment_method=="Paypal"){
         $contents.='<br><strong>Payment Mode</strong> : '.$order_data->payment_method.' ('.$order_data->payer_id.')'.'</p>';
 		    }else{
         $contents.='<br><strong>Payment Mode</strong> : '.$order_data->payment_method.'</p>';
 		    }
        $contents.='</td>';
        $contents.='</tr>';
        $contents.='</table>';
        $contents.='</div>';

        $contents.='<div class="table-responsive">';
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

}
