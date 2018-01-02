<?php

namespace App\Http\Controllers;

use App\Models\User;
use function compact;
use Illuminate\Http\Request;
use function view;

class UsersController extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
}
