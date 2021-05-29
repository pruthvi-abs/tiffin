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

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='UsersManagement';
        $data['action']='Users Management';
        $data['menu']='master';

        return view('admin.user.index')->with($data);
    }
    function getUsers()
    {
      $customthemesetting = customthemesetting();
      //$user_comp_id = Auth::user()->comp_id;
      $users=User::select('id','role_id','name','email','is_active','created_at')->whereIn('role_id',[1,2,3,4])->get();
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
        //
        $data['webpage']='UsersManagement';
        $data['action']='Users Management -> Create User';
        $data['menu']='master';
        $role=Role::where('id','!=',3)->pluck('name','id')->all();
        $data['role']=$role;
        $country=Country::pluck('country_name','country_name')->all();
        $data['country']=$country;
        return view('admin.user.create')->with($data);
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
        //
        //return $request;
        $this->validate($request, [
            'role_id' => 'required',
            'name' => 'required|max:191',
            'email' => 'required',
            'mobile' => 'required',
            'password' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'address' => 'required',
        ]);

        $user = new User;
        $user->role_id=$request->role_id;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->mobile=$request->mobile;
        if($file=$request->file('photo_id')){
          $userimage = time().$file->getClientOriginalName();
          $location='public/userimages/';
          $file->move($location,$userimage);
          $photo = Photo::create(['file'=>$userimage]);
          $photo_id = $photo->id;
          $user->photo_id = $photo_id;
        }
        $user->is_active=1;
        $user->password=bcrypt($request->password);
        $user->country=$request->country;
        $user->state=$request->state;
        $user->city=$request->city;
        $user->pincode=$request->pincode;
        $user->address=$request->address;
        $user->save();

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
        $to_name = $request->name;
        $to_email = $request->email;
        $mail_data['name'] = $request->name;
        $mail_data['password'] = $request->password;
        $mail_data['email'] = $request->email;
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.userregister', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - User Registered');
        });

        //Admin Mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['name'] = $request->name;
        //$mail_data['password'] = $request->password;
        $mail_data['email'] = $request->email;
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.adminuserregister', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - User Registered');
        });

        return redirect('users')->with('success','Information added successfully');
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
        $user = User::findOrFail($id);

        $data['user']=$user;
        //$role=Role::where('id',3)->pluck('name','id')->all();
        $role=Role::where('id','!=',5)->pluck('name','id')->all();
        $data['role']=$role;
        $country=Country::pluck('country_name','country_name')->all();
        $data['country']=$country;
        $data['webpage']='UsersManagement';
        $data['action']='Users Management -> Edit User';
        $data['menu']='';

        return view('admin.user.edit')->with($data);
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
        //return $request;
        $this->validate($request, [
            'role_id' => 'required',
            'name' => 'required|max:191',
            'mobile' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'address' => 'required',
            'is_active' => 'required',
        ]);

        $user = User::findOrFail($id);
        $input = $request->all();
        if($file=$request->file('photo_id')){
          $userimage = time().$file->getClientOriginalName();
          $location='public/userimages/';
          $file->move($location,$userimage);
          $photo = Photo::create(['file'=>$userimage]);
          $photo_id = $photo->id;
          $input['photo_id'] = $photo_id;
        }
        $user->update($input);

        return redirect('users')->with('success','Information changed successfully');
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

    public function ShowUserProfile(){
      $id=Auth::user()->id;
      $user = User::findOrFail($id);
      $country=Country::pluck('country_name','country_name')->all();
      $data['country']=$country;

      $data['user']=$user;
      $data['webpage']='Profile';
      $data['action']='Profile -> Edit Profile';
      $data['menu']='';

      return view('admin.user.showuserprofile')->with($data);
    }
    public function EditUserProfile(Request $request, $id){
      $this->validate($request, [
          'name' => 'required|max:191',
          'mobile' => 'required',
          'country' => 'required',
          'state' => 'required',
          'city' => 'required',
          'pincode' => 'required',
          'address' => 'required',
      ]);

      $user = User::findOrFail($id);
      $input = $request->all();
      if($file=$request->file('photo_id')){
        //if($user->photo!=""){
         // unlink(public_path()."/userimages/".$user->photo->file);
        //}
        $userimage = $id."_".time().$file->getClientOriginalName();
        $location='public/userimages/';
        $file->move($location,$userimage);
        $photo = Photo::create(['file'=>$userimage]);
        $photo_id = $photo->id;
        $input['photo_id'] = $photo_id;
      }
      $user->update($input);
      return redirect('showuserprofile')->with('success','Information changed successfully');
    }
}
