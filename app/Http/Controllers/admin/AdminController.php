<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        $stats = [
            'total_orders'        => DB::table('orders')->count(),
            'total_customers'     => DB::table('customers')->count(),
            'total_products'      => DB::table('products')->count(),
            'total_tailor_orders' => DB::table('confirm_orders')->count(),
            'pending_orders'      => DB::table('orders')->where('order_status','Panding')->count(),
            'paid_orders'         => DB::table('orders')->where('payment_status','paid')->count(),
        ];

        $recent_orders = DB::table('orders')
            ->orderBy('id','desc')
            ->limit(6)
            ->get(['id','name','email','payment_status','order_status','added_on']);

        // Last 6 months chart data
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i));

        $ordersByMonth  = DB::table('orders')
            ->selectRaw('YEAR(added_on) y, MONTH(added_on) m, COUNT(*) c')
            ->where('added_on', '>=', now()->subMonths(6)->startOfMonth())
            ->groupByRaw('YEAR(added_on), MONTH(added_on)')
            ->get()->keyBy(fn($r) => $r->y.'-'.$r->m);

        $tailorByMonth  = DB::table('confirm_orders')
            ->selectRaw('YEAR(added_on) y, MONTH(added_on) m, COUNT(*) c')
            ->where('added_on', '>=', now()->subMonths(6)->startOfMonth())
            ->groupByRaw('YEAR(added_on), MONTH(added_on)')
            ->get()->keyBy(fn($r) => $r->y.'-'.$r->m);

        $chartLabels     = $months->map(fn($d) => $d->format('M Y'))->values();
        $chartOrders     = $months->map(fn($d) => optional($ordersByMonth->get($d->format('Y').'-'.(int)$d->format('n')))->c ?? 0)->values();
        $chartTailor     = $months->map(fn($d) => optional($tailorByMonth->get($d->format('Y').'-'.(int)$d->format('n')))->c ?? 0)->values();

        // Donut: payment status
        $paid    = DB::table('orders')->where('payment_status','paid')->count();
        $pending = DB::table('orders')->where('payment_status','!=','paid')->count();

        return view('admin/dashboard', compact(
            'stats','recent_orders',
            'chartLabels','chartOrders','chartTailor',
            'paid','pending'
        ));
    }

    public function statsApi(){
        return response()->json([
            'total_orders'        => DB::table('orders')->count(),
            'total_customers'     => DB::table('customers')->count(),
            'total_products'      => DB::table('products')->count(),
            'total_tailor_orders' => DB::table('confirm_orders')->count(),
            'pending_orders'      => DB::table('orders')->where('order_status','Panding')->count(),
            'paid_orders'         => DB::table('orders')->where('payment_status','paid')->count(),
        ]);
    }
 
    //   public function updatepassword(){
    //     $r=Admin::find(1);
    //     $r->password=Hash::make('admin');
    //     $r->save();  
    // }
}
