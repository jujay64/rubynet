<?php

namespace App\Http\Controllers\Auth;

use App\Job;
use App\Role;
use App\User;
use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\RegistersUsers;

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
    protected $redirectTo = '/#/home';
    protected $departments, $jobs, $roles;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->departments = Department::all();
        $this->jobs = Job::all();
        $this->roles = Role::all();
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
            'firstName' => 'required',
            'lastName' => 'required',
            'firstNameKana' => 'required',
            'lastNameKana' => 'required',
            'entryDate' => 'required|date_format:Y/m/d',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'department' => 'required',
            'role' => 'required',
            'job' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([                
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'first_name_kana' => $data['firstNameKana'],
            'last_name_kana' => $data['lastNameKana'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'department_id' => $data['department'],
            'role_id' => $data['role'],
            'job_id' => $data['job'],
            'entry_date' => $data['entryDate'],
            'verification_token' => User::generateVerificationCode(),
            'admin' => User::REGULAR_USER,
            'verified' => User::UNVERIFIED_USER,
            'picture' => 'default.jpg'
        ]);
    }
}
