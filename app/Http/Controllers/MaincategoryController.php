<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maincategory;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class MaincategoryController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='Main Categories';
        $data['action']='Main Categories';
        $data['menu']='master';
        return view('admin.maincategory.index')->with($data);
    }
    function getMaincategory()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $maincategories=Maincategory::select('id','name','description','status','created_at')->get();
        $maincategory_data=array();
        $i=1;
        foreach($maincategories as $maincategory){
          $maincategory_data[$i]['sr_no']=$i;
          $maincategory_data[$i]['id']=$maincategory->id;
          $maincategory_data[$i]['name']=$maincategory->name;
          $maincategory_data[$i]['description']=$maincategory->description;
          if($maincategory->status==1){
            $status = "Enable";
          }else{
            $status = "Disable";
          }
          $maincategory_data[$i]['status']=  $status;
          $maincategory_data[$i]['created_at']=Carbon::parse($maincategory->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($maincategory_data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['webpage']='Main Categories';
      $data['action']='Main Categories -> Create Main Category';
      $data['menu']='master';
      return view('admin.maincategory.create')->with($data);
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
          'name' => 'required',
          'status' => 'required',
      ]);
      $maincategory = new Maincategory;
      $maincategory->name = $request->name;
      $maincategory->description = $request->description;
      $maincategory->status = $request->status;
      $maincategory->save();
      return redirect('maincategory')->with('success','Information added successfully');

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
        $data['maincategory']=Maincategory::findOrFail($id);
        $data['webpage']='Main Categories';
        $data['menu']='master';
        $data['action']='Main Categories -> Edit Main Category';
        return view('admin.maincategory.edit')->with($data);

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
          'name' => 'required',
          'status' => 'required',
        ]);
        $maincategory=Maincategory::findOrFail($id);
        $maincategory->name = $request->name;
        $maincategory->description = $request->description;
        $maincategory->status = $request->status;
        $maincategory->save();
        return redirect('maincategory')->with('success','Information changed successfully');

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
        $maincategory=Maincategory::findOrFail($id)->delete();
        $error=0;
        return $error;
    }
}
