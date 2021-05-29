<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maincategory;
use App\Category;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class CategoryController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='Product Categories';
        $data['action']='Product Categories';
        $data['menu']='master';
        return view('admin.category.index')->with($data);
    }
    function getCategory()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $categories=Category::select('id','main_category_id','parent_id','seq','name','status','created_at')->get();
        $Category_data=array();
        $i=1;
        foreach($categories as $Category){
          $Category_data[$i]['sr_no']=$i;
          $Category_data[$i]['id']=$Category->id;
          $Category_data[$i]['name']=$Category->name;
          $Category_data[$i]['seq']=$Category->seq;
          $Category_data[$i]['main_category_id']=$Category->main_category->name;
          if($Category->parent_id==""){
            $Category_data[$i]['parent_id']="";
          }else{
            $Category_data[$i]['parent_id']=$Category->parent->name;
          }
          if($Category->status==1){
            $Category_data[$i]['status']="Enable";
          }else{
            $Category_data[$i]['status']="Disable";
          }
          $Category_data[$i]['created_at']=Carbon::parse($Category->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($Category_data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['webpage']='Product Categories';
      $data['action']='Product Categories -> Create Product Category';
      $data['menu']='master';
      $maincategory=Maincategory::where('status','1')->pluck('name','id')->all();
      $data['maincategory']=$maincategory;
      $parent_category=Category::where('status','1')->whereNull('parent_id')->pluck('name','id')->all();
      $data['parent_category']=$parent_category;

      return view('admin.category.create')->with($data);
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
          'main_category_id' => 'required',
          'name' => 'required',
          'status' => 'required',

      ]);
      $Category = new Category;
      $Category->name = $request->name;
      $Category->description = $request->description;
      $Category->main_category_id = $request->main_category_id;
      $Category->parent_id = $request->parent_id;
      $Category->seq = $request->seq;
      $Category->url = $request->url;
      $Category->status = $request->status;
      $Category->save();
      return redirect('category')->with('success','Information added successfully');

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
        $data['category']=Category::findOrFail($id);
        $data['webpage']='Product Categories';
        $data['menu']='master';
        $data['action']='Product Categories -> Edit Product Category';
        $maincategory=Maincategory::where('status','1')->pluck('name','id')->all();
        $data['maincategory']=$maincategory;
        $parent_category=Category::where('status','1')->whereNull('parent_id')->pluck('name','id')->all();
        $data['parent_category']=$parent_category;
        return view('admin.category.edit')->with($data);

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
            'main_category_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        $Category=Category::findOrFail($id);
        $Category->name = $request->name;
        $Category->description = $request->description;
        $Category->main_category_id = $request->main_category_id;
        $Category->parent_id = $request->parent_id;
        $Category->seq = $request->seq;
        $Category->url = $request->url;
        $Category->status = $request->status;
        $Category->save();
        return redirect('category')->with('success','Information changed successfully');

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
        $Category=Category::findOrFail($id)->delete();
        $error=0;
        return $error;
    }
}
