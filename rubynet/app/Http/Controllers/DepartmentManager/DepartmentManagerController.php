<?php

namespace App\Http\Controllers\DepartmentManager;

use App\DepartmentManager;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DepartmentManagerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departmentManagers = DepartmentManager::all();

        return $this->showAll($departmentManagers);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DepartmentManager  $departmentManager
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentManager $departmentManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DepartmentManager  $departmentManager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentManager $departmentManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DepartmentManager  $departmentManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentManager $departmentManager)
    {
        //
    }
}
