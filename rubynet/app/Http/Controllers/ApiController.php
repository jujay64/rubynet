<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class ApiController extends Controller
{
    use ApiResponser;

    protected function allowedAdminAction()
    {
    	if (Gate::denies('admin-action')){
    		throw new AuthorizationException('This action is not allowed');
    	}
    }
}
