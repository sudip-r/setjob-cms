<?php

namespace App\Http\Controllers\alterCMS\Job;

use App\AlterBase\Models\Job\Job;
use App\AlterBase\Repositories\Category\CategoryRepository;
use App\AlterBase\Repositories\Job\JobRepository;
use App\AlterBase\Repositories\Media\MediaRepository;
use App\AlterBase\Repositories\User\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\AlterBase\Models\Meta\City;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

class JobController extends Controller
{
    /**
     * JobRepository $job
     */
    private $job;

    /**
     * MediaRepository $media
     */
    private $media;

    /**
     * CategoryRepository $category
     */
    private $category;

    /**
     * UserRepository $user
     */
    private $user;

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * JobController constructor.
     * @param JobRepository $job
     * @param MediaRepository $media
     * @param CategoryRepository $category
     * @param UserRepository $user
     * @param DatabaseManager $db
     * @param LoggerInterface $log
     */
    public function __construct(
        JobRepository $job,
        MediaRepository $media,
        CategoryRepository $category,
        UserRepository $user,
        DatabaseManager $db,
        LoggerInterface $log
    ) {
        $this->job = $job;
        $this->media = $media;
        $this->category = $category;
        $this->user = $user;
        $this->db = $db;
        $this->log = $log;
    }

    /**
     * Show all job
     *
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('view', Job::class);

        $currentPage = $request->page ?? 1;

        $jobs = $this->job->paginateWithMultipleCondition(['trash' => false], 'published_on', 'desc', 50,
            ['id', 'title', 'user_id', 'slug', 'type', 'category_id', 'publish', 'published_on', 'location'], $currentPage);

        $categories = $this->category->getBy('publish', 1, ['id', 'category', 'parent', 'publish']);

        return view('cms.job.index')
            ->with('jobs', $jobs)
            ->with('user', auth()->user())
            ->with('categories', $categories);
    }

    /**
     * Search job
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request)
    {
        $this->authorize('view', Job::class);
        $jobs = $this->job->searchJob(['trash' => false], $request->search_txt, "id", "desc", ['*'], 40);

        $categories = $this->category->getBy('publish', 1, ['id', 'category', 'parent', 'publish']);

        return view('cms.job.index')
            ->with('jobs', $jobs)
            ->with("searchTxt", $request->search_txt)
            ->with('user', auth()->user())
            ->with('categories', $categories);
    }

    /**
     * Show form to create new job
     *
     * @return View
     */
    public function create()
    {
        $this->authorize('create', Job::class);

        $categories = $this->category->getWithCondition(['publish' => 1, 'type' => 'Jobs'], 'category', 'asc')->pluck('category', 'id')->toArray();

        return view('cms.job.create')
            ->with('categories', $categories);
    }

    /**
     * Store newly created job
     *
     * @param JobRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(JobRequest $request)
    {
        $this->authorize('create', Job::class);

        try {
            $this->db->beginTransaction();

            $input = $request->only([
                'title', 
                'summary', 
                'description', 
                'user_id', 
                'responsibilities', 
                'required_skills', 
                'deadline', 
                'type', 
                'category_id', 
                'published_on', 
                'salary_min', 
                'salary_max', 
                'location',
                'salary_type'
            ]);

            $input['slug'] = strtolower(str_replace(" ", "-", $input['title'])) . "-" . date("his");

            $input['publish'] = 0;

            if (isset($request->publish)) {
                $input['publish'] = 1;
            }

            $input['location_text'] = $this->getCityById($input['location']);

            $job = $this->job->store($input);

            $this->db->commit();

            return redirect()->route('cms::jobs.index')
                ->with('success', "Job added successfully.");
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::jobs.create')
                ->with('error', "Failed to create job. " . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show form to edit job
     *
     * @param Job $job
     * @return View
     */
    public function edit(Job $job)
    {
        $this->authorize('update', Job::class);

        $categories = $this->category->getWithCondition(['publish' => 1, 'type' => 'Jobs'], 'category', 'asc')->pluck('category', 'id')->toArray();

        $user = $this->user->find($job->user_id);
        return view('cms.job.edit')
            ->with('job', $job)
            ->with('categories', $categories)
            ->with('user', $user);
    }

    /**
     * Update job detail
     *
     * @param ProductJobRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(JobRequest $request, $id)
    {
        $this->authorize('update', Job::class);

        $job = $this->job->find($id);
        try {
            $this->db->beginTransaction();

            $input = $request->only([
                'title', 
                'summary', 
                'description', 
                'user_id', 
                'responsibilities', 
                'required_skills', 
                'deadline', 
                'type', 
                'category_id', 
                'published_on', 
                'salary_min', 
                'salary_max', 
                'location',
                'salary_type'
            ]);

            $input['publish'] = 0;

            if (isset($request->publish)) {
                $input['publish'] = 1;
            }
            $input['location_text'] = $this->getCityById($input['location']);

            $this->job->update($id, $input);

            $this->db->commit();

            return redirect()->route('cms::jobs.index')
                ->with('success', 'Job updated successfully.');
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::jobs.edit', ['job' => $id])
                ->with('error', 'Filed to update job. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete given job
     *
     * @param Job $job
     * @return string
     */
    public function delete(Job $job)
    {
        $this->authorize('delete', Job::class);

        try {
            $this->db->beginTransaction();
            $this->job->update($job->id, ['trash' => 1]);

            $this->db->commit();
            return redirect()->route('cms::jobs.index')
                ->with('success', 'Job deleted successfully.');
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::jobs.index')
                ->with('error', 'Filed to delete job.')
                ->withInput();
        }
    }

    /**
     * Update job detail
     *
     * @param ProductJobRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusToggle(Job $job)
    {
        $this->authorize('status', Job::class);

        try {
            $this->db->beginTransaction();

            if ($job->publish) {
                $input['publish'] = 0;
            } else {
                $input['publish'] = 1;
            }

            $this->job->update($job->id, $input);
            $this->db->commit();

            if (auth()->user()->id != 1) {
                if ($input['published'] == 1) {
                    logger("Job " . $job->title . " published by " . auth()->user()->name);
                }

                if ($input['published'] == 0) {
                    logger("Job " . $job->title . " unpublished by " . auth()->user()->name);
                }

            }
            clearCache('On status update');

            return redirect()->route('cms::jobs.index')
                ->with('success', 'Job updated successfully.')
                ->with('latest', $job);

        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::jobs.edit', ['job' => $job->id])
                ->with('error', 'Filed to update job. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update job detail
     *
     * @param ProductJobRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function quickSave(Request $request, $id)
    {
        $this->authorize('update', Job::class);

        try {
            $this->db->beginTransaction();

            $input = $request->only([
                'title',
                'category',
                'published_on',
            ]);
            $input['author_id'] = $request->reporter;

            $userId = auth()->user()->id;
            if ($userId != 1) {
                $input['last_modified'] = $userId;
            }

            $input['tag_line'] = $this->registerTags($request->tag_line);
            $input['job_type'] = 'news';

            $this->job->update($request->id, $input);
            $this->db->commit();
            $job = $this->job->find($request->id);

            if (auth()->user()->id != 1) {
                logger("Job " . $input['title'] . " updated by " . auth()->user()->name);
            }

            if ($input['published_on'] > Carbon::now()) {
                $this->storeCacheClearDates($input['published_on']);
            }
            clearCache('On news update');

            return response(['category' => $job->category_info, 'author' => $job->author()->name], 200);
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return response('Something went wrong ' . $e->getMessage(), 500);

        }
    }

    /**
     * Get City name by ID
     * 
     * @param $location
     * @return String
     */
    private function getCityById($location)
    {
        $city = new City();

        return $city->find($location)->name;
    }
}
