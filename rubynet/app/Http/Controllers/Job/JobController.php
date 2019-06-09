<?php

namespace App\Http\Controllers\Job;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class JobController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::all();

        return $this->showAll($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->allowedAdminAction();

         $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $this->validate($request, $rules);

        $job = Job::create($request->all());

        return $this->showOne($job, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return $this->showOne($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $this->allowedAdminAction();

        $job->fill($request->only([
            'name',
            'description'
        ]));

         if($job->isClean()){
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $job->save();

        return $this->showOne($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $this->allowedAdminAction();
        
        $job->delete();

        return $this->showOne($job);
    }
}
