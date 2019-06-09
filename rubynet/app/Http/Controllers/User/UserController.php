<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Mail\UserCreated;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store','resend']);
        $this->middleware('auth:api')->except(['store','resend', 'verify']);
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-account')->only(['show', 'update']);
        $this->middleware('can:update,user')->only(['update']);
        $this->middleware('can:delete,user')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('department')->get();

        return $this->showAll($users);
    }

    /**
     * Get the current authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function getAuthenticatedUser(){
         return  $this->showOne(Auth::guard('api')->user());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'department_id' => 'required',
            'role_id' => 'required',
            'job_id' => 'required',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;
        $data['picture'] = 'default.jpg';
        
        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $this->showOne(User::where('id', $request->user)
                                    ->withCount('posts')
                                    ->withCount('postsLikes')
                                    ->withCount('comments')
                                    ->first()
                                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'password' => 'min:6|confirmed',
        ];

        if($request->has('first_name')){
            $user->first_name = $request->first_name;
        }

        if($request->has('last_name')){
            $user->last_name = $request->last_name;
        }

         if($request->has('first_name_kana')){
            $user->first_name_kana = $request->first_name_kana;
        }

        if($request->has('last_name_kana')){
            $user->last_name_kana = $request->last_name_kana;
        }

        if($request->has('nick_name')){
            $user->nick_name = $request->nick_name;
        }

        if($request->has('former_job')){
            $user->former_job = $request->former_job;
        }

        if($request->has('hobbies')){
            $user->hobbies = $request->hobbies;
        }

        if($request->has('location')){
            $user->location = $request->location;
        }

        if($request->has('birth_place')){
            $user->birth_place = $request->birth_place;
        }

        if($request->has('student_circles')){
            $user->student_circles = $request->student_circles;
        }

        if($request->has('one_word')){
            $user->one_word = $request->one_word;
        }

        if($request->has('description')){
            $user->description = $request->description;
        }

        if($request->has('internal_phone_number')){
            $user->internal_phone_number = $request->internal_phone_number;
        }

        if($request->has('date_of_birth')){
            $user->date_of_birth = $request->date_of_birth;
        }

        if($request->has('internal_phone_number')){
            $user->internal_phone_number = $request->internal_phone_number;
        }
        
        if($request->has('department_id')){
            $user->department_id = $request->department_id;
        }

        if($request->has('job_id')){
            $user->job_id = $request->job_id;
        }

        if($request->has('role_id')){
            $user->role_id = $request->role_id;
        }

        if($request->has('password')){
           $user->password = bcrypt($request->password);
        }

        if($request->has('admin')){
            $this->allowedAdminAction();
            
            if(!$user->isVerified()){
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }

            $user->admin = $request->admin;
        }

        if(!$user->isDirty()){
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->allowedAdminAction();

        $user->delete();

        return $this->showOne($user);
    }

    public function verify($token){
        $user=User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;

        $user->verification_token = null;

        $user->save();

        return $this->showMessage('The account has been verified successfully');
    }

    public function resend(User $user){
        if($user->isVerified()){
            return $this->errorResponse('This user is already verified',409);
        }

        retry(5, function() use($user){
                Mail::to($user)->send(new UserCreated($user));
            },100);

        return $this->showMessage('The verification email has been sent successfully');
    }

    public function uploadPicture(Request $request, User $user){
      $picture_tmp = $user->picture;
      // Build new picture file name 
      $ext = pathinfo($request->filename, PATHINFO_EXTENSION);
      $now = microtime();
      $filename = strval($user->id).str_replace(' ','',strval($now)).'.'. $ext;

      // Save blob data in storage 
      $path =  $request->photo->StoreAs('public/profile', $filename); 

      // Update picture name for user in database
      $user->picture = $filename;
      $user->touch();
      $user->save();

      //Delete previous user picture
      if(Str::startsWith($picture_tmp,$user->id) && Storage::disk('local')->exists('public/profile/' . $picture_tmp))
        Storage::disk('local')->delete('public/profile/' . $picture_tmp);

      return $this->showOne($user);
    }
}
