<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maincategory;
use App\Category;
use App\Product;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;
use Intervention\Image\Facades\Image;

class CateringproductController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='Catering Product';
        $data['action']='Catering Products';
        $data['menu']='master';
        return view('admin.cateringproduct.indexshow')->with($data);
    }
    function getCateringproduct()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $products=Product::select('id','image','small_image','p_code','p_name','categories_id','price','is_featured','is_visible','tiffin_preparation_date','created_at')->where('main_categories_id',2)->where('is_visible','yes')->orderByDesc('tiffin_preparation_date')->get();
        $Product_data=array();
        $i=1;
        foreach($products as $product){
          $Product_data[$i]['sr_no']=$i;
          $Product_data[$i]['id']=$product->id;

          $base_url = url('/');
          if($product->image==""){
            $pro_image = $base_url."/public/productplaceholder.png";
            $Product_data[$i]['image'] = $pro_image;
          }else{
              $Product_data[$i]['image']=$product->image;
          }
          if($product->small_image==""){
            $pro_image = $base_url."/public/productplaceholder.png";
            $Product_data[$i]['small_image'] = $pro_image;
          }else{
              $Product_data[$i]['small_image'] = $product->small_image;
          }

          $Product_data[$i]['p_name']=$product->p_name;
          $Product_data[$i]['p_code']=$product->p_code;
          $Product_data[$i]['categories_id']=$product->categories->name;
          $Product_data[$i]['price']=$customthemesetting->currency.$product->price;
          $Product_data[$i]['is_featured']=$product->is_featured;
          $Product_data[$i]['is_visible']=$product->is_visible;
          $Product_data[$i]['is_visibility']=$product->id.",".$product->is_visible;
          $Product_data[$i]['created_at']=Carbon::parse($product->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Product_data)->make(true);
    }

    public function cateringproductall()
    {
        //
        $data['webpage']='Catering Product';
        $data['action']='Catering Products';
        $data['menu']='master';
        return view('admin.cateringproduct.index')->with($data);
    }
    function getCateringproductall()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $products=Product::select('id','image','small_image','p_code','p_name','categories_id','price','is_featured','is_visible','tiffin_preparation_date','created_at')->where('main_categories_id',2)->orderByDesc('tiffin_preparation_date')->get();
        $Product_data=array();
        $i=1;
        foreach($products as $product){
          $Product_data[$i]['sr_no']=$i;
          $Product_data[$i]['id']=$product->id;

          $base_url = url('/');
          if($product->image==""){
            $pro_image = $base_url."/public/productplaceholder.png";
            $Product_data[$i]['image'] = $pro_image;
          }else{
              $Product_data[$i]['image']=$product->image;
          }
          if($product->small_image==""){
            $pro_image = $base_url."/public/productplaceholder.png";
            $Product_data[$i]['small_image'] = $pro_image;
          }else{
              $Product_data[$i]['small_image'] = $product->small_image;
          }

          $Product_data[$i]['p_name']=$product->p_name;
          $Product_data[$i]['p_code']=$product->p_code;
          $Product_data[$i]['categories_id']=$product->categories->name;
          $Product_data[$i]['price']=$customthemesetting->currency.$product->price;
          $Product_data[$i]['is_featured']=$product->is_featured;
          $Product_data[$i]['is_visible']=$product->is_visible;
          $Product_data[$i]['is_visibility']=$product->id.",".$product->is_visible;
          $Product_data[$i]['created_at']=Carbon::parse($product->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Product_data)->make(true);
    }

    public function cateringproducthide()
    {
        //
        $data['webpage']='Catering Product';
        $data['action']='Catering Products';
        $data['menu']='master';
        return view('admin.cateringproduct.indexhide')->with($data);
    }
    function getCateringproducthide()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $products=Product::select('id','image','small_image','p_code','p_name','categories_id','price','is_featured','is_visible','tiffin_preparation_date','created_at')->where('main_categories_id',2)->where('is_visible','no')->orderByDesc('tiffin_preparation_date')->get();
        $Product_data=array();
        $i=1;
        foreach($products as $product){
          $Product_data[$i]['sr_no']=$i;
          $Product_data[$i]['id']=$product->id;

          $base_url = url('/');
          if($product->image==""){
            $pro_image = $base_url."/public/productplaceholder.png";
            $Product_data[$i]['image'] = $pro_image;
          }else{
              $Product_data[$i]['image']=$product->image;
          }
          if($product->small_image==""){
            $pro_image = $base_url."/public/productplaceholder.png";
            $Product_data[$i]['small_image'] = $pro_image;
          }else{
              $Product_data[$i]['small_image'] = $product->small_image;
          }

          $Product_data[$i]['p_name']=$product->p_name;
          $Product_data[$i]['p_code']=$product->p_code;
          $Product_data[$i]['categories_id']=$product->categories->name;
          $Product_data[$i]['price']=$customthemesetting->currency.$product->price;
          $Product_data[$i]['is_featured']=$product->is_featured;
          $Product_data[$i]['is_visible']=$product->is_visible;
          $Product_data[$i]['is_visibility']=$product->id.",".$product->is_visible;
          $Product_data[$i]['created_at']=Carbon::parse($product->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Product_data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['webpage']='Catering Product';
      $data['action']='Catering Product -> Create Catering Product';
      $data['menu']='master';
      $category=Category::where('status','1')->where('main_category_id',2)->pluck('name','id')->all();
      $data['category']=$category;
      return view('admin.cateringproduct.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'categories_id' => 'required',
        'p_name' => 'required',
        'p_code' => 'required|unique:products',
        'description' => 'required',
        'price' => 'required',
      //  'is_featured' => 'required',
        'is_visible' => 'required',
      ]);
      $product = new Product;
      $product->p_name = $request->p_name;
      $product->p_code = $request->p_code;
      $product->description = $request->description;
      $product->categories_id = $request->categories_id;
      $product->price = $request->price;
    //  $product->is_featured = $request->is_featured;
      $product->is_visible = $request->is_visible;
      $product->main_categories_id = 2;

      if($file=$request->file('product_image')){
        $productimage = time().$file->getClientOriginalName();
        $location='public/products/';
        $file->move($location,$productimage);
        $copy_file_path = "/home/neoinventions/public_html/dailytiffin/public/products/".$productimage;
        $past_file_path = "/home/neoinventions/public_html/dailytiffin/public/products/small/".$productimage;
        copy($copy_file_path,$past_file_path);
        // crop image
        //$img_crop = Image::make(public_path('products/small/'.$productimage))->fit('500','500');
        $img_crop = Image::make(public_path('products/small/'.$productimage));
        $img_crop->resize(500,500);
        $img_crop->save($location."small/".$productimage);

        $product->image = $location.$productimage;
        $product->small_image = $location."small/".$productimage;
      }else{
        $product->image = "";
        $product->small_image = "";
      }
      $product->save();

      return redirect('cateringproduct')->with('success','Information added successfully');
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
        //
        $data['product']=Product::findOrFail($id);
        $data['webpage']='Tiffin Product';
        $data['menu']='master';
        $data['action']='Tiffin Product -> Edit Tiffin Product';
        $category=Category::where('status','1')->where('main_category_id',2)->pluck('name','id')->all();
        $data['category']=$category;
        return view('admin.cateringproduct.edit')->with($data);
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
      $in=Product::findOrFail($id);
      if($in->p_code==$request->p_code){

        $this->validate($request, [
          'categories_id' => 'required',
          'p_name' => 'required',
          'description' => 'required',
          'price' => 'required',
      //    'is_featured' => 'required',
          'is_visible' => 'required',
        ]);

        $product=Product::findOrFail($id);
        $product->p_name = $request->p_name;
        $product->description = $request->description;
        $product->categories_id = $request->categories_id;
        $product->price = $request->price;
    // w    $product->is_featured = $request->is_featured;
        $product->is_visible = $request->is_visible;
        $product->main_categories_id = 2;

        if($file=$request->file('product_image')){
          $productimage = time().$file->getClientOriginalName();
          $location='public/products/';
          $file->move($location,$productimage);
          $copy_file_path = "/home/neoinventions/public_html/dailytiffin/public/products/".$productimage;
          $past_file_path = "/home/neoinventions/public_html/dailytiffin/public/products/small/".$productimage;
          copy($copy_file_path,$past_file_path);
          // crop image
          $img_crop = Image::make(public_path('products/small/'.$productimage));
          $img_crop->resize(500,500);
          $img_crop->save($location."small/".$productimage);
          $product->image = $location.$productimage;
          $product->small_image = $location."small/".$productimage;
        }
        $product->save();

      }else{

        $this->validate($request, [
          'categories_id' => 'required',
          'p_name' => 'required',
          'p_code' => 'required|unique:products',
          'description' => 'required',
          'price' => 'required',
          'is_featured' => 'required',
          'is_visible' => 'required',
        ]);

        $product=Product::findOrFail($id);
        $product->p_name = $request->p_name;
        $product->p_code = $request->p_code;
        $product->description = $request->description;
        $product->categories_id = $request->categories_id;
        $product->price = $request->price;
        $product->is_featured = $request->is_featured;
        $product->is_visible = $request->is_visible;
        $product->main_categories_id = 2;

        if($file=$request->file('product_image')){
          $productimage = time().$file->getClientOriginalName();
          $location='public/products/';
          $file->move($location,$productimage);
          $copy_file_path = "/home/neoinventions/public_html/dailytiffin/public/products/".$productimage;
          $past_file_path = "/home/neoinventions/public_html/dailytiffin/public/products/small/".$productimage;
          copy($copy_file_path,$past_file_path);
          // crop image
          $img_crop = Image::make(public_path('products/small/'.$productimage));
          $img_crop->resize(500,500);
          $img_crop->save($location."small/".$productimage);
          $product->image = $location.$productimage;
          $product->small_image = $location."small/".$productimage;
        }
        $product->save();

      }


      return redirect('cateringproduct')->with('success','Information changed successfully');
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
        $product=Product::findOrFail($id)->delete();
        $error=0;
        return $error;

    }
    public function cateringvisibility(Request $request, $id)
    {
      if($request->product_visible=="no"){
        $Product_visibility = Product::findOrFail($request->product_id);
        $Product_visibility->is_visible = "yes";
        $Product_visibility->save();
      }else{
        $Product_visibility = Product::findOrFail($request->product_id);
        $Product_visibility->is_visible = "no";
        $Product_visibility->save();
      }
      $error=0;
      return $error;
      //return redirect('order')->with('success','Payment information added successfully');
    }
}
