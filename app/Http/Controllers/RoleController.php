<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Systemconfig;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class RoleController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='Roles';
        $data['action']='Roles';
        $data['menu']='master';
        return view('admin.roles.index')->with($data);
    }
    function getRoles()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $roles=Role::select('id','name','created_at')->get();
        $role_data=array();
        $i=1;
        foreach($roles as $role){
          $role_data[$i]['sr_no']=$i;
          $role_data[$i]['id']=$role->id;
          $role_data[$i]['name']=$role->name;
          $role_data[$i]['created_at']=Carbon::parse($role->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($role_data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['webpage']='Roles';
      $data['action']='Roles -> Create Role';
      $data['menu']='master';
      return view('admin.roles.create')->with($data);
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
          'name' => 'required|max:191',
      ]);
      $Role = new Role;
      $Role->name = $request->name;
      $Role->user_id = $request->user_id;
      $Role->save();
      return redirect('roles')->with('success','Information added successfully');
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
        $data['role']=Role::findOrFail($id);
        $data['webpage']='Roles';
        $data['menu']='master';
        $data['action']='Roles -> Edit Role';
        return view('admin.roles.edit')->with($data);
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
            'name' => 'required|max:191',
        ]);
        $role=Role::findOrFail($id);
        $role->name = $request->name;
        $role->user_id = $request->user_id;
        $role->save();
        return redirect('roles')->with('success','Information changed successfully');
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
        //$role=Role::findOrFail($id)->delete();
        //return redirect('roles')->with(0,'Transaction Successful.');
        $role=Role::findOrFail($id)->delete();
        $error=0;
        return $error;
    }
}
