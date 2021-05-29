<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Order;
use App\Orderproduct;
use App\Orderpayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;

class CartController extends Controller
{
    public function index(){
      //if(Auth::check()){
      $data['pagetitle']="Cart";
      //$inputToCart['user_email']= Auth::user()->email;
      $session_id=Session::get('session_id');

      if(isset($_GET['token'])){
        $session_paypal_order_id=Session::get('session_paypal_order_id');
        //print_r($session_paypal_order_id);
        //Cart::where('session_idd',$session_id)->update(array('deleted_at' => "NULL"));
        DB::statement("UPDATE carts SET deleted_at = NULL where session_id = '".$session_id."'");
        for($q=0;$q<count($session_paypal_order_id);$q++){
          Order::where('id', $session_paypal_order_id[$q])->forceDelete();
          Orderproduct::where('order_id', $session_paypal_order_id[$q])->forceDelete();
          Orderpayments::where('order_id', $session_paypal_order_id[$q])->forceDelete();
        }
      }


        //$cart_datas=Cart::where('session_id',$session_id)->where('user_email', $inputToCart['user_email'])->get();
        $cart_datas=Cart::where('session_id',$session_id)->get();
        $total_price=0;
        foreach ($cart_datas as $cart_data){
            $total_price+=$cart_data->price*$cart_data->quantity;
        }
        $data['cart_datas']=$cart_datas;
        $data['total_price']=$total_price;
        return view('front.cart.index')->with($data);
      //}else{
      //  return redirect('/');
      //}
    }

    public function addToCartajax(Request $request){
        $inputToCart=$request->all();
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $session_id=Session::get('session_id');
        if(empty($session_id)){
            $session_id=str_random(40);
            Session::put('session_id',$session_id);
        }
        $inputToCart['session_id']=$session_id;
        //$count_duplicateItems=Cart::where(['products_id'=>$inputToCart['products_id'], 'user_email'=>$inputToCart['user_email'], 'session_id'=>$inputToCart['session_id']])->count();
        $count_duplicateItems=Cart::where(['products_id'=>$inputToCart['products_id'], 'session_id'=>$inputToCart['session_id']])->count();
        if($count_duplicateItems>0){
            $product_data  = Product::select('*')->where('id',$inputToCart['products_id'])->first();
            if($product_data->main_categories_id!=2){
              $count_duplicateItems_data=Cart::where(['products_id'=>$inputToCart['products_id'], 'session_id'=>$inputToCart['session_id']])->first();
              $Cart=Cart::findOrFail($count_duplicateItems_data->id);
              $Cart->quantity =  $count_duplicateItems_data->quantity+$inputToCart['quantity'];
              $Cart->save();

              $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
              $tot_price=0;
              $tot_product=0;
              foreach ($cart_datas as $cart_data){
                  $tot_price+=$cart_data->price*$cart_data->quantity;
                  $tot_product++;
              }
              $data = array();
              $data['success']="Added!";
              $data['products_id']=$inputToCart['products_id'];
              $data['error']="";
              $data['totalcart']=$tot_product;
              return json_encode($data);
              //return back()->with('message','Add To Cart Successfully');
            }else{

              $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
              $tot_price=0;
              $tot_product=0;
              foreach ($cart_datas as $cart_data){
                  $tot_price+=$cart_data->price*$cart_data->quantity;
                  $tot_product++;
              }

              $data = array();
              $data['success']="Already Added!";
              $data['products_id']=$inputToCart['products_id'];
              $data['error']="";
              $data['totalcart']=$tot_product;
              return json_encode($data);
              //return back()->with('message','Catering product already added in your cart');
            }
        }else{
            Cart::create($inputToCart);

            $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
            $tot_price=0;
            $tot_product=0;
            foreach ($cart_datas as $cart_data){
                $tot_price+=$cart_data->price*$cart_data->quantity;
                $tot_product++;
            }

            $data = array();
            $data['success']="Added!";
            $data['products_id']=$inputToCart['products_id'];
            $data['error']="";
            $data['totalcart']=$tot_product;
            return json_encode($data);
            //return back()->with('message','Add To Cart Successfully');
        }
    }

    public function addToCateringajax(Request $request){
        $inputToCart=$request->all();
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $session_id=Session::get('session_id');
        $customthemesetting = customthemesetting();
        if(empty($session_id)){
            $session_id=str_random(40);
            Session::put('session_id',$session_id);
        }
        $inputToCart['session_id']=$session_id;
        //$count_duplicateItems=Cart::where(['products_id'=>$inputToCart['products_id'], 'user_email'=>$inputToCart['user_email'], 'session_id'=>$inputToCart['session_id']])->count();
        $count_duplicateItems=Cart::where(['products_id'=>$inputToCart['products_id'], 'session_id'=>$inputToCart['session_id']])->count();
        if($count_duplicateItems>0){
            $product_data  = Product::select('*')->where('id',$inputToCart['products_id'])->first();
            if($product_data->main_categories_id!=2){
              $count_duplicateItems_data=Cart::where(['products_id'=>$inputToCart['products_id'], 'session_id'=>$inputToCart['session_id']])->first();
              $Cart=Cart::findOrFail($count_duplicateItems_data->id);
              $Cart->quantity =  $count_duplicateItems_data->quantity+$inputToCart['quantity'];
              $Cart->save();

              $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
              $tot_price=0;
              $tot_product=0;
              foreach ($cart_datas as $cart_data){
                  $tot_price+=$cart_data->price*$cart_data->quantity;
                  $tot_product++;
              }
              $cat_data="<ul>";
              $catering_total=0;
              foreach($cart_datas as $cart_data){
                  $check_product_catid = DB::select('select main_categories_id from products where deleted_at is null and is_visible="yes" and id='.$cart_data->products_id.' order by id desc');
                  if($check_product_catid[0]->main_categories_id==2){
                    $catering_total = $catering_total + (1 * $cart_data->price);
                    $cat_data.="<li><a class='cart_quantity_delete' data-id='".$cart_data->id."' href='#'>".$cart_data->product_name." &nbsp;&nbsp;<i class='ti ti-close'></i></a></li>";
                  }
              }
              $cat_data.="</ul>";
              if($catering_total!=0) {
                $cat_data.='<div class="text-center"><strong>'.$customthemesetting->currency.$catering_total.'</strong></div>';
                $ur = url('/viewcart');
                $cat_data.='<div class="text-center"><a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="'.$ur.'"><span>Go to Cart</span></a></div>';
              }
              //$cat_data.="<script>$('.cart_quantity_delete').click(function(){alert('call');$('.cart_quantity_delete').trigger('click');});</script>";
              $data = array();
              $data['success']="Added!";
              $data['products_id']=$inputToCart['products_id'];
              $data['error']="";
              $data['totalcart']=$tot_product;
              $data['cat_data']=$cat_data;
              return json_encode($data);
              //return back()->with('message','Add To Cart Successfully');
            }else{

              $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
              $tot_price=0;
              $tot_product=0;
              foreach ($cart_datas as $cart_data){
                  $tot_price+=$cart_data->price*$cart_data->quantity;
                  $tot_product++;
              }
              $cat_data="<ul>";
              $catering_total=0;
              foreach($cart_datas as $cart_data){
                  $check_product_catid = DB::select('select main_categories_id from products where deleted_at is null and is_visible="yes" and id='.$cart_data->products_id.' order by id desc');
                  if($check_product_catid[0]->main_categories_id==2){
                    $catering_total = $catering_total + (1 * $cart_data->price);
                    $cat_data.="<li><a class='cart_quantity_delete' data-id='".$cart_data->id."' href='#'>".$cart_data->product_name." &nbsp;&nbsp;<i class='ti ti-close'></i></a></li>";
                  }
              }
              $cat_data.="</ul>";
              if($catering_total!=0) {
                $cat_data.='<div class="text-center"><strong>'.$customthemesetting->currency.$catering_total.'</strong></div>';
                $ur = url('/viewcart');
                $cat_data.='<div class="text-center"><a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="'.$ur.'"><span>Go to Cart</span></a></div>';
              }
              //$cat_data.="<script>$('.cart_quantity_delete').click(function(){alert('call');$('.cart_quantity_delete').trigger('click');});</script>";
              $data = array();
              $data['success']="Already Added!";
              $data['products_id']=$inputToCart['products_id'];
              $data['error']="";
              $data['totalcart']=$tot_product;
              $data['cat_data']=$cat_data;
              return json_encode($data);
              //return back()->with('message','Catering product already added in your cart');
            }
        }else{
            Cart::create($inputToCart);

            $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
            $tot_price=0;
            $tot_product=0;
            foreach ($cart_datas as $cart_data){
                $tot_price+=$cart_data->price*$cart_data->quantity;
                $tot_product++;
            }
            $cat_data="<ul>";
            $catering_total=0;
            foreach($cart_datas as $cart_data){
                $check_product_catid = DB::select('select main_categories_id from products where deleted_at is null and is_visible="yes" and id='.$cart_data->products_id.' order by id desc');
                if($check_product_catid[0]->main_categories_id==2){
                  $catering_total = $catering_total + (1 * $cart_data->price);
                  $cat_data.="<li><a class='cart_quantity_delete' data-id='".$cart_data->id."' href='#'>".$cart_data->product_name." &nbsp;&nbsp;<i class='ti ti-close'></i></a></li>";
                }
            }
            $cat_data.="</ul>";
            if($catering_total!=0) {
              $cat_data.='<div class="text-center"><strong>'.$customthemesetting->currency.$catering_total.'</strong></div>';
              $ur = url('/viewcart');
              $cat_data.='<div class="text-center"><a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="'.$ur.'"><span>Go to Cart</span></a></div>';
            }
            //$cat_data.="<script>$('.cart_quantity_delete').click(function(){alert('call');$('.cart_quantity_delete').trigger('click');});</script>";
            $data = array();
            $data['success']="Added!";
            $data['products_id']=$inputToCart['products_id'];
            $data['error']="";
            $data['totalcart']=$tot_product;
            $data['cat_data']=$cat_data;
            return json_encode($data);
            //return back()->with('message','Add To Cart Successfully');
        }
    }

    public function addToCart(Request $request){
      //if(Auth::check()){
        $inputToCart=$request->all();
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');

        //$inputToCart['user_email']= Auth::user()->email;
        $session_id=Session::get('session_id');
        if(empty($session_id)){
            $session_id=str_random(40);
            Session::put('session_id',$session_id);
        }
        $inputToCart['session_id']=$session_id;
        //$count_duplicateItems=Cart::where(['products_id'=>$inputToCart['products_id'], 'user_email'=>$inputToCart['user_email'], 'session_id'=>$inputToCart['session_id']])->count();
        $count_duplicateItems=Cart::where(['products_id'=>$inputToCart['products_id'], 'session_id'=>$inputToCart['session_id']])->count();
        if($count_duplicateItems>0){
            $product_data  = Product::select('*')->where('id',$inputToCart['products_id'])->first();
            if($product_data->main_categories_id!=2){
              $count_duplicateItems_data=Cart::where(['products_id'=>$inputToCart['products_id'], 'session_id'=>$inputToCart['session_id']])->first();
              $Cart=Cart::findOrFail($count_duplicateItems_data->id);
              $Cart->quantity =  $count_duplicateItems_data->quantity+$inputToCart['quantity'];
              $Cart->save();
              //return back()->with('message','Add To Cart Successfully');
              return redirect('letseat')->with('message','Add To Cart Successfully');
            }else{
              //return back()->with('message','Catering product already added in your cart');
              return redirect('letseat')->with('message','Catering product already added in your cart');
            }
        }else{
            Cart::create($inputToCart);
            //return back()->with('message','Add To Cart Successfully');
            return redirect('letseat')->with('message','Add To Cart Successfully');
        }
      //}else{
      //  return back()->with('message','You need to login first');
      //}
    }

    public function updateQuantity($id,$quantity){
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $current_cart=DB::table('carts')->select('quantity')->where('id',$id)->first();
        $updated_quantity=$current_cart->quantity+$quantity;
        DB::table('carts')->where('id',$id)->increment('quantity',$quantity);
        return back()->with('message','Quantity Updated Successfully');
    }

    public function updateQuantityajax($id,$quantity){
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $session_id=Session::get('session_id');
        $current_cart=DB::table('carts')->select('quantity','price')->where('id',$id)->first();
        $updated_quantity=$current_cart->quantity+$quantity;
        DB::table('carts')->where('id',$id)->increment('quantity',$quantity);

        $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
        $tot_price=0;
        foreach ($cart_datas as $cart_data){
            $tot_price+=$cart_data->price*$cart_data->quantity;
        }
        $customthemesetting = customthemesetting();

        $data = array();
        $data['success']="Updated!";
        $data['error']="";
        $data['updated_quantity']=$updated_quantity;
        $data['cart_id']=$id;
        $data['updated_id_total']=$customthemesetting->currency.$updated_quantity*$current_cart->price;
        $data['updated_total']=$customthemesetting->currency.$tot_price;
        return json_encode($data);
    }

    public function deleteItem($id=null){
        $delete_item=Cart::findOrFail($id);
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $delete_item->forceDelete();
        return back()->with('message','Item Removed Successfully');
    }

    public function deleteItemajax($id=null){
      Session::forget('discount_amount_price');
      Session::forget('coupon_code');
      $session_id=Session::get('session_id');
      $customthemesetting = customthemesetting();
        $delete_item=Cart::findOrFail($id);
        $p_id = $delete_item->products_id;
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $delete_item->forceDelete();

        $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
        $tot_price=0;
        $tot_product=0;
        foreach ($cart_datas as $cart_data){
            $tot_price+=$cart_data->price*$cart_data->quantity;
            $tot_product++;
        }
        $cat_data="<ul>";
        $catering_total=0;
        foreach($cart_datas as $cart_data){
            $check_product_catid = DB::select('select main_categories_id from products where deleted_at is null and is_visible="yes" and id='.$cart_data->products_id.' order by id desc');
            if($check_product_catid[0]->main_categories_id==2){
              $catering_total = $catering_total + (1 * $cart_data->price);
              $cat_data.="<li><a class='cart_quantity_delete' data-id='".$cart_data->id."' href='#'>".$cart_data->product_name." &nbsp;&nbsp;<i class='ti ti-close'></i></a></li>";
            }
        }
        $cat_data.="</ul>";
        if($catering_total!=0) {
          $cat_data.='<div class="text-center"><strong>'.$customthemesetting->currency.$catering_total.'</strong></div>';
          $ur = url('/viewcart');
          $cat_data.='<div class="text-center"><a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="'.$ur.'"><span>Go to Cart</span></a></div>';
        }
        //$cat_data.="<script>$('.cart_quantity_delete').click(function(){alert('call');$('.cart_quantity_delete').trigger('click');});</script>";

        $data = array();
        $data['success']="Removed!";
        $data['products_id']=$p_id;
        $data['error']="";
        $data['totalcart']=$tot_product;
        $data['cat_data']=$cat_data;
        return json_encode($data);
    }


    public function applycateringqty(Request $request){
       $this->validate($request,[
           'cateringqty'=>'required'
       ]);
       $input_data=$request->all();
       $cateringqty=$input_data['cateringqty'];
       $session_id=Session::get('session_id');
       if($cateringqty<10){
         return back()->with('message_catering_qty_error','Please select minimum quantity 10 for catering product.');
       }else{
         //DB::table('carts')->where('session_id', $session_id)->update(['quantity' => $cateringqty]);
         $curr_cart_data  = Cart::where('session_id', $session_id)->get();
         $count_cart_data  = Cart::where('session_id', $session_id)->count();
         for($i=0;$i<$count_cart_data;$i++){
           $find_root_cat = Product::where('id',$curr_cart_data[$i]->products_id)->first();
           if($find_root_cat->main_categories_id==2){
             DB::table('carts')->where('session_id', $session_id)->where('products_id',$curr_cart_data[$i]->products_id)->update(['quantity' => $cateringqty]);
           }
         }
         return back()->with('message_catering_qty_succ','Quantity was applied on all catering product.');
       }
   }

}
