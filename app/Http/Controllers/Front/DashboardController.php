<?php

namespace App\Http\Controllers\Front;

use App\AlterBase\Repositories\User\ProfileRepository;
use App\AlterBase\Repositories\User\UserRepository;
use App\AlterBase\Repositories\Job\JobRepository;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

class DashboardController extends Controller
{

    /**
     * UserRepository $user
     */
    private $user;

    /**
     * ProfileRepository $profile
     */
    private $profile;

    /**
     * JobRepository $job
     */
    private $job;

    /**
     * LoggerInterface $log
     */
    private $log;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepository $user,
        ProfileRepository $profile,
        JobRepository $job,
        LoggerInterface $log) {
        $this->user = $user;
        $this->profile = $profile;
        $this->job = $job;
        $this->log = $log;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        if (auth()->user() == null) {
            return redirect()->route('home');
        }

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        $jobs = $this->job->paginateWithMultipleCondition(
            ['user_id' => $userId],
            'published_on',
            'desc',
            10,
            ['id', 'title', 'summary', 'salary_min', 'salary_max', 'deadline', 'location', 'type', 'slug', 'published_on']
        );

        if ($user->guard == "client") {
            return view('frontend.pages.employee.dashboard')->with('user', $user);
        } else {
            return view('frontend.pages.employer.dashboard')->with('user', $user)->with('jobs', $jobs);
        }
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        if (auth()->user() == null) {
            return redirect()->route('home');
        }

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        if ($user->guard == "client") {
            return view('frontend.pages.employee.profile')->with('user', $user);
        } else {
            return view('frontend.pages.employer.profile')->with('user', $user);
        }

    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateProfile()
    {
        if (auth()->user() == null) {
            return redirect()->route('home');
        }

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        if ($user->guard == "client") {
            return view('frontend.pages.employee.update-profile')->with('user', $user);
        } else {
            return view('frontend.pages.employer.update-profile')->with('user', $user);
        }

    }

    /**
     * Update employer profile
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function employerUpdateProfile(Request $request)
    {
        try {
            $input = $request->only([
                'name', 'email'
            ]);

            $id = $request->id;

            $user = $this->user->find($id);

            if ($request->hasFile('profile_image')) {
                $input['profile_image'] = $this->uploadImage($request);

                $this->deleteOldProfileImage($user->profile_image);
            }

            $this->user->update($id, $input);

            $profileInput = $request->only([
                'address', 'contact', 'city_id', 'postal_code', 'linkedin', 'twitter', 'facebook', 'instagram', 'summary', 'description'
            ]);

            $this->profile->updateWith('user_id', $id, $profileInput);

            return redirect()->route('user.profile')
                ->with('success', "Profile updated");
        } catch (\Exception $e) {
            $this->log->error((string) $e);

            return redirect()->route('user.profile')
                ->with('error', "Failed to update.")
                ->withInput();
        }
    }

    /**
     * 
     */
    public function jobs()
    {
        if (auth()->user() == null) {
            return redirect()->route('home');
        }

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        $jobs = $this->job->paginateWithMultipleCondition(
            ['user_id' => $userId],
            'published_on',
            'desc',
            40,
            ['id', 'title', 'summary', 'salary_min', 'salary_max', 'deadline', 'location', 'type', 'slug', 'published_on', 'publish']
        );

        if ($user->guard == "client") {
            return view('frontend.pages.employee.jobs')->with('user', $user);
        } else {
            return view('frontend.pages.employer.jobs.jobs')->with('user', $user)->with('jobs', $jobs);
        }
    }

    /**
     * 
     */
    public function createJobs()
    {
        if (auth()->user() == null) {
            return redirect()->route('home');
        }

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        if ($user->guard == "client") {
            return view('frontend.pages.employee.jobs')->with('user', $user);
        } else {
            return view('frontend.pages.employer.jobs.create')->with('user', $user);
        }
    }

    /**
     * 
     */
    public function storeJob(Request $request)
    {
        try {
            $input = $request->only([
                'title',
                'summary',
                'description',
                'salary_min',
                'salary_max',
                'deadline',
                'location',
                'responsibilities',
                'required_skills',
                'type'
            ]);

            $user = $this->user->find($request->id);

            $input['slug'] = str_replace(" ", "-", strtolower($request->title))."-".time();
            if($request->location == "0")
            {
               $input['location'] = $user->profile()->city_id;
            }
            $input['publish'] = 1;
            $input['user_id'] = $request->id;

            $this->job->store($input);

            return redirect()->route('dashboard.jobs')
                ->with('success', "Job created");
        } catch (\Exception $e) {
            $this->log->error((string) $e);

            return redirect()->route('dashboard.jobs')
                ->with('error', "Failed to create.")
                ->withInput();
        }
    }

    /**
     * 
     */
    public function editJobs($id)
    {
        if (auth()->user() == null) {
            return redirect()->route('home');
        }

        $job = $this->job->find($id);

        $userId = auth()->user()->id;

        $user = $this->user->find($userId);

        if ($user->guard == "client") {
            return view('frontend.pages.employee.jobs')->with('user', $user);
        } else {
            return view('frontend.pages.employer.jobs.edit')->with('user', $user)->with('job', $job);
        }
    }

    /**
     * 
     */
    public function updateJob($id, Request $request)
    {
        try {
            $input = $request->only([
                'title',
                'summary',
                'description',
                'salary_min',
                'salary_max',
                'deadline',
                'location',
                'responsibilities',
                'required_skills',
                'type'
            ]);

            $user = $this->user->find($request->id);

            $input['slug'] = str_replace(" ", "-", strtolower($request->title))."-".time();
            if($request->location == "0")
            {
               $input['location'] = $user->profile()->city_id;
            }
            $input['publish'] = 1;
            $input['user_id'] = $request->id;

            $this->job->update($id, $input);

            return redirect()->route('dashboard.jobs')
                ->with('success', "Job updated");
        } catch (\Exception $e) {
            $this->log->error((string) $e);

            return redirect()->route('dashboard.jobs')
                ->with('error', "Failed to update.")
                ->withInput();
        }
    }

    /**
     * Upload image
     *
     * @param $request
     * @return string
     */
    private function uploadImage($request)
    {
        $image = $request->file('profile_image');
        $filename = rand(1, 1000000) . time() . '.' . $image->getClientOriginalExtension();

        $width = 250;
        $height = 250;

        $destinationPath = public_path('uploads/users/');

        $image->move($destinationPath, $filename);

        $filePath = $destinationPath . $filename;

        Image::make($filePath)
            ->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            })
            ->save($destinationPath . $filename);

        return $filename;
    }

    /**
     * Delete old image
     *
     * @param $image
     * @return Boolean
     */
    private function deleteOldProfileImage($image)
    {
        $path = public_path('uploads/users/');

        if (file_exists($path . $image)) {
            unlink($path . $image);
        } else {
            return false;
        }
        return true;
    }

}
