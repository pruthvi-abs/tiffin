<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;

class CountryController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='Country';
        $data['action']='Country';
        $data['menu']='master';
        return view('admin.country.index')->with($data);
    }
    function getCountry()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $country=Country::select('id','country_code','country_name')->get();
        $country_data=array();
        $i=1;
        foreach($country as $countries){
          $country_data[$i]['sr_no']=$i;
          $country_data[$i]['id']=$countries->id;
          $country_data[$i]['country_code']=$countries->country_code;
          $country_data[$i]['country_name']=$countries->country_name;
          $country_data[$i]['created_at']=Carbon::parse($countries->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($country_data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['webpage']='Country';
      $data['action']='Country -> Create Country';
      $data['menu']='master';
      return view('admin.country.create')->with($data);
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
          'country_code' => 'required',
          'country_name' => 'required|max:100',
      ]);
      $Country = new Country;
      $Country->country_code = $request->country_code;
      $Country->country_name = $request->country_name;
      $Country->save();
      return redirect('country')->with('success','Information added successfully');

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
        $data['country']=Country::findOrFail($id);
        $data['webpage']='Country';
        $data['menu']='master';
        $data['action']='Country -> Edit Country';
        return view('admin.country.edit')->with($data);

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
          'country_code' => 'required',
          'country_name' => 'required|max:100',
        ]);
        $Country=Country::findOrFail($id);
        $Country->country_code = $request->country_code;
        $Country->country_name = $request->country_name;
        $Country->save();
        return redirect('country')->with('success','Information changed successfully');

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
        $country=Country::findOrFail($id)->delete();
        $error=0;
        return $error;
    }
}
