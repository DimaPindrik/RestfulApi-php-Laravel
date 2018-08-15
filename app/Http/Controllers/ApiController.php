<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
    	$this->middleware('auth:api');
    }   


    /**
     * This function will deny any non admin user from actions in the specified controllers,
     * It will not override any scopes or other gates.
     */
    protected function allowedAdminAction()
    {
    	if (Gate::denies('admin-action')) {
            throw new AuthorizationException('This action is not authorized!');
        }
    }
    
}
