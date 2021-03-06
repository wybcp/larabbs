<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Transformers\NotificationTransformer;
use Auth;

class NotificationsController extends Controller
{
    public function index(int $per_page = 20)
    {

        $notifications = Auth::user()->notifications()->paginate($per_page);
        return $this->response->paginator($notifications, new NotificationTransformer());

    }

    public function statistics()
    {
        return $this->response->array([
            'unread_count'=>$this->user->notification_count,
        ]);
    }

    public function read()
    {
        $this->user()->makeNotificationsAsRead();
        return $this->response->noContent();

    }
}
