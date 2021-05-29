<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Orderproduct;
use App\Orderpayments;
use App\User;
use App\Photo;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Mail;
use Config;
//use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

class OrdersController extends Controller
{
    public function index(){
        $data['pagetitle']="Order Review";
        $session_id=Session::get('session_id');
        $cart_datas=Cart::where('session_id',$session_id)->get();
        $cart_count=Cart::where('session_id',$session_id)->count();
        if($cart_count==0){
          return redirect('/viewcart');
        }else{
          $total_price=0;
          foreach ($cart_datas as $cart_data){
              $total_price+=$cart_data->price*$cart_data->quantity;
          }
          $data['cart_datas']=$cart_datas;
          $data['total_price']=$total_price;
          //$data['shipping_address']=DB::table('delivery_addresses')->where('users_id',Auth::id())->first();
          if(Auth::check()){
            $data['users_details'] = DB::table('users')->select('id','name','email','mobile')->where('id',Auth::id())->first();
          }
          return view('front.checkout.review_order')->with($data);
        }
    }

    public function order(Request $request){
      $input_data=$request->all();
      $user_mail_name="";
      $user_mail_email="";
      $session_id=Session::get('session_id');
      //$i=0;
      //$data = [];
      $tiffin_data = [];
      $catering_data = [];
      $menu_data = [];
      $tiffin_i=0;
      $catering_i=0;
      $menu_i=0;

      $input_data=$request->all();
      $payment_method=$input_data['payment_method'];
      if($payment_method=="POP"){   // Pay and Pickup
        $order_status = "Accepted";
        $amount_received = "No";
      }elseif($payment_method=="PaypalPartial"){
        $order_status = "Accepted";
        $amount_received = "No";
      }else{   // Paypal
        $order_status = "Accepted";
        $amount_received = "Yes";
      }

      //check which type of root category available in the cart.
      $tiffin_found=0;
      $catering_found=0;
      $menu_found=0;
      $cart_datas=Cart::where('session_id',$session_id)->get();
      foreach ($cart_datas as $cart_data){
        $getrootcategoryid = getrootcategoryid($cart_data->products_id);
        // tiffin
        if($getrootcategoryid==1){$tiffin_found=1;}
        // catering
        if($getrootcategoryid==2){$catering_found=1;}
        // menu
        if($getrootcategoryid==3){$menu_found=1;}
      }


      // Order Logic
      if($payment_method=="POP"){ // POP
          if(Auth::check()){
            $user_mail_name = Auth::user()->name;
            $user_mail_email = Auth::user()->email;
            $input_data=$request->all();
            $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
            $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
            $input_data['order_status']= $order_status;
            $input_data['amount_received']= $amount_received;
            // if tiffin category found
            if($tiffin_found==1){
                $tiffin_order_id="";
                $tiffin_i=0;
                $input_data['main_categories_id']=1;
                $grand_total=0;
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==1){
                    $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                  }
                }
                $input_data['grand_total']=$grand_total;
                $order = Order::create($input_data);
                $tiffin_order_id = $order->id;
                $cart_datas=Cart::where('session_id',$session_id)->get();
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==1){
                      $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                      $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                      $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                      $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                      $orderproduct = new Orderproduct;
                      $orderproduct->order_id = $tiffin_order_id;
                      $orderproduct->p_id = $cart_data->products_id;
                      $orderproduct->p_code = $cart_data->product_code;
                      $orderproduct->p_name = $cart_data->product_name;
                      $orderproduct->p_price = $cart_data->price;
                      $orderproduct->p_qty = $cart_data->quantity;
                      $orderproduct->save();
                      Cart::where('id', $cart_data->id)->forceDelete();
                      $tiffin_i++;
                  }
                }
            }
            // if catering category found
            if($catering_found==1){
                $catering_order_id="";
                $catering_i=0;
                $input_data['main_categories_id']=2;
                $grand_total=0;
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==2){
                    $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                  }
                }
                $input_data['grand_total']=$grand_total;
                $order = Order::create($input_data);
                $catering_order_id = $order->id;
                $cart_datas=Cart::where('session_id',$session_id)->get();
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==2){
                      $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                      $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                      $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                      $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                      $orderproduct = new Orderproduct;
                      $orderproduct->order_id = $catering_order_id;
                      $orderproduct->p_id = $cart_data->products_id;
                      $orderproduct->p_code = $cart_data->product_code;
                      $orderproduct->p_name = $cart_data->product_name;
                      $orderproduct->p_price = $cart_data->price;
                      $orderproduct->p_qty = $cart_data->quantity;
                      $orderproduct->save();
                      Cart::where('id', $cart_data->id)->forceDelete();
                      $catering_i++;
                  }
                }
            }
            // if menu category found
            if($menu_found==1){
                $menu_order_id="";
                $menu_i=0;
                $input_data['main_categories_id']=3;
                $grand_total=0;
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==3){
                    $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                  }
                }
                $input_data['grand_total']=$grand_total;
                $order = Order::create($input_data);
                $menu_order_id = $order->id;
                $cart_datas=Cart::where('session_id',$session_id)->get();
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==3){
                      $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                      $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                      $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                      $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                      $orderproduct = new Orderproduct;
                      $orderproduct->order_id = $menu_order_id;
                      $orderproduct->p_id = $cart_data->products_id;
                      $orderproduct->p_code = $cart_data->product_code;
                      $orderproduct->p_name = $cart_data->product_name;
                      $orderproduct->p_price = $cart_data->price;
                      $orderproduct->p_qty = $cart_data->quantity;
                      $orderproduct->save();
                      Cart::where('id', $cart_data->id)->forceDelete();
                      $menu_i++;
                  }
                }
            }
          }else{
            $input_data=$request->all();
            if(isset($input_data['creataccount'])){
              $userdata = DB::table('users')->where('email',$input_data['users_email'])->first();
              if($userdata==null){
                // user create
                $user = new User;
                $user->role_id=5;
                $user->name=$input_data['name'];
                $user->email=$input_data['users_email'];
                $user->mobile=$input_data['mobile'];
                $user->is_active=1;
                $user->password=bcrypt($input_data['password']);
                $user->save();
                $user_mail_name = $input_data['name'];
                $user_mail_email = $input_data['users_email'];
                if(Auth::attempt(['email'=>$input_data['users_email'],'password'=>$input_data['password']])){
                    Session::put('frontSession',$input_data['users_email']);
                }
                // mail trigger for user creation
                $input_data['users_id']=$user->id;
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $tiffin_i++;
                      }
                    }
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $catering_i++;
                      }
                    }
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $menu_i++;
                      }
                    }
                }
              }else{
                $user_mail_name = $input_data['name'];
                $user_mail_email = $input_data['users_email'];
                //if(Auth::attempt(['email'=>$input_data['users_email'],'password'=>$input_data['password']])){
                  Session::put('frontSession',$input_data['users_email']);
                //}
                $input_data['users_id']=$userdata->id;
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $tiffin_i++;
                      }
                    }
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $catering_i++;
                      }
                    }
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $menu_i++;
                      }
                    }
                }
              }
            }else{
              $user_mail_name = $input_data['name'];
              $user_mail_email = $input_data['users_email'];
              $userdata = DB::table('users')->where('email',$input_data['users_email'])->first();
              if($userdata==null){
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $tiffin_i++;
                      }
                    }
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $catering_i++;
                      }
                    }
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $menu_i++;
                      }
                    }
                }
              }else{
                $input_data['users_id']=$userdata->id;
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $tiffin_i++;
                      }
                    }
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $catering_i++;
                      }
                    }
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();
                          Cart::where('id', $cart_data->id)->forceDelete();
                          $menu_i++;
                      }
                    }
                }
              }
            }
        }
          // Order Mail
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
          // User Mail
          if($tiffin_found==1){
            $to_name = $user_mail_name;
            $to_email = $user_mail_email;
            $mail_data['username'] = $user_mail_name;
            $mail_data['order_id'] = $tiffin_order_id;
            $mail_data['order_data'] = $tiffin_data['items'];
            $mail_data['payment_method'] = $input_data['payment_method'];
            $mail_data['customthemesetting'] = $customthemesetting;
            $mail_data['payment_status'] = "Unpaid";
            $subject = "Prasadam - Confirmation #".$tiffin_order_id;
            Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
              $message->to($to_email, $to_name)->subject($subject);
            });
          }
          if($catering_found==1){
            $to_name = $user_mail_name;
            $to_email = $user_mail_email;
            $mail_data['username'] = $user_mail_name;
            $mail_data['order_id'] = $catering_order_id;
            $mail_data['order_data'] = $catering_data['items'];
            $mail_data['payment_method'] = $input_data['payment_method'];
            $mail_data['customthemesetting'] = $customthemesetting;
            $mail_data['payment_status'] = "Unpaid";
            $subject = "Prasadam - Confirmation #".$catering_order_id;
            Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
              $message->to($to_email, $to_name)->subject($subject);
            });
          }
          if($menu_found==1){
            $to_name = $user_mail_name;
            $to_email = $user_mail_email;
            $mail_data['username'] = $user_mail_name;
            $mail_data['order_id'] = $menu_order_id;
            $mail_data['order_data'] = $menu_data['items'];
            $mail_data['payment_method'] = $input_data['payment_method'];
            $mail_data['customthemesetting'] = $customthemesetting;
            $mail_data['payment_status'] = "Unpaid";
            $subject = "Prasadam - Confirmation #".$menu_order_id;
            Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
              $message->to($to_email, $to_name)->subject($subject);
            });
          }

          // Admin Mail
          if($tiffin_found==1){
            $to_name = "Admin";
            $to_email = $customthemesetting->front_email;
            $mail_data['username'] = "Admin";
            $mail_data['order_id'] = $tiffin_order_id;
            $mail_data['customthemesetting'] = $customthemesetting;
            $mail_data['order_data'] = $tiffin_data['items'];
            $mail_data['payment_method'] = $input_data['payment_method'];
            $mail_data['payment_status'] = "Unpaid";
            $subject = "Prasadam - Confirmation #".$tiffin_order_id;
            Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
              $message->to($to_email, $to_name)->subject($subject);
            });
          }
          if($catering_found==1){
            $to_name = "Admin";
            $to_email = $customthemesetting->front_email;
            $mail_data['username'] = "Admin";
            $mail_data['order_id'] = $catering_order_id;
            $mail_data['customthemesetting'] = $customthemesetting;
            $mail_data['order_data'] = $catering_data['items'];
            $mail_data['payment_method'] = $input_data['payment_method'];
            $mail_data['payment_status'] = "Unpaid";
            $subject = "Prasadam - Confirmation #".$catering_order_id;
            Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
              $message->to($to_email, $to_name)->subject($subject);
            });
          }
          if($menu_found==1){
            $to_name = "Admin";
            $to_email = $customthemesetting->front_email;
            $mail_data['username'] = "Admin";
            $mail_data['order_id'] = $menu_order_id;
            $mail_data['customthemesetting'] = $customthemesetting;
            $mail_data['order_data'] = $menu_data['items'];
            $mail_data['payment_method'] = $input_data['payment_method'];
            $mail_data['payment_status'] = "Unpaid";
            $subject = "Prasadam - Confirmation #".$menu_order_id;
            Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
              $message->to($to_email, $to_name)->subject($subject);
            });
          }
      $cod_order_id="";
      $session_cod_order_id=array();
      $sq=0;
      if($tiffin_found==1){ $cod_order_id.= "#".$tiffin_order_id." "; $session_cod_order_id[$sq]=$tiffin_order_id;$sq++; }
      if($catering_found==1){ $cod_order_id.= "#".$catering_order_id." "; $session_cod_order_id[$sq]=$catering_order_id;$sq++; }
      if($menu_found==1){ $cod_order_id.= "#".$menu_order_id." "; $session_cod_order_id[$sq]=$menu_order_id;$sq++; }
      Session::put('session_cod_order_id',$session_cod_order_id);
          // Order Mail
      return redirect('/cod');

      }elseif($payment_method=="PaypalPartial"){
      // Paypal Partial ( 50% )
      // ************************************************************************************************************
      ////////////// data pass on paypal
      $data=array();
      $i=0;
      foreach ($cart_datas as $cart_data){
        $data['items'][$i]['name'] = $cart_data->product_name;
        $data['items'][$i]['price'] = round($cart_data->price/2,2);
        $data['items'][$i]['desc'] = $cart_data->product_code;
        $data['items'][$i]['qty'] = $cart_data->quantity;
        $i++;
      }

      if(Auth::check()){
          $user_mail_name = Auth::user()->name;
          $user_mail_email = Auth::user()->email;
          $input_data=$request->all();
          $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
          $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
          $input_data['order_status']= $order_status;
          $input_data['amount_received']= $amount_received;
          // if tiffin category found
          if($tiffin_found==1){
              $tiffin_order_id="";
              $tiffin_i=0;
              $input_data['main_categories_id']=1;
              $grand_total=0;
              foreach ($cart_datas as $cart_data){
                $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                if($getrootcategoryid==1){
                  $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                }
              }
              $input_data['grand_total']=$grand_total;
              $input_data['payment_method']="Paypal";
              $order = Order::create($input_data);
              $tiffin_order_id = $order->id;
              $cart_datas=Cart::where('session_id',$session_id)->get();
              foreach ($cart_datas as $cart_data){
                $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                if($getrootcategoryid==1){
                    $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                    $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                    $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                    $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                    $orderproduct = new Orderproduct;
                    $orderproduct->order_id = $tiffin_order_id;
                    $orderproduct->p_id = $cart_data->products_id;
                    $orderproduct->p_code = $cart_data->product_code;
                    $orderproduct->p_name = $cart_data->product_name;
                    $orderproduct->p_price = $cart_data->price;
                    $orderproduct->p_qty = $cart_data->quantity;
                    $orderproduct->save();

                    Cart::where('id', $cart_data->id)->delete();
                    $tiffin_i++;
                }
              }
              $orderpayment = new Orderpayments;
              $orderpayment->order_id = $tiffin_order_id;
              $orderpayment->payment_type = "Paypal";
              $orderpayment->payment_details = "";
              $partial_grand_total=$grand_total/2;
              $orderpayment->payment_amount = $partial_grand_total;
              $orderpayment->payment_date = date('Y-m-d H:i:s');
              $orderpayment->save();
              //partially delete logi

          }
          // if catering category found
          if($catering_found==1){
              $catering_order_id="";
              $catering_i=0;
              $input_data['main_categories_id']=2;
              $grand_total=0;
              foreach ($cart_datas as $cart_data){
                $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                if($getrootcategoryid==2){
                  $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                }
              }
              $input_data['grand_total']=$grand_total;
              $input_data['payment_method']="Paypal";
              $order = Order::create($input_data);
              $catering_order_id = $order->id;
              $cart_datas=Cart::where('session_id',$session_id)->get();
              foreach ($cart_datas as $cart_data){
                $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                if($getrootcategoryid==2){
                    $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                    $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                    $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                    $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                    $orderproduct = new Orderproduct;
                    $orderproduct->order_id = $catering_order_id;
                    $orderproduct->p_id = $cart_data->products_id;
                    $orderproduct->p_code = $cart_data->product_code;
                    $orderproduct->p_name = $cart_data->product_name;
                    $orderproduct->p_price = $cart_data->price;
                    $orderproduct->p_qty = $cart_data->quantity;
                    $orderproduct->save();

                    Cart::where('id', $cart_data->id)->delete();
                    $catering_i++;
                }
              }
              $orderpayment = new Orderpayments;
              $orderpayment->order_id = $catering_order_id;
              $orderpayment->payment_type = "Paypal";
              $orderpayment->payment_details = "";
              $partial_grand_total=$grand_total/2;
              $orderpayment->payment_amount = $partial_grand_total;
              $orderpayment->payment_date = date('Y-m-d H:i:s');
              $orderpayment->save();
          }
          // if menu category found
          if($menu_found==1){
              $menu_order_id="";
              $menu_i=0;
              $input_data['main_categories_id']=3;
              $grand_total=0;
              foreach ($cart_datas as $cart_data){
                $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                if($getrootcategoryid==3){
                  $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                }
              }
              $input_data['payment_method']="Paypal";
              $input_data['grand_total']=$grand_total;
              $order = Order::create($input_data);
              $menu_order_id = $order->id;
              $cart_datas=Cart::where('session_id',$session_id)->get();
              foreach ($cart_datas as $cart_data){
                $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                if($getrootcategoryid==3){
                    $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                    $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                    $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                    $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                    $orderproduct = new Orderproduct;
                    $orderproduct->order_id = $menu_order_id;
                    $orderproduct->p_id = $cart_data->products_id;
                    $orderproduct->p_code = $cart_data->product_code;
                    $orderproduct->p_name = $cart_data->product_name;
                    $orderproduct->p_price = $cart_data->price;
                    $orderproduct->p_qty = $cart_data->quantity;
                    $orderproduct->save();

                    Cart::where('id', $cart_data->id)->delete();
                    $menu_i++;
                }
              }
              $orderpayment = new Orderpayments;
              $orderpayment->order_id = $menu_order_id;
              $orderpayment->payment_type = "Paypal";
              $orderpayment->payment_details = "";
              $partial_grand_total=$grand_total/2;
              $orderpayment->payment_amount = $partial_grand_total;
              $orderpayment->payment_date = date('Y-m-d H:i:s');
              $orderpayment->save();
          }
        }else{
          $input_data=$request->all();
          if(isset($input_data['creataccount'])){
            $userdata = DB::table('users')->where('email',$input_data['users_email'])->first();
            if($userdata==null){
              // user create
              $user = new User;
              $user->role_id=5;
              $user->name=$input_data['name'];
              $user->email=$input_data['users_email'];
              $user->mobile=$input_data['mobile'];
              $user->is_active=1;
              $user->password=bcrypt($input_data['password']);
              $user->save();
              $user_mail_name = $input_data['name'];
              $user_mail_email = $input_data['users_email'];
              if(Auth::attempt(['email'=>$input_data['users_email'],'password'=>$input_data['password']])){
                  Session::put('frontSession',$input_data['users_email']);
              }
              // mail trigger for user creation
              $input_data['users_id']=$user->id;
              $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
              $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
              $input_data['order_status']= $order_status;
              $input_data['amount_received']= $amount_received;
              // if tiffin category found
              if($tiffin_found==1){
                  $tiffin_order_id="";
                  $tiffin_i=0;
                  $input_data['main_categories_id']=1;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $tiffin_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                        $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                        $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                        $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                        $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $tiffin_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $tiffin_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $tiffin_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if catering category found
              if($catering_found==1){
                  $catering_order_id="";
                  $catering_i=0;
                  $input_data['main_categories_id']=2;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $catering_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                        $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                        $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                        $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                        $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $catering_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();
                        Cart::where('id', $cart_data->id)->delete();
                        $catering_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $catering_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if menu category found
              if($menu_found==1){
                  $menu_order_id="";
                  $menu_i=0;
                  $input_data['main_categories_id']=3;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $menu_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                        $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                        $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                        $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                        $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $menu_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();
                        Cart::where('id', $cart_data->id)->delete();
                        $menu_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $menu_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
            }else{
              $user_mail_name = $input_data['name'];
              $user_mail_email = $input_data['users_email'];
              //if(Auth::attempt(['email'=>$input_data['users_email'],'password'=>$input_data['password']])){
                Session::put('frontSession',$input_data['users_email']);
              //}
              $input_data['users_id']=$userdata->id;
              $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
              $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
              $input_data['order_status']= $order_status;
              $input_data['amount_received']= $amount_received;
              // if tiffin category found
              if($tiffin_found==1){
                  $tiffin_order_id="";
                  $tiffin_i=0;
                  $input_data['main_categories_id']=1;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $tiffin_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                        $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                        $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                        $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                        $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $tiffin_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();
                        Cart::where('id', $cart_data->id)->delete();
                        $tiffin_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $tiffin_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if catering category found
              if($catering_found==1){
                  $catering_order_id="";
                  $catering_i=0;
                  $input_data['main_categories_id']=2;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $catering_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                        $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                        $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                        $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                        $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $catering_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();
                        Cart::where('id', $cart_data->id)->delete();
                        $catering_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $catering_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if menu category found
              if($menu_found==1){
                  $menu_order_id="";
                  $menu_i=0;
                  $input_data['main_categories_id']=3;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $menu_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                        $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                        $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                        $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                        $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $menu_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $menu_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $menu_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
            }
          }else{
            $user_mail_name = $input_data['name'];
            $user_mail_email = $input_data['users_email'];
            $userdata = DB::table('users')->where('email',$input_data['users_email'])->first();
            if($userdata==null){
              $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
              $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
              $input_data['order_status']= $order_status;
              $input_data['amount_received']= $amount_received;
              // if tiffin category found
              if($tiffin_found==1){
                  $tiffin_order_id="";
                  $tiffin_i=0;
                  $input_data['main_categories_id']=1;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $tiffin_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                        $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                        $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                        $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                        $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $tiffin_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $tiffin_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $tiffin_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if catering category found
              if($catering_found==1){
                  $catering_order_id="";
                  $catering_i=0;
                  $input_data['main_categories_id']=2;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $catering_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                        $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                        $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                        $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                        $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $catering_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $catering_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $catering_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if menu category found
              if($menu_found==1){
                  $menu_order_id="";
                  $menu_i=0;
                  $input_data['main_categories_id']=3;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $menu_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                        $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                        $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                        $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                        $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $menu_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $menu_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $menu_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
            }else{
              $input_data['users_id']=$userdata->id;
              $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
              $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
              $input_data['order_status']= $order_status;
              $input_data['amount_received']= $amount_received;
              // if tiffin category found
              if($tiffin_found==1){
                  $tiffin_order_id="";
                  $tiffin_i=0;
                  $input_data['main_categories_id']=1;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $tiffin_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==1){
                        $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                        $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                        $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                        $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $tiffin_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $tiffin_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $tiffin_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if catering category found
              if($catering_found==1){
                  $catering_order_id="";
                  $catering_i=0;
                  $input_data['main_categories_id']=2;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $catering_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==2){
                        $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                        $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                        $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                        $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $catering_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $catering_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $catering_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
              // if menu category found
              if($menu_found==1){
                  $menu_order_id="";
                  $menu_i=0;
                  $input_data['main_categories_id']=3;
                  $grand_total=0;
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                      $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                    }
                  }
                  $input_data['payment_method']="Paypal";
                  $input_data['grand_total']=$grand_total;
                  $order = Order::create($input_data);
                  $menu_order_id = $order->id;
                  $cart_datas=Cart::where('session_id',$session_id)->get();
                  foreach ($cart_datas as $cart_data){
                    $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                    if($getrootcategoryid==3){
                        $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                        $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                        $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                        $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                        $orderproduct = new Orderproduct;
                        $orderproduct->order_id = $menu_order_id;
                        $orderproduct->p_id = $cart_data->products_id;
                        $orderproduct->p_code = $cart_data->product_code;
                        $orderproduct->p_name = $cart_data->product_name;
                        $orderproduct->p_price = $cart_data->price;
                        $orderproduct->p_qty = $cart_data->quantity;
                        $orderproduct->save();

                        Cart::where('id', $cart_data->id)->delete();
                        $menu_i++;
                    }
                  }
                  $orderpayment = new Orderpayments;
                  $orderpayment->order_id = $menu_order_id;
                  $orderpayment->payment_type = "Paypal";
                  $orderpayment->payment_details = "";
                  $partial_grand_total=$grand_total/2;
                  $orderpayment->payment_amount = $partial_grand_total;
                  $orderpayment->payment_date = date('Y-m-d H:i:s');
                  $orderpayment->save();
              }
            }
          }
      }

      $paypal_order_id="";
      $session_paypal_order_id=array();
      $sq=0;
      if($tiffin_found==1){ $paypal_order_id.= "#".$tiffin_order_id." "; $session_paypal_order_id[$sq]=$tiffin_order_id;$sq++; }
      if($catering_found==1){ $paypal_order_id.= "#".$catering_order_id." "; $session_paypal_order_id[$sq]=$catering_order_id;$sq++; }
      if($menu_found==1){ $paypal_order_id.= "#".$menu_order_id." "; $session_paypal_order_id[$sq]=$menu_order_id;$sq++; }
      Session::put('session_paypal_order_id',$session_paypal_order_id);
      $order_id=$paypal_order_id;

      $session_paypal_order_id=Session::get('session_paypal_order_id');
      for($q=0;$q<count($session_paypal_order_id);$q++){
        $order_update = Order::findOrFail($session_paypal_order_id[$q]);
        $order_update->deleted_at = date('Y-m-d');
        $order_update->save();
      }

      $provider = new ExpressCheckout;
      $data['invoice_id'] = $order_id;
      $data['invoice_description'] = "Confirmation {$data['invoice_id']} Invoice";
      $data['return_url'] = url('/paypal');
      $data['cancel_url'] = url('/viewcart');
      $total = 0;
      foreach($data['items'] as $item) {
          $total = $total + ($item['price']*$item['qty']);
      }
      $data['total'] = $total;
      $data['shipping_discount'] = 0;
      $response = $provider->setExpressCheckout($data);
      return redirect($response['paypal_link']);

      // ************************************************************************************************************
      }else{
        // Paypal
        ////////////// data pass on paypal
        $data=array();
        $i=0;
        foreach ($cart_datas as $cart_data){
          $data['items'][$i]['name'] = $cart_data->product_name;
          $data['items'][$i]['price'] = $cart_data->price;
          $data['items'][$i]['desc'] = $cart_data->product_code;
          $data['items'][$i]['qty'] = $cart_data->quantity;
          $i++;
        }
        //////////

        if(Auth::check()){
            $user_mail_name = Auth::user()->name;
            $user_mail_email = Auth::user()->email;
            $input_data=$request->all();
            $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
            $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
            $input_data['order_status']= $order_status;
            $input_data['amount_received']= $amount_received;
            // if tiffin category found
            if($tiffin_found==1){
                $tiffin_order_id="";
                $tiffin_i=0;
                $input_data['main_categories_id']=1;
                $grand_total=0;
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==1){
                    $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                  }
                }
                $input_data['grand_total']=$grand_total;
                $order = Order::create($input_data);
                $tiffin_order_id = $order->id;
                $cart_datas=Cart::where('session_id',$session_id)->get();
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==1){
                      $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                      $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                      $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                      $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                      $orderproduct = new Orderproduct;
                      $orderproduct->order_id = $tiffin_order_id;
                      $orderproduct->p_id = $cart_data->products_id;
                      $orderproduct->p_code = $cart_data->product_code;
                      $orderproduct->p_name = $cart_data->product_name;
                      $orderproduct->p_price = $cart_data->price;
                      $orderproduct->p_qty = $cart_data->quantity;
                      $orderproduct->save();

                      Cart::where('id', $cart_data->id)->delete();
                      $tiffin_i++;
                  }
                }
                $orderpayment = new Orderpayments;
                $orderpayment->order_id = $tiffin_order_id;
                $orderpayment->payment_type = "Paypal";
                $orderpayment->payment_details = "";
                $orderpayment->payment_amount = $grand_total;
                $orderpayment->payment_date = date('Y-m-d H:i:s');
                $orderpayment->save();
                //partially delete logi

            }
            // if catering category found
            if($catering_found==1){
                $catering_order_id="";
                $catering_i=0;
                $input_data['main_categories_id']=2;
                $grand_total=0;
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==2){
                    $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                  }
                }
                $input_data['grand_total']=$grand_total;
                $order = Order::create($input_data);
                $catering_order_id = $order->id;
                $cart_datas=Cart::where('session_id',$session_id)->get();
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==2){
                      $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                      $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                      $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                      $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                      $orderproduct = new Orderproduct;
                      $orderproduct->order_id = $catering_order_id;
                      $orderproduct->p_id = $cart_data->products_id;
                      $orderproduct->p_code = $cart_data->product_code;
                      $orderproduct->p_name = $cart_data->product_name;
                      $orderproduct->p_price = $cart_data->price;
                      $orderproduct->p_qty = $cart_data->quantity;
                      $orderproduct->save();

                      Cart::where('id', $cart_data->id)->delete();
                      $catering_i++;
                  }
                }
                $orderpayment = new Orderpayments;
                $orderpayment->order_id = $catering_order_id;
                $orderpayment->payment_type = "Paypal";
                $orderpayment->payment_details = "";
                $orderpayment->payment_amount = $grand_total;
                $orderpayment->payment_date = date('Y-m-d H:i:s');
                $orderpayment->save();
            }
            // if menu category found
            if($menu_found==1){
                $menu_order_id="";
                $menu_i=0;
                $input_data['main_categories_id']=3;
                $grand_total=0;
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==3){
                    $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                  }
                }
                $input_data['grand_total']=$grand_total;
                $order = Order::create($input_data);
                $menu_order_id = $order->id;
                $cart_datas=Cart::where('session_id',$session_id)->get();
                foreach ($cart_datas as $cart_data){
                  $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                  if($getrootcategoryid==3){
                      $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                      $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                      $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                      $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                      $orderproduct = new Orderproduct;
                      $orderproduct->order_id = $menu_order_id;
                      $orderproduct->p_id = $cart_data->products_id;
                      $orderproduct->p_code = $cart_data->product_code;
                      $orderproduct->p_name = $cart_data->product_name;
                      $orderproduct->p_price = $cart_data->price;
                      $orderproduct->p_qty = $cart_data->quantity;
                      $orderproduct->save();

                      Cart::where('id', $cart_data->id)->delete();
                      $menu_i++;
                  }
                }
                $orderpayment = new Orderpayments;
                $orderpayment->order_id = $menu_order_id;
                $orderpayment->payment_type = "Paypal";
                $orderpayment->payment_details = "";
                $orderpayment->payment_amount = $grand_total;
                $orderpayment->payment_date = date('Y-m-d H:i:s');
                $orderpayment->save();
            }
          }else{
            $input_data=$request->all();
            if(isset($input_data['creataccount'])){
              $userdata = DB::table('users')->where('email',$input_data['users_email'])->first();
              if($userdata==null){
                // user create
                $user = new User;
                $user->role_id=5;
                $user->name=$input_data['name'];
                $user->email=$input_data['users_email'];
                $user->mobile=$input_data['mobile'];
                $user->is_active=1;
                $user->password=bcrypt($input_data['password']);
                $user->save();
                $user_mail_name = $input_data['name'];
                $user_mail_email = $input_data['users_email'];
                if(Auth::attempt(['email'=>$input_data['users_email'],'password'=>$input_data['password']])){
                    Session::put('frontSession',$input_data['users_email']);
                }
                // mail trigger for user creation
                $input_data['users_id']=$user->id;
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $tiffin_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $tiffin_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $catering_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $catering_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $menu_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $menu_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
              }else{
                $user_mail_name = $input_data['name'];
                $user_mail_email = $input_data['users_email'];
                //if(Auth::attempt(['email'=>$input_data['users_email'],'password'=>$input_data['password']])){
                  Session::put('frontSession',$input_data['users_email']);
                //}
                $input_data['users_id']=$userdata->id;
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $tiffin_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $tiffin_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $catering_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $catering_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $menu_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $menu_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
              }
            }else{
              $user_mail_name = $input_data['name'];
              $user_mail_email = $input_data['users_email'];
              $userdata = DB::table('users')->where('email',$input_data['users_email'])->first();
              if($userdata==null){
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $tiffin_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $tiffin_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $catering_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $catering_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $menu_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $menu_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
              }else{
                $input_data['users_id']=$userdata->id;
                $f_order_date = $input_data['delivery_date']." ".$input_data['delivery_time'];
                $input_data['delivery_date']= Carbon::parse($f_order_date)->format('Y-m-d H:i:s');
                $input_data['order_status']= $order_status;
                $input_data['amount_received']= $amount_received;
                // if tiffin category found
                if($tiffin_found==1){
                    $tiffin_order_id="";
                    $tiffin_i=0;
                    $input_data['main_categories_id']=1;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $tiffin_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==1){
                          $tiffin_data['items'][$tiffin_i]['name'] = $cart_data->product_name;
                          $tiffin_data['items'][$tiffin_i]['price'] = $cart_data->price;
                          $tiffin_data['items'][$tiffin_i]['desc'] = $cart_data->product_code;
                          $tiffin_data['items'][$tiffin_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $tiffin_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $tiffin_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $tiffin_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if catering category found
                if($catering_found==1){
                    $catering_order_id="";
                    $catering_i=0;
                    $input_data['main_categories_id']=2;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $catering_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==2){
                          $catering_data['items'][$catering_i]['name'] = $cart_data->product_name;
                          $catering_data['items'][$catering_i]['price'] = $cart_data->price;
                          $catering_data['items'][$catering_i]['desc'] = $cart_data->product_code;
                          $catering_data['items'][$catering_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $catering_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $catering_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $catering_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
                // if menu category found
                if($menu_found==1){
                    $menu_order_id="";
                    $menu_i=0;
                    $input_data['main_categories_id']=3;
                    $grand_total=0;
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                        $grand_total=$grand_total+($cart_data->price*$cart_data->quantity);
                      }
                    }
                    $input_data['grand_total']=$grand_total;
                    $order = Order::create($input_data);
                    $menu_order_id = $order->id;
                    $cart_datas=Cart::where('session_id',$session_id)->get();
                    foreach ($cart_datas as $cart_data){
                      $getrootcategoryid = getrootcategoryid($cart_data->products_id);
                      if($getrootcategoryid==3){
                          $menu_data['items'][$menu_i]['name'] = $cart_data->product_name;
                          $menu_data['items'][$menu_i]['price'] = $cart_data->price;
                          $menu_data['items'][$menu_i]['desc'] = $cart_data->product_code;
                          $menu_data['items'][$menu_i]['qty'] = $cart_data->quantity;

                          $orderproduct = new Orderproduct;
                          $orderproduct->order_id = $menu_order_id;
                          $orderproduct->p_id = $cart_data->products_id;
                          $orderproduct->p_code = $cart_data->product_code;
                          $orderproduct->p_name = $cart_data->product_name;
                          $orderproduct->p_price = $cart_data->price;
                          $orderproduct->p_qty = $cart_data->quantity;
                          $orderproduct->save();

                          Cart::where('id', $cart_data->id)->delete();
                          $menu_i++;
                      }
                    }
                    $orderpayment = new Orderpayments;
                    $orderpayment->order_id = $menu_order_id;
                    $orderpayment->payment_type = "Paypal";
                    $orderpayment->payment_details = "";
                    $orderpayment->payment_amount = $grand_total;
                    $orderpayment->payment_date = date('Y-m-d H:i:s');
                    $orderpayment->save();
                }
              }
            }
        }

        $paypal_order_id="";
        $session_paypal_order_id=array();
        $sq=0;
        if($tiffin_found==1){ $paypal_order_id.= "#".$tiffin_order_id." "; $session_paypal_order_id[$sq]=$tiffin_order_id;$sq++; }
        if($catering_found==1){ $paypal_order_id.= "#".$catering_order_id." "; $session_paypal_order_id[$sq]=$catering_order_id;$sq++; }
        if($menu_found==1){ $paypal_order_id.= "#".$menu_order_id." "; $session_paypal_order_id[$sq]=$menu_order_id;$sq++; }
        Session::put('session_paypal_order_id',$session_paypal_order_id);
        $order_id=$paypal_order_id;

        $session_paypal_order_id=Session::get('session_paypal_order_id');
        for($q=0;$q<count($session_paypal_order_id);$q++){
          $order_update = Order::findOrFail($session_paypal_order_id[$q]);
          $order_update->deleted_at = date('Y-m-d');
          $order_update->save();
        }

        $provider = new ExpressCheckout;
        $data['invoice_id'] = $order_id;
        $data['invoice_description'] = "Confirmation {$data['invoice_id']} Invoice";
        $data['return_url'] = url('/paypal');
        $data['cancel_url'] = url('/viewcart');
        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }
        $data['total'] = $total;
        $data['shipping_discount'] = 0;
        $response = $provider->setExpressCheckout($data);
        return redirect($response['paypal_link']);
      }
    }


    public function cod(){
        // Mail Login
        $session_cod_order_id=Session::get('session_cod_order_id');
        $data['pagetitle']="Order Success";
        if(Auth::check()){
          $data['user_order']=Order::where('users_id',Auth::id())->orderBy('id', 'desc')->first();
        }else{
          $data['user_order']=Order::orderBy('id', 'desc')->first();
        }
        $data['session_cod_order_id']=$session_cod_order_id;
        return view('front.payment.cod')->with($data);
    }


    public function paypal(Request $request){

      $session_id=Session::get('session_id');
      Cart::where('session_id', $session_id)->forceDelete();
      $session_paypal_order_id=Session::get('session_paypal_order_id');
      for($q=0;$q<count($session_paypal_order_id);$q++){
          DB::connection()->getPdo()->exec('UPDATE orders SET deleted_at=NULL WHERE id="'.$session_paypal_order_id[$q].'"');
      }

      for($q=0;$q<count($session_paypal_order_id);$q++){
        $order_update = Order::findOrFail($session_paypal_order_id[$q]);
        $order_update->payer_id = $_GET['PayerID'];
        $order_update->token = $_GET['token'];
        $order_update->save();
      }

      $data['pagetitle']="Order Success";
      // Order Mail
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
      // User Mail
      for($q=0;$q<count($session_paypal_order_id);$q++){
        $f_order = Order::findOrFail($session_paypal_order_id[$q]);

        $tiffin_data=array();
        $fd_order = DB::table('orderproducts')->where('order_id',$f_order->id)->get();
        for($tiffin_i=0;$tiffin_i<count($fd_order);$tiffin_i++){
          $tiffin_data['items'][$tiffin_i]['name'] = $fd_order[$tiffin_i]->p_name;
          $tiffin_data['items'][$tiffin_i]['price'] = $fd_order[$tiffin_i]->p_price;
          $tiffin_data['items'][$tiffin_i]['desc'] = $fd_order[$tiffin_i]->p_code;
          $tiffin_data['items'][$tiffin_i]['qty'] = $fd_order[$tiffin_i]->p_qty;
        }
        // user mail
        $to_name = $f_order->name;
        $to_email = $f_order->users_email;
        $mail_data['username'] = $f_order->name;
        $mail_data['order_id'] = $f_order->id;
        $mail_data['order_data'] = $tiffin_data['items'];
        $mail_data['payment_method'] = $f_order->payment_method;
        $mail_data['customthemesetting'] = $customthemesetting;
        if($f_order->amount_received=="No"){
          $mail_data['payment_status'] = "50% Partial Paid";
        }else{
          $mail_data['payment_status'] = "Paid";
        }
        $subject = "Prasadam - Confirmation #".$f_order->id;
        Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
          $message->to($to_email, $to_name)->subject($subject);
        });
        //admin mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['username'] = "Admin";
        $mail_data['order_id'] = $f_order->id;
        $mail_data['customthemesetting'] = $customthemesetting;
        $mail_data['order_data'] = $tiffin_data['items'];
        $mail_data['payment_method'] = $f_order->payment_method;
        if($f_order->amount_received=="No"){
          $mail_data['payment_status'] = "50% Partial Paid";
        }else{
          $mail_data['payment_status'] = "Paid";
        }
        $subject = "Prasadam - Confirmation #".$f_order->id;
        Mail::send('admin.mail.orderpending', $mail_data, function($message) use ($to_name, $to_email, $subject) {
          $message->to($to_email, $to_name)->subject($subject);
          });

      }
      // Order Mail
      if(Auth::check()){
        $data['user_order']=Order::where('users_id',Auth::id())->orderBy('id', 'desc')->first();
      }else{
        $data['user_order']=Order::orderBy('id', 'desc')->first();
      }
      $data['session_paypal_order_id']=$session_paypal_order_id;
      return view('front.payment.paypal')->with($data);
    }
}
