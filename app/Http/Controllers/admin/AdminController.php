<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        if($request->session()->has('admin_login')){
          
            return redirect('/admin/dashboard');
        }else{
        
         return view('/admin/login');
        }
        //  return view('admin/login');
    }

    public function auth(Request $request)
    {
       $email=$request->post('email');
       $password=$request->post('password');

     
      
    //    $result=Admin::where(['email'=>$email,'password'=>$password])->get();
    
    $result=Admin::where(['email'=>$email])->first();
    if($result){
        if(Hash::check($password,$result->password)){
            $request->session()->put('admin_login',true);
            $request->session()->put('admin_id',$result->id);
            $request->session()->put('admin_email',$result->email);
            return redirect('admin/dashboard');
        }else{
            $request->session()->flash('error','Enter Valid password');
             return redirect('/admin/login'); 
        }
      
    }else{
        $request->session()->flash('error','Enter correct details');
        return redirect('/admin/login');
    }
  
   
    }
  
    public function dashboard(){
        return view('admin/dashboard');
    }
 
    //   public function updatepassword(){
    //     $r=Admin::find(1);
    //     $r->password=Hash::make('admin');
    //     $r->save();  
    // }
}
