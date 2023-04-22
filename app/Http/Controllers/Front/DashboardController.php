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
        if(auth()->user() == null)  
            return redirect()->route('home');

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        if($user->guard == "client")
            return view('frontend.pages.employee.dashboard')->with('user', $user);
        else
            return view('frontend.pages.employer.dashboard')->with('user', $user);
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        if(auth()->user() == null)  
            return redirect()->route('home');

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        if($user->guard == "client")
            return view('frontend.pages.employee.profile')->with('user', $user);
        else
            return view('frontend.pages.employer.profile')->with('user', $user);
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateProfile()
    {
        if(auth()->user() == null)  
            return redirect()->route('home');
            
        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        if($user->guard == "client")
            return view('frontend.pages.employee.update-profile')->with('user', $user);
        else
            return view('frontend.pages.employer.update-profile')->with('user', $user);
            
    }

    
}
