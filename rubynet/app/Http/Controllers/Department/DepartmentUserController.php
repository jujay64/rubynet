<?php

namespace App\Http\Controllers\Department;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DepartmentUserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $users = $department->users;

        return $this->showAll($users);
    }
}
