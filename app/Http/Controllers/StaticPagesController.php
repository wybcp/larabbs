<?php

namespace App\Http\Controllers;

use Auth;
use function compact;
use Illuminate\Http\Request;
use function view;

class StaticPagesController extends Controller
{
    public function index()
    {
        $feed_items=[];
        if (Auth::check()){
            $feed_items=Auth::user()->feed()->paginate(30);
        }
        return view('static_pages.index',compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages.help');
    }

    public function about()
    {
        return view('static_pages.about');
    }
}
