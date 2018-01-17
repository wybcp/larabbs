<?php

namespace App\Http\Controllers;

use Auth;
use function compact;
use Illuminate\Http\Request;
use function view;

class NotificationsController extends Controller
{

    /**
     * NotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user=Auth::user();
        $notifications=$user->notifications()->paginate(20);
        $user->makeNotificationsAsRead();
        return view('notifications.index',compact('notifications'));
    }
}
