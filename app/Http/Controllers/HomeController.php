<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use App\Quote;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotes = Quote::all();
        return view('dashboard', ['quotes' => $quotes]);
    }

    public function liked()
    {
        $quotes = Auth::user()->quotes;
        return view('dashboard', ['quotes' => $quotes]);
    }


    public function like($quote_id){
        Auth::user()->quotes()->attach($quote_id);
        return redirect()->route('dashboard');
    }

    public function unlike($quote_id){
        Auth::user()->quotes()->detach($quote_id);
        return redirect()->route('dashboard');
    }
}
