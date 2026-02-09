<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }
    


    
    public function login_user(Request $request)
    {
       
       
    
        $email  =  $request->get('useremail');

        $password = md5($request->get('password'));

        $active_user = DB::table('admin_user')->where('useremail', $email)->where('status',1)->get();



                
        if(!empty($active_user) && count($active_user) > 0){

                 if( $active_user[0]->password == $password ){

                    Session::put('admin_user_name', $active_user[0]->username);
                    Session::put('admin_user_email', $active_user[0]->useremail);
                    Session::put('admin_user_pass', $active_user[0]->password);

                    Session::flash('message','You are logged in successfullly !');
                    return  redirect('dashboard/');

                 }else{
                     Session::flash('message','Password Mismatch !');
                     return redirect('login');
                 }

        }
        else{
             Session::flash('message','Data does not exists!  !');
             return redirect('login');
        }

    }

   
    public function logout()
    {
          Session::flush();
          Session::forget('username');
          Session::forget('useremail');
          Session::forget('password');
          Session::flash('logout_msg'," You'r logout successfully! ");
          return redirect('login');
    }
}
