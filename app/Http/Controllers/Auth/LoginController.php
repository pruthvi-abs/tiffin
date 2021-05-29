<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use App\Socialprovider;
use Auth;
use Illuminate\Http\Request;
use Hash;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Config;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->middleware('guest', ['except' => ['logout','changePassword']]);
    }

    public function socialLogin($social){
      return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback($social){

      $customthemesetting = customthemesetting();
      // Mail Remaining
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

      $userSocial = Socialite::driver($social)->user();
      $Socialprovider = Socialprovider::where('provider_id',$userSocial->getId())->first();
      if(!$Socialprovider){
        //$username = explode("@",$userSocial->getEmail());
        $user = User::firstOrCreate([
          'name' => $userSocial->getName(),
          'email' => $userSocial->getEmail(),
          'role_id' => 5,
          'is_active' => 1
        ]);
        $Socialproviders = new Socialprovider;
        $Socialproviders->provider_id = $userSocial->getId();
        $Socialproviders->provider = $social;
        $Socialproviders->user_id = $user->id;
        $Socialproviders->save();

        // User Mail
        $to_name = $userSocial->getName();
        $to_email = $userSocial->getEmail();
        $mail_data['name'] = $userSocial->getName();
        $mail_data['password'] = "";
        $mail_data['email'] = $userSocial->getEmail();
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.userregister', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - User Registered with Social Account');
        });

        //Admin Mail
        $to_name = "Admin";
        $to_email = $customthemesetting->front_email;
        $mail_data['name'] = $userSocial->getName();
        //$mail_data['password'] = $request->password;
        $mail_data['email'] = $userSocial->getEmail();
        $mail_data['customthemesetting'] = $customthemesetting;
        Mail::send('admin.mail.adminuserregister', $mail_data, function($message) use ($to_name, $to_email) {
          $message->to($to_email, $to_name)->subject('Prasadam - User Registered with Social Account');
        });

        //$user->socialproviders()->create(['provider_id' => $userSocial->getId(), 'provider' => $social]);
        $email = $userSocial->getEmail();
      }else{
        $user = $Socialprovider->user;
        $userid = $Socialprovider->user_id;
        $userdata = User::select('email')->where('id',$userid)->first();
        $email = $userdata->email;
      }

      //if(Auth::attempt(['email'=>$email,'password'=>NULL])){
        auth()->login($user);
        Session::put('frontSession',$email);
        return redirect('/');
      //}else{
      //  return redirect('/userlogin')->with('message','Account is not Valid!');
      //}
    }

    /* Admin Side */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function changePassword(Request $request){
      $customthemesetting = customthemesetting();
        if($request->ajax()){
            $currentPassword=$request->input('currentpassword');
            //return $currentPassword;die;
            $userid=Auth::user()->id;
            $check=User::select('password')
                      ->where('id',$userid)
                      ->first();
            if (Hash::check($currentPassword, $check['password']))
            {
               $admin=User::find($userid);
               $admin->password=bcrypt($request->input('newpassword'));
               $admin->save();
               $message='Your Password has been updated.';
               $error=1;
               $passwordmatch='';

               /* Mail Start */
               $to_name = Auth::user()->name;
               $to_email = Auth::user()->email;
               $mail_data['name'] = Auth::user()->name;
               $mail_data['customthemesetting'] = $customthemesetting;
               Mail::send('admin.mail.changepassword', $mail_data, function($message) use ($to_name, $to_email) {
                 $message->to($to_email, $to_name)->subject('Changed Password');
               });
               /* Mail End */
            }else{
                $message='Password update failed.';
                $error=0;
                $passwordmatch='You have entered wrong current password.';
            }
            return response()->json(array('message'=> $message,'error'=>$error,'passwordmatch'=>$passwordmatch), 200);
        }
    }

    public function redirectPath()
    {
        /*
        echo "---".Auth::user()->role_id;
        echo "---".Auth::user()->email;
        die;
        */
        if(Auth::check()){
          //return Auth::user()->is_active;die;
          if(Auth::user()->is_active==1){
            if(Auth::user()->role_id==1){
               Session::put('frontSession',Auth::user()->email);
                return "/dashboard";
            }else if(Auth::user()->role_id==2){
                Session::put('frontSession',Auth::user()->email);
                return "/salesdashboard";
            }else if(Auth::user()->role_id==3){
                Session::put('frontSession',Auth::user()->email);
                return "/kitchendashboard";
            }else if(Auth::user()->role_id==4){
                Session::put('frontSession',Auth::user()->email);
                return "/counterdashboard";
            }else if(Auth::user()->role_id==5){
              Auth::logout();
              //return redirect('/')->with('message','You have to no access of login page.');
              Session::flash('message', 'You have to no access of login page. Please contact to Administrator.');
            }else{
                Auth::logout();
                Session::flash('notify', 'You have to no access of login page. Please contact to Administrator.');
                //return redirect('/login');
            }
          }else{
            Auth::logout();
            Session::flash('notify', 'You are diactive in the system. Please contact to Administrator.');
            //return redirect('/login');
          }
        }else{
            return redirect('/login');
        }
    }

    public function logout(Request $request) {
    Auth::logout();
    return redirect('/login');
    }

}
