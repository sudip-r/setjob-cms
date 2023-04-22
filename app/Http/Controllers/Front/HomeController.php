<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\Page\PageRepository;
use App\AlterBase\Repositories\Job\JobRepository;
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
     * Create a new controller instance.
     *
     * @param PageRepository $page
     * @param JobRepository $job
     * @return void
     */
    public function __construct(PageRepository $page, JobRepository $job)
    {
        $this->page = $page;
        $this->job = $job;
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
        $jobs = $this->job->paginateWithMultipleCondition(['trash' => 0, 'publish' => 1], 'published_on', 'desc', 100, 
                ['id', 'title', 'summary', 'salary_min', 'salary_max', 'deadline', 'location', 'type', 'slug', 'published_on', 'publish']
        );

        return view('frontend.pages.jobs')->with('jobs', $jobs);
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
