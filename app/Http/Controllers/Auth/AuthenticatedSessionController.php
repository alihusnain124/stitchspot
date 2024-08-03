<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */

     protected $baseUri;
     public function __construct()
     {
         $this->baseUri = 'http://localhost:8001/api/user';
     }
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $response = Http::get($this->baseUri);
        if ($response->successful()) {
            $data = $response->json();
            foreach($data as $item){
            
                for($i=0; $i < count($item); $i++){

                 if(DB::table('users')->where('id', $item[$i]['id'])->exists()) {
                    
                 }else{
                    DB::table('users')->insert([
                        'id' => $item[$i]['id'],
                        'name' => $item[$i]['name'],
                        'email' => $item[$i]['email'],
                        'password' => $item[$i]['password'],
                        'created_at' => $item[$i]['created_at'],
                        'updated_at' => $item[$i]['updated_at'],
                    ]);

                 }
            
              
            }
        }

           
        } else {
            
            echo 'Error: ' . $response->status();
            die();
        }
        
        $request->authenticate();

        $request->session()->regenerate();

        


        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
