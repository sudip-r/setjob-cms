<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\Page\PageRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $page;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PageRepository $page)
    {
        $this->page = $page;
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
}
