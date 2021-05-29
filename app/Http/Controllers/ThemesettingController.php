<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThemeSetting;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class ThemesettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(){

     }
     public function ShowConfig(){
       $data['webpage']='Theme Setting';
       $data['action']='Theme Setting -> Edit Theme Setting';
       $system_config=ThemeSetting::where('id',1)->get();
       $data['systemconfig']=$system_config[0];
       return view('admin.themesetting.showconfig')->with($data);
     }

     public function EditConfig(Request $request, $id){
       $this->validate($request, [
           'tenant_title' => 'required',
           'tenant_description' => 'required',
           'datetime_format' => 'required',
           'phone_format' => 'required',
           'smtp_website_name' => 'required',
           'smtp_server' => 'required',
           'smtp_port' => 'required',
           'smtp_email' => 'required',
           'smtp_email_pass' => 'required',
           'smtp_from_name' => 'required',
           'smtp_from_email' => 'required',
           'smtp_transport_exp' => 'required',
           'smtp_encryption' => 'required',
           'currency' => 'required',
           'order_cutoff_time' => 'required',
           'pickup_start_time' => 'required',
           'pickup_end_time' => 'required',
      ]);

       $systemconfig=ThemeSetting::findOrFail($id);

       $systemconfig->tenant_title = $request->tenant_title;
       $systemconfig->tenant_description = $request->tenant_description;
       //$systemconfig->tenant_image = $request->tenant_image;
       if($file=$request->file('tenant_image')){
         $userimage = time().$file->getClientOriginalName();
         $location='public/websitelogo/';
         $file->move($location,$userimage);
         $systemconfig->tenant_image = $userimage;
       }
       if($file=$request->file('tenant_favicon')){
         $faviconuserimage = time().$file->getClientOriginalName();
         $location='public/websitelogo/';
         $file->move($location,$faviconuserimage);
         $systemconfig->tenant_favicon = $faviconuserimage;
       }

       $systemconfig->datetime_format = $request->datetime_format;
       $systemconfig->phone_format = $request->phone_format;
       $systemconfig->front_email = $request->front_email;
       $systemconfig->front_mobile = $request->front_mobile;
       $systemconfig->smtp_website_name = $request->smtp_website_name;
       $systemconfig->smtp_server = $request->smtp_server;
       $systemconfig->smtp_port = $request->smtp_port;
       $systemconfig->smtp_email = $request->smtp_email;
       $systemconfig->catering_min_date = $request->catering_min_date;
       $systemconfig->smtp_email_pass = $request->smtp_email_pass;
       $systemconfig->smtp_from_name = $request->smtp_from_name;
       $systemconfig->smtp_from_email = $request->smtp_from_email;
       $systemconfig->smtp_transport_exp = $request->smtp_transport_exp;
       $systemconfig->smtp_encryption = $request->smtp_encryption;
       $systemconfig->currency = $request->currency;
       $systemconfig->order_cutoff_time = $request->order_cutoff_time;
       $systemconfig->pickup_start_time = $request->pickup_start_time;
       $systemconfig->pickup_end_time = $request->pickup_end_time;
       $systemconfig->pickup_catering_start_time = $request->pickup_catering_start_time;
       $systemconfig->pickup_catering_end_time = $request->pickup_catering_end_time;
       $systemconfig->cancel_reasons = $request->cancel_reasons;
       $systemconfig->catering_cancel_cutoff_time = $request->catering_cancel_cutoff_time;

       $systemconfig->save();

       return redirect('showconfig')->with('success','Information changed successfully');
     }

     public function Testmail(Request $request){
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

       $to_name = 'Saurabh Kale';
       $to_email = 'absdevlop@gmail.com';
       $mail_data['name'] = 'Saurabh';
       $mail_data['customthemesetting'] = $customthemesetting;
       Mail::send('admin.mail.test', $mail_data, function($message) use ($to_name, $to_email) {
         $message->to($to_email, $to_name)->subject('Test Mail');
       });
       return redirect('showconfig')->with('success','Mail Send Successfully');
     }
}
