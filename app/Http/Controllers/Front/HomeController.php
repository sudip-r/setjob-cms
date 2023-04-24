<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\Page\PageRepository;
use App\AlterBase\Repositories\Job\JobRepository;
use App\AlterBase\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * JobRepository $job
     */
    private $job;

    /**
     * PageRepository $page
     */
    private $page;

    /**
     * UserRepository $user
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param PageRepository $page
     * @param JobRepository $job
     * @param UserRepository $user
     * @return void
     */
    public function __construct(
        PageRepository $page, 
        JobRepository $job,
        UserRepository $user)
    {
        $this->page = $page;
        $this->job = $job;
        $this->user = $user;
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

    /**
     * 
     */
    public function about(){

        $page = $this->page->find(1);

        return view('frontend.pages.about')->with('page', $page);
    }

    /**
     * 
     */
    public function terms(){

        $page = $this->page->find(2);

        return view('frontend.pages.terms')->with('page', $page);
    }

    /**
     * 
     */
    public function privacy(){

        $page = $this->page->find(3);

        return view('frontend.pages.policy')->with('page', $page);
    }

    /**
     * Employer detail
     * 
     * @param $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function employerDetail($slug)
    {
        $user = $this->user->findBy('slug', $slug);

        if($user == null)
            abort(404);

        $profile = $user->profile();

        if($profile == null)
            abort(500);

        return view('frontend.pages.employer')
            ->with('user', $user)
            ->with('profile', $profile);

    }

    /**
     * Employee detail
     * 
     * @param $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function employeeDetail($slug)
    {
        $user = $this->user->findBy('slug', $slug);

        if($user == null)
            abort(404);

        $profile = $user->profile();

        if($profile == null)
            abort(500);

        return view('frontend.pages.employee')
            ->with('user', $user)
            ->with('profile', $profile);

    }
}
