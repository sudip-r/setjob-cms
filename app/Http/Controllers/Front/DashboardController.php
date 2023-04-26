<?php

namespace App\Http\Controllers\Front;

use App\AlterBase\Repositories\User\ProfileRepository;
use App\AlterBase\Repositories\User\UserRepository;
use App\AlterBase\Repositories\Job\JobRepository;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Storage;

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
            return view('frontend.pages.employee.dashboard')->with('user', $user)->with('jobs', $jobs);
        }
        return view('frontend.pages.employer.dashboard')->with('user', $user)->with('jobs', $jobs);
        
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

        if($user->slug = "" || $user->slug == NULL)
        {
            $data = [
                'slug' => cleanSlug($user->name)."-".rand(111,999999999).date("is"),
            ];

            $this->user->update($user->id, $data);
        }

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
                'address', 'mobile','city_id', 'postal_code', 'linkedin', 'twitter', 'facebook', 'instagram', 'summary', 'description'
            ]);

            $profileInput['contact'] = convertNumber($request->contact);

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
     * Update employer profile
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function employeeUpdateProfile(Request $request)
    {
        try {
            $input = $request->only([
                'name', 'email', 'title'
            ]);

            $id = $request->id;

            $user = $this->user->find($id);

            if ($request->hasFile('profile_image')) {
                $input['profile_image'] = $this->uploadImage($request);

                $this->deleteOldProfileImage($user->profile_image);
            }

            $this->user->update($id, $input);

            $profileInput = $request->only([
                'address', 'mobile','city_id', 'postal_code', 'linkedin', 'twitter', 'facebook', 'instagram', 'summary', 'description', 'map'
            ]);

            $profileInput['contact'] = convertNumber($request->contact);

            if( $request->hasFile('contact_person')){
                $profileInput['contact_person'] = $this->uploadFile($request);

                $this->deleteOldFile($user->profile()->contact_person);
            }

            if( $request->hasFile('categories')){
                $profileInput['categories'] = $this->uploadPortfolio($request, $id);

                $this->deletePortfolioFiles($user->profile()->categories, $id);
            }

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
            return view('frontend.pages.employee.jobs')->with('user', $user)->with('jobs', $jobs);
        } 
        return view('frontend.pages.employer.jobs.jobs')->with('user', $user)->with('jobs', $jobs);
        
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
                'deadline',
                'location',
                'responsibilities',
                'required_skills'
            ]);

            $input['salary_max'] = $request->salary_max ?? "0";

            $input['type'] = str_replace("-", " ", ucwords($request->type));
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
                'required_skills'
            ]);

            $user = $this->user->find($request->id);

            $input['type'] = str_replace("-", " ", ucwords($request->type));

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
     * Upload image
     *
     * @param $request
     * @return string
     */
    private function uploadFile($request)
    {
        $file = $request->file('contact_person');
        $filename = rand(1, 1000000) . time() . '.' . $file->getClientOriginalExtension();

        $destinationPath = public_path('uploads/users/');

        $file->move($destinationPath, $filename);

        return $filename;
    }

    /**
     * Upload image
     *
     * @param $request
     * @return string
     */
    private function uploadPortfolio($request, $id)
    {
        $files = $request->file('categories');

        $filename = [];
        foreach($files as $file){
        $name = rand(1, 1000000) . time() . '.' . $file->getClientOriginalExtension();

        $filename[] = $name;
        $destinationPath = public_path('uploads/users/'.$id);

        if(!file_exists($destinationPath))
            mkdir($destinationPath, 0775);

        $file->move($destinationPath."/", $name);
        }

        return json_encode($filename, true);
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

    /**
     * Delete old image
     *
     * @param $image
     * @return Boolean
     */
    private function deleteOldFile($file)
    {
        $path = public_path('uploads/users/');

        if (file_exists($path . $file) && $file != "") {
            unlink($path . $file);
        } else {
            return false;
        }
        return true;
    }

    /**
     * Delete old image
     *
     * @param $image
     * @return Boolean
     */
    private function deletePortfolioFiles($files, $id)
    {
        $path = public_path('uploads/users/'.$id."/");

        foreach(json_decode($files) as $file){
            if (file_exists($path . $file) && $file != "") {
                unlink($path . $file);
            } 
        }
        return true;
    }

}
