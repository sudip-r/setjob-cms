<?php

namespace App\Http\Controllers\alterCMS;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * UserRepository $user
     */
    private $user;
    /**
     * 
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Show CMS dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(auth()->user() == null)
            return redirect()->route('home');

        $user = $this->user->find(auth()->user()->id);

        if($user->guard != "web")
            return redirect()->route('home');

        return view('cms.dashboard');
    }
}
