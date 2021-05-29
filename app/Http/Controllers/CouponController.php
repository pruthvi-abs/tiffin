<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         //
         $data['webpage']='Coupon';
         $data['action']='Coupon';
         $data['menu']='master';
         return view('admin.coupon.index')->with($data);
     }
     function getCoupon()
     {
       $customthemesetting = customthemesetting();
         $user = Auth::user();
         $Coupons=Coupon::select('id','coupon_code','amount','min_amount','amount_type','expiry_date','status','created_at')->get();
         $Coupon_data=array();
         $i=1;
         foreach($Coupons as $Coupon){
           $Coupon_data[$i]['sr_no']=$i;
           $Coupon_data[$i]['id']=$Coupon->id;
           $Coupon_data[$i]['coupon_code']=$Coupon->coupon_code;
           $Coupon_data[$i]['amount']=$customthemesetting->currency.$Coupon->amount;
           $Coupon_data[$i]['min_amount']=$customthemesetting->currency.$Coupon->min_amount;
           $Coupon_data[$i]['amount_type']=$Coupon->amount_type;
           $Coupon_data[$i]['expiry_date']=$Coupon->expiry_date;
           if($Coupon->status==1){
             $Coupon_data[$i]['status']="Enable";
           }else{
             $Coupon_data[$i]['status']="Disable";
           }
           $Coupon_data[$i]['created_at']=Carbon::parse($Coupon->created_at)->format($customthemesetting->datetime_format);
           $i++;
         }
         return Datatables::of($Coupon_data)->make(true);
     }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
       $data['webpage']='Coupon';
       $data['action']='Coupon -> Create Coupon';
       $data['menu']='master';
       return view('admin.coupon.create')->with($data);
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
       $customthemesetting = customthemesetting();
       $this->validate($request, [
           'coupon_code' => 'required',
           'amount' => 'required',
           'amount_type' => 'required',
           'expiry_date' => 'required',
           'status' => 'required',
           'min_amount' => 'required',
       ]);
       $Coupon = new Coupon;
       $Coupon->coupon_code = $request->coupon_code;
       $Coupon->amount = $request->amount;
       $Coupon->min_amount = $request->min_amount;
       $Coupon->amount_type = $request->amount_type;
       $Coupon->expiry_date = Carbon::parse($request->expiry_date)->format('Y-m-d');
       $Coupon->status = $request->status;
       $Coupon->save();
       return redirect('coupon')->with('success','Information added successfully');
     }

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
         //
     }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
       $customthemesetting = customthemesetting();
         //
          //$ip_address=$_SERVER['REMOTE_ADDR'];
          //$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
          //$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
          //$timezone = $addrDetailsArr['geoplugin_timezone'];

        $coupon=Coupon::findOrFail($id);
         //$coupon->expiry_date=Carbon::parse($coupon->expiry_date)->timezone($timezone)->format($customthemesetting->datetime_format);
         $coupon->expiry_date=Carbon::parse($coupon->expiry_date)->format('m/d/Y');
         $data['coupon']=$coupon;
         $data['webpage']='Coupon';
         $data['action']='Coupon -> Edit Coupon';
         $data['menu']='master';
         return view('admin.coupon.edit')->with($data);

     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {
         //
         $this->validate($request, [
             'coupon_code' => 'required',
             'amount' => 'required',
             'amount_type' => 'required',
             'expiry_date' => 'required',
             'status' => 'required',
             'min_amount' => 'required',
         ]);

         $Coupon=Coupon::findOrFail($id);
         $Coupon->coupon_code = $request->coupon_code;
         $Coupon->amount = $request->amount;
         $Coupon->min_amount = $request->min_amount;
         $Coupon->amount_type = $request->amount_type;
         $Coupon->expiry_date = Carbon::parse($request->expiry_date)->format('Y-m-d');
         $Coupon->status = $request->status;
         $Coupon->save();
         return redirect('coupon')->with('success','Information changed successfully');

     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
         //
         $Coupon=Coupon::findOrFail($id)->delete();
         $error=0;
         return $error;
     }

     public function applycoupon(Request $request){
        $this->validate($request,[
            'coupon_code'=>'required'
        ]);
        $input_data=$request->all();
        $coupon_code=$input_data['coupon_code'];
        $total_amount_price=$input_data['Total_amountPrice'];
        $check_coupon=Coupon::where('coupon_code',$coupon_code)->count();
        if($check_coupon==0){
            return back()->with('message_coupon','Your Coupon Code Not Exist!');
        }else if($check_coupon==1){
            $check_status=Coupon::where('status',1)->where('coupon_code',$coupon_code)->first();
            if($check_status->status==0){
                return back()->with('message_coupon','Your Coupon was Disabled!');
            }else{
                $expiried_date=$check_status->expiry_date;
                $date_now=date('Y-m-d');
                if($expiried_date<$date_now){
                    return back()->with('message_coupon','Your Coupon was Expired!');
                }else{
                  if($total_amount_price >= $check_status->min_amount){
                      if($check_status->amount_type=="Fixed"){
                        $discount_amount_price = $check_status->amount;
                        Session::put('discount_amount_price',$discount_amount_price);
                        Session::put('coupon_code',$check_status->coupon_code);
                      }else{
                        $discount_amount_price=($total_amount_price*$check_status->amount)/100;
                        Session::put('discount_amount_price',$discount_amount_price);
                        Session::put('coupon_code',$check_status->coupon_code);
                      }
                      return back()->with('message_apply_sucess','Your Coupon Code was Applied Successfully');
                  }else{
                    return back()->with('message_coupon','Your Cart amount is lower then $'.$check_status->min_amount);
                  }
                }
            }
        }
    }
 }
