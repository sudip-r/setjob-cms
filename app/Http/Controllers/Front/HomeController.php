<?php

namespace App\Http\Controllers\Front;

use App\AlterBase\Repositories\Category\CategoryRepository;
use App\AlterBase\Repositories\Faq\FaqRepository;
use App\AlterBase\Repositories\Job\JobRepository;
use App\AlterBase\Repositories\Page\PageRepository;
use App\AlterBase\Repositories\Partner\PartnerRepository;
use App\AlterBase\Repositories\User\UserRepository;
use App\Http\Controllers\Controller;
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
     * CategoryRepository $category
     */
    private $category;

    /**
     * PartnerRepository $partner
     */
    private $partner;

    /**
     * FaqRepository $faq
     */
    private $faq;

    /**
     * Create a new controller instance.
     *
     * @param PageRepository $page
     * @param JobRepository $job
     * @param UserRepository $user
     * @param CategoryRepository $category
     * @param PartnerRepository $partner
     * @param FaqRepository $faq
     * @return void
     */
    public function __construct(
        PageRepository $page,
        JobRepository $job,
        UserRepository $user,
        CategoryRepository $category,
        PartnerRepository $partner,
        FaqRepository $faq) {
        $this->page = $page;
        $this->job = $job;
        $this->user = $user;
        $this->category = $category;
        $this->partner = $partner;
        $this->faq = $faq;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $partners = $this->partner->getWithCondition(
            ['publish' => 1],
            'sort_order',
            'asc',
            ['id', 'partner_link', 'image', 'partner_name']
        );
        return view('frontend.pages.home')->with('partners', $partners);
    }

    /**
     *
     */
    public function jobs(Request $request)
    {
        $min = $this->job->getWithCondition(['publish' => 1, 'trash' => 0], 'salary_min', 'asc', ["salary_min"])->first();
        $max = $this->job->getWithCondition(['publish' => 1, 'trash' => 0], 'salary_max', 'desc', ["salary_max"])->first();

        $search = "";

        if (isset($request->search)) {
            $search = $request->search;
        }

        $categories = $this->category->getWithCondition(['publish' => 1, 'type' => 'Jobs'], 'category', 'asc');

        return view('frontend.pages.jobs')
            ->with('min', $min->salary_min)
            ->with('max', $max->salary_max)
            ->with('search', $search)
            ->with('categories', $categories);
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
    public function about()
    {

        $page = $this->page->find(1);

        return view('frontend.pages.about')->with('page', $page);
    }

    /**
     *
     */
    public function terms()
    {

        $page = $this->page->find(2);

        return view('frontend.pages.terms')->with('page', $page);
    }

    /**
     *
     */
    public function privacy()
    {

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

        if ($user == null) {
            abort(404);
        }

        $profile = $user->profile();

        if ($profile == null) {
            abort(500);
        }

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

        if ($user == null) {
            abort(404);
        }

        $profile = $user->profile();

        if ($profile == null) {
            abort(500);
        }

        return view('frontend.pages.employee')
            ->with('user', $user)
            ->with('profile', $profile);

    }

    /**
     * Faq list page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function faqs()
    {
        $faqs = $this->faq->getWithCondition(
            ['publish' => 1],
            'sort_order',
            'asc',
            ['id', 'question', 'answer']);

        return view('frontend.pages.faq')
            ->with('faqs', $faqs);
    }
}
