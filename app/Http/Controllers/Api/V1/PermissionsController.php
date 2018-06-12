<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\PermissionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = $this->user()->getAllPermissions();
        return $this->response->collection($permissions, new PermissionTransformer());

    }
}
