<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    protected $baseUri;
    public function __construct()
    {
        $this->baseUri = 'http://localhost:8001/api/user';
    }

    public function getData()
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
    }
    
}
