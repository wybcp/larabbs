<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function view;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }
}
