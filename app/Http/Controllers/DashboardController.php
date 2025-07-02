<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if(Auth::user()->role == 1 || Auth::user()->role == 0 ){
            return view('admin.dashboard');
        }else if(Auth::user()->role == 2){
            return view('pengguna.dashboard');
        }
    }
}
