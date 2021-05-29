<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Contracts\Auditable;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class AuditController extends Controller{

  use \OwenIt\Auditing\Auditable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='Audit';
        $data['action']='Audit';
        $data['menu']='master';
        return view('admin.audit.index')->with($data);
    }
    function getAudit()
    {
      $customthemesetting = customthemesetting();
        $audit = DB::table('audits')->select('id','user_type','auditable_type','auditable_id','old_values','new_values','url','ip_address','user_id','event','ip_address','created_at')->orderByDesc('id')->get();
        $audit_data=array();
        $i=1;
        foreach($audit as $audits){
          $audit_data[$i]['sr_no']=$i;
          $audit_data[$i]['id']=$audits->id;
          $audit_data[$i]['user_type']=$audits->user_type;
          $audit_data[$i]['auditable_type']=$audits->auditable_type;
          $audit_data[$i]['auditable_id']=$audits->auditable_id;
          $old_data = json_decode($audits->old_values);
          $audit_data[$i]['old_values']=$old_data;
          $new_data = json_decode($audits->new_values);
          $audit_data[$i]['new_values']=$new_data;
          $audit_data[$i]['event']=$audits->event;
          $audit_data[$i]['url']=$audits->url;
          $audit_data[$i]['ip_address']=$audits->ip_address;
          $audit_data[$i]['created_at']=Carbon::parse($audits->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($audit_data)->make(true);
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
        //

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
