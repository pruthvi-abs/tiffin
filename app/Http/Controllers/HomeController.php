<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\Maincategory;
use App\Category;
use App\Product;
use App\Contact;
use App\ThemeSetting;
use App\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Mail;
use Config;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function pagenotfound(){
      $data['pagetitle']="404";
      return view('errors.404');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $data['pagetitle']="Home";

      $frontslider=Slider::select('title','description','image','btntitle','btnlink')->get();
      $data['frontslider']=$frontslider;

      $maincategory=Maincategory::select('name')->where('status',1)->get();
      $data['maincategory']=$maincategory;

      $products=Product::select('*')->where('is_featured','yes')->where('is_visible','yes')->get();
      $data['products']=$products;

      $theme_data = ThemeSetting::select('order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
      //echo $theme_data->order_cutoff_time."<=".date("h:i:s a");
      if($theme_data->order_cutoff_time >= date("H:i:s")){
        //echo "if";
        $currentdate = Carbon::parse(Carbon::now())->format('Y-m-d');
        $tiffinproducts=Product::select('*')->where('main_categories_id',1)->where('is_visible','yes')->where('tiffin_preparation_date','>=',$currentdate)->orderBy('tiffin_preparation_date')->get();
        $data['tiffinproducts']=$tiffinproducts;
        $todaytiffinproducts=Product::select('*')->where('main_categories_id',1)->where('is_visible','yes')->where('tiffin_preparation_date',$currentdate)->first();
        $data['todaytiffinproducts']=$todaytiffinproducts;
      }else{
        //echo "else";
        $currentdate = Carbon::parse(Carbon::tomorrow())->format('Y-m-d');
        $tiffinproducts=Product::select('*')->where('main_categories_id',1)->where('is_visible','yes')->where('tiffin_preparation_date','>=',$currentdate)->orderBy('tiffin_preparation_date')->get();
        $data['tiffinproducts']=$tiffinproducts;
        $todaytiffinproducts=Product::select('*')->where('main_categories_id',1)->where('is_visible','yes')->where('tiffin_preparation_date',$currentdate)->first();
        $data['todaytiffinproducts']=$todaytiffinproducts;
      }

      $data['Pagetitle']="Home Page";

      return view('front.home.index')->with($data);
    }

    public function submitgetintouch(Request $request){
      $getintouch = new Contact;
      $getintouch->name = $request->name;
      $getintouch->email = $request->email;
      $getintouch->phone = $request->phone;
      if($request->consultationdate != ""){
        $getintouch->consultationdate=Carbon::parse($request->consultationdate)->format('Y-m-d');
      } else{
        $getintouch->consultationdate=$request->consultationdate;
      }
      if($request->eventdate != ""){
        $getintouch->eventdate=Carbon::parse($request->eventdate)->format('Y-m-d');
      } else{
        $getintouch->eventdate=$request->eventdate;
      }
      $getintouch->eventvenue = $request->eventvenue;
      $getintouch->save();

      // $customthemesetting = customthemesetting();
      // $mail = DB::table('theme_settings')->where('id',1)->first();
      // if($mail){
      //   $config = array(
      //     'driver'     => $mail->smtp_transport_exp,
      //       'host'       => $mail->smtp_server,
      //       'port'       => $mail->smtp_port,
      //       'from'       => array('address' => $mail->smtp_from_email, 'name' => $mail->smtp_from_name),
      //       'encryption' => $mail->smtp_encryption,
      //       'username'   => $mail->smtp_email,
      //       'password'   => $mail->smtp_email_pass,
      //       'sendmail'   => '/usr/sbin/sendmail -bs',
      //       'pretend'    => false,
      //   );
      // }
      // Config::set('mail', $config);

      // // User Mail
      // $to_name = $request->name;
      // $to_email = $request->email;
      // $mail_data = [
      //  'name' => $to_name,
      //  'email' => $to_email,
      //  'smtp_from_name' => $customthemesetting->smtp_from_name,
      //  ];
      //  Mail::send('admin.mail.usergetintouch', $mail_data, function($message) use ($to_name, $to_email) {
      //    $message->to($to_email, $to_name)->subject('Thank You');
      //  });

      //  // Admin mail
      //  $admin_to_name = "Admin";
      //  $admin_to_email = $customthemesetting->front_email;;

      //  $user_mail_data = [
      //   'name' => $request->name,
      //   'phone' => $request->phone,
      //   'email' => $request->email,
      //   'consultationdate' => $request->consultationdate,
      //   'eventdate' => $request->eventdate,
      //   'eventvenue' => $request->eventvenue,
      //   'smtp_from_name' => $customthemesetting->smtp_from_name,
      //   ];
      //  Mail::send('admin.mail.admingetintouch', $user_mail_data, function($message) use ($admin_to_name, $admin_to_email) {
      //  $message->to($admin_to_email, $admin_to_name)->subject('Get In Touch');
      //  });
      return redirect('thankyou');
    }

    public function thankyou()
    {
      $data['pagetitle']="Thank You";
      return view('front.cms.thankyou')->with($data);
    }
    public function about()
    {
      $data['pagetitle']="About";
      return view('front.cms.about')->with($data);
    }
    public function termscondition()
    {
      $data['pagetitle']="Terms & Condition";
      return view('front.cms.termscondition')->with($data);
    }
    public function disclaimer()
    {
      $data['pagetitle']="Disclaimer";
      return view('front.cms.disclaimer')->with($data);
    }
    public function contact()
    {
      $data['pagetitle']="Contact";
      return view('front.cms.contact')->with($data);
    }

    public function menu()
    {
      $data['pagetitle']="Let's Eat";
      $categories=Category::select('id','main_category_id','name')->where('main_category_id',3)->where('status',1)->orderby('seq')->get();
      $data['categories']=$categories;
      $data['main_category_id']=3;
      return view('front.productlisting.menulisting')->with($data);
    }
    public function catering()
    {
      $data['pagetitle']="Catering";
      $categories=Category::select('id','main_category_id','name')->where('main_category_id',2)->where('status',1)->orderby('seq')->get();
      $data['categories']=$categories;
      $data['main_category_id']=2;

      $session_id=Session::get('session_id');
      $cart_datas=Cart::where('session_id',$session_id)->orderByDesc('id')->get();
      $total_price=0;
      foreach ($cart_datas as $cart_data){
          $total_price+=$cart_data->price*$cart_data->quantity;
      }
      $data['cart_datas']=$cart_datas;
      $data['total_price']=$total_price;

      return view('front.productlisting.cateringlisting')->with($data);
    }
    public function tiffin()
    {
      $data['pagetitle']="Tiffin";
      $categories=Category::select('id','main_category_id','name')->where('main_category_id',1)->where('status',1)->orderby('seq')->get();
      $data['categories']=$categories;
      $data['main_category_id']=1;
      return view('front.productlisting.tiffinlisting')->with($data);
    }

}
