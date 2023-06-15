<?php

namespace App\Http\Controllers\Front;

use App\AlterBase\Models\Meta\City;
use App\AlterBase\Repositories\User\ProfileRepository;
use App\AlterBase\Repositories\User\UserRepository;
use App\AlterBase\Repositories\Job\JobRepository;
use App\AlterBase\Repositories\Setting\SettingRepository;
use App\AlterBase\Repositories\Setting\StripeRepository;
use App\AlterBase\Repositories\Category\CategoryRepository;
use App\AlterBase\Repositories\User\EmailSubscriptionRepository;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Stripe\StripeClient;

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
     * SettingRepository $setting
     */
    private $setting;

    /**
     * StripeRepository $stripe
     */
    private $stripe;

    /**
     * LoggerInterface $log
     */
    private $log;

    /**
     * CategoryRepository $category
     */
    private $category;

    /**
     * EmailSubscriptionRepository $email
     */
    private $email;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepository $user,
        ProfileRepository $profile,
        JobRepository $job,
        SettingRepository $setting,
        StripeRepository $stripe,
        CategoryRepository $category,
        EmailSubscriptionRepository $email,
        LoggerInterface $log) {
        $this->user = $user;
        $this->profile = $profile;
        $this->job = $job;
        $this->setting = $setting;
        $this->stripe = $stripe;
        $this->category = $category;
        $this->email = $email;
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

        $setting = $this->loadSettings();

        $user = auth()->user();

        $userId = $user->id;

        $user = $this->user->find($userId);

        if($user->stripe_id == "")
        {
            $this->createStripeCustomer($user);
        }

        $days = dateDifference($user->created_at);

        $expired = false;
        $payment = false;

        if($days > 30)
            $expired = true;

        if($user->verified == 1)
            $payment = true;

        $jobs = $this->job->paginateWithMultipleCondition(
            ['user_id' => $userId],
            'published_on',
            'desc',
            10,
            ['id', 'title', 'summary', 'salary_min', 'salary_max', 'deadline', 'location', 'type', 'slug', 'published_on']
        );

        if ($user->guard == "client") {
            return view('frontend.pages.employee.dashboard')
                ->with('user', $user)
                ->with('jobs', $jobs)
                ->with('expired', $expired)
                ->with('payment', $payment)
                ->with('days', $days);
        }
        return view('frontend.pages.employer.dashboard')
                ->with('user', $user)
                ->with('jobs', $jobs)
                ->with('expired', $expired)
                ->with('payment', $payment)
                ->with('days', $days);
        
    }

    /**
     * Show the user subscription status.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function subscription()
    {
        if (auth()->user() == null) {
            return redirect()->route('home');
        }

        $setting = $this->loadSettings();

        $user = auth()->user();

        $userId = $user->id;

        $user = $this->user->find($userId);

        if($user->stripe_id == "")
        {
            $this->createStripeCustomer($user);
        }

        $days = dateDifference($user->created_at);

        $expired = false;
        $payment = false;

        if($days > 30)
            $expired = true;

        if($user->verified == 1)
            $payment = true;

        $subscription = null;

        try{
            $subscription = $this->stripeSubscription($user);
        }catch(\Exception $e)
        {
            $subscription = null;
        }

        

        if ($user->guard == "client") {
            return view('frontend.pages.employee.subscription')
                ->with('user', $user)
                ->with('expired', $expired)
                ->with('payment', $payment)
                ->with('days', $days);
        }
        return view('frontend.pages.employer.subscription')
                ->with('user', $user)
                ->with('expired', $expired)
                ->with('payment', $payment)
                ->with('days', $days);
        
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

        $user = $this->user->findWithCondition(['id' => $userId],["*"]);

        $slug = $user->slug;
        if(!$user->slug || $user->slug = "" || $user->slug == NULL)
        {
            $data = [
                'slug' => cleanSlug($user->name)."-".rand(111,999999999).date("is"),
            ];

            $this->user->update($user->id, $data);

            $users = $this->user->findBy('id', $userId);

            $slug = $users->slug;
        }

        if ($user->guard == "client") {
            return view('frontend.pages.employee.profile')->with('user', $user)->with('slug', $slug);
        } else {
            return view('frontend.pages.employer.profile')->with('user', $user)->with('slug', $slug);
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
        $subscription = checkSubscription();

        if ($subscription['user'] == null) {
            return redirect()->route('home');
        }

        if ($subscription['user']->guard != "business")
        {
            return redirect()->route('user.dashboard');
        }

        if($subscription['on_trial'] == false && $subscription['active_subscription'] == false)
        {
            return redirect()->route('user.dashboard');
        }

        $userId = $subscription['user']->id;

        $user = $this->user->find($userId);

        $categories = $this->category->getWithCondition(['publish' => 1, 'type' => 'Jobs'], 'category', 'asc')->pluck('category', 'id')->toArray();

        if ($user->guard == "client") {
            return view('frontend.pages.employee.jobs')->with('user', $user);
        } else {
            return view('frontend.pages.employer.jobs.create')->with('user', $user)->with('categories', $categories);
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
                'required_skills',
                'salary_type',
                'category_id'
            ]);

            $input['salary_max'] = $request->salary_max ?? "0";

            $input['type'] = str_replace("-", " ", ucwords($request->type));
            $user = $this->user->find($request->id);

            $input['slug'] = str_replace(" ", "-", strtolower($request->title))."-".time();
            if($request->location == "0")
            {
               $input['location'] = $user->profile()->city_id;
            }

            $input['location_text'] = $this->getCityById($input['location']);

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
        $subscription = checkSubscription();

        if ($subscription['user'] == null) {
            return redirect()->route('home');
        }

        if($subscription['on_trial'] == false && $subscription['active_subscription'] == false)
        {
            return redirect()->route('user.dashboard');
        }

        $job = $this->job->find($id);

        $userId = auth()->user()->id;

        $categories = $this->category->getWithCondition(['publish' => 1, 'type' => 'Jobs'], 'category', 'asc')->pluck('category', 'id')->toArray();

        $user = $this->user->find($userId);

        if ($user->guard == "client") {
            return view('frontend.pages.employee.jobs')->with('user', $user);
        } else {
            return view('frontend.pages.employer.jobs.edit')->with('user', $user)->with('job', $job)->with('categories', $categories);
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
                'category_id',
                'salary_type'
            ]);

            $user = $this->user->find($request->id);

            $input['type'] = str_replace("-", " ", ucwords($request->type));

            $input['slug'] = str_replace(" ", "-", strtolower($request->title))."-".time();
            if($request->location == "0")
            {
               $input['location'] = $user->profile()->city_id;
            }
            $input['location_text'] = $this->getCityById($input['location']);

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
     * Job detail page
     * 
     * @param $slug
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobDetail($slug)
    {
        $subscription = checkSubscription();

        $member = true;

        if ($subscription['user'] == null) {
            $member = false;
        }

        if($subscription['on_trial'] == false && $subscription['active_subscription'] == false)
        {
            $member = false;
        }
        
        $job = $this->job->findBy('slug', $slug);

        if($job == null)
            abort(404);

        $user = $this->user->findBy('id', $job->user_id);

        $profile = $user->profile();

        return view('frontend.pages.job-detail')->with('job', $job)->with('user', $user)->with('profile', $profile)->with('member', $member);
    }

    /**
     * Settings Page
     */
    public function employeeSettings()
    {
        if(auth()->user() == null)
            return redirect()->route('home');
            
        $id = auth()->user()->id;

        $user = $this->user->find($id);

        $categories = $this->category->getWithCondition(['type' => 'Jobs', 'publish' => 1]);

        $subs = $this->email->getWithCondition(['user_id' => $id]);

        $selectedCategory = [];
        $selectedType = [];

        foreach($subs as $sub)
        {
            if($sub->category_id != NULL)
                $selectedCategory[] = $sub->category_id;
            
            if($sub->type != NULL)
                $selectedType[] = $sub->type;
        }

        return view('frontend.pages.employee.settings')
            ->with('user', $user)
            ->with('categories', $categories)
            ->with('selectedType', $selectedType)
            ->with('selectedCategory', $selectedCategory);
    }

    /**
     * Email subscriptions
     * 
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function employeeUpdateEmailSubscription(Request $request)
    {
        try{
        $this->email->truncateSubscription($request->user_id);

        $categories = $request->category;
        $types = $request->type;

        foreach($categories as $category)
        {
            $this->email->store(['user_id' => $request->user_id, 'category_id' => $category]);
        }

        foreach($types as $type)
        {
            $this->email->store(['user_id' => $request->user_id, 'type' => $type]);
        }
        
        return redirect()->route('dashboard.employee.settings')
            ->with('success', "Job updated");
        }catch(\Exception $e)
        {
            $this->log->error((string) $e);

            return redirect()->route('dashboard.employee.settings')
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

    /**
     * Load settings from file or db
     *
     * @return Array|Illuminate\Database\Eloquent\Collection
     */
    private function loadSettings()
    {
        try {
            return json_decode(Storage::get('public/settings/settings.json'), false);
        } catch (\Exception $e) {
            //If data could not be read from the settings.json file
            $this->log->error((string) $e);

            return $this->setting->find(1);
        }
    }

    /**
     * Create stripe customer
     * 
     * @param $user
     * @return Boolean
     */
    private function createStripeCustomer($user)
    {
        $stripe = $this->stripe->find(1);

        $key = $stripe->live_secret_key;
        if($stripe->live == 0)
        {
            //test
            $key = $stripe->test_secret_key;
        }

        if($key == "")
            return false;

        $client = new \Stripe\StripeClient($key);

        $description = "";

        if($user->guard == "client")
            $description = "Employee account";
        
        if($user->guard == "business")
            $description = "Employer account";
        
        if($description == "")
            return false;
        
        $customer = $client->customers->create([
            'name' => $user->name,
            'email' => $user->email,
            'description' => $description
        ]);

        $this->user->update($user->id, ['stripe_id' => $customer->id]);

        return true;
    }   

    /**
     * Check stripe subscription
     * 
     * @param $user
     * @return Object
     */
    private function stripeSubscription($user)
    {
        $stripe = $this->stripe->find(1);

        $key = $stripe->live_secret_key;
        if($stripe->live == 0)
        {
            //test
            $key = $stripe->test_secret_key;
        }

        if($key == "")
            return false;

        $client = new \Stripe\StripeClient($key);

        return $client->subscriptions->retrieve(
            $user->subscription_id,
            []
          );
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
