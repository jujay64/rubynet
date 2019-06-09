<?php

namespace App\Http\Controllers\Department;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DepartmentController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return $this->showAll($departments);
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

        $department = Department::create($request->all());

        return $this->showOne($department, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return $this->showOne($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->allowedAdminAction();

        $department->fill($request->only([
            'name',
            'description'
        ]));

         if($department->isClean()){
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $department->save();

        return $this->showOne($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $this->allowedAdminAction();
        
        $department->delete();

        return $this->showOne($department);
    }
}
