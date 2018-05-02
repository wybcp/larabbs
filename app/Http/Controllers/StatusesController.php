<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use function session;
use App\Models\Status;

class StatusesController extends Controller
{

    /**
     * StatusesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        Auth::user()->statuses()->create([
                'content' =>$request->get('content'),
        ]);
        session()->flash('success','微博已发布！');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
