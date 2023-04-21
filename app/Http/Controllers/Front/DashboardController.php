<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * UserRepository $user
     */
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $userId = auth()->user()->id;

        if($userId == null)  
            return redirect()->route('home');

        $user = $this->user->find($userId);

        if($user->guard == "client")
            return view('frontend.pages.employee.dashboard')->with('user', $user);

        if($user->guard == "business")
            return view('frontend.pages.employer.dashboard')->with('user', $user);
    }

    
}
