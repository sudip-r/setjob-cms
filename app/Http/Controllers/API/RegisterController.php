<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\AlterBase\Models\User\User;
use App\AlterBase\Models\User\Business;
use App\AlterBase\Models\User\Client;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use App\AlterBase\Models\User\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeWelcomeEmail;
use App\Mail\EmployerWelcomeEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * LoggerInterface $log
     */
    private $log;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoggerInterface $log)
    {
        $this->middleware('guest');
        $this->middleware('guest:business');
        $this->middleware('guest:client');
        $this->log = $log;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Check if user email already exists in database
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            // Add more validation rules for other fields as needed
        ]);
    
        if ($validator->fails()) {
            return response(['success' => 0, 'message' => 'Email already exists!']);
        }
        return response(['success' => 1, 'message' => 'Email passed!']);

    }

    /**
     * Register user from frontend API
     * 
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function registerFrontend(Request $request){
        $type = $request->type;

        $data = [
            'email' => $request->email,
            'name' => ucwords($request->name),
            'password' => $request->password
        ];

        $user = null;

        try{
            if($type == "client")
            {
                $user = $this->createClient($data);
                Mail::to($user->email)->send(new EmployeeWelcomeEmail($user->id));
            }
    
            if($type == "business")
            {
                $user = $this->createBusiness($data);
                Mail::to($user->email)->send(new EmployerWelcomeEmail($user->id));
            }
        }catch(\Exception $e)
        {
            $this->log->error((string)$e);
            return response(['success' => 0, 'message' => 'Failed to register user '.$e->getMessage()]);
        }
        
        if($user == null)
            return response(['success' => 0, 'message' => 'Failed to register user']);

        try{
            $profile = Profile::create([
                'user_id' => $user->id,
                'email' => $request->email,
                'name' => ucwords($request->name),
                'password' => $request->password,
                'address' => $request->address2 . " " . $request->address1,
                'contact' => convertNumber($request->contact),
                'city_id' => $request->town,
                'postal_code' => $request->postalCode
            ]);

            $credentials = $request->only('email', 'password');
            $credentials['active'] = 1;
            
        }catch(\Exception $e)
        {
            $this->log->error((string)$e);
            return response(['success' => 0, 'message' => 'Failed to register user '.$e->getMessage()]);
        }
        
        return response([
            'success' => 1,
            'message' => 'Registration complete'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'guard' => 'admin'
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBusinessRegisterForm()
    {
        return view('auth.register', ['url' => 'business']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showClientRegisterForm()
    {
        return view('auth.register', ['url' => 'client']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showStaffRegisterForm()
    {
        return view('auth.staff', ['url' => 'staff']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createBusiness(array $data)
    {
        return Business::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'slug' => cleanSlug($data['name'])."-".rand(111,999999999).date("is"),
            'guard' => 'business',
            'active' => 1
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createClient(array $data)
    {
        return Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'slug' => cleanSlug($data['name'])."-".rand(111,999999999).date("is"),
            'guard' => 'client',
            'active' => 1
        ]);
    }

}
