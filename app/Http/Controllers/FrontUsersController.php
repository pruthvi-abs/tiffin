<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Photo;
use App\Role;
use App\Country;
use App\Systemconfig;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

use Illuminate\Http\Request;

class FrontUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='FrontUsersManagement';
        $data['action']='Front Users List';
        $data['menu']='master';

        return view('admin.frontuser.index')->with($data);
    }
    function getFrontusers()
    {
      $customthemesetting = customthemesetting();
      //$user_comp_id = Auth::user()->comp_id;
      $users=User::select('id','role_id','name','email','is_active','created_at')->whereIn('role_id',[5])->get();
      $users_data=array();
      $i=1;
      foreach($users as $user){
        $users_data[$i]['sr_no']=$i;
        $users_data[$i]['role_id']=$user->role->name;
        $users_data[$i]['name']=$user->name;
        $users_data[$i]['email']=$user->email;
        $flag="";
        if($user->is_active==1){ $flag="Active"; }else{ $flag="In Active"; }
        $users_data[$i]['is_active']=$flag;
        $users_data[$i]['created_at']=Carbon::parse($user->created_at)->format($customthemesetting->datetime_format);
        $users_data[$i]['id']=$user->id;
        $i++;
      }
      return Datatables::of($users_data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
    }

}
