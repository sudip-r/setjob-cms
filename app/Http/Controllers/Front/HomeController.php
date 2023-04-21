<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.pages.home');
    }

    /**
     * 
     */
    public function jobs()
    {
        return view('frontend.pages.jobs');
    }

    /**
     * 
     */
    public function jobDetail()
    {
        return view('frontend.pages.job-detail');
    }
}
