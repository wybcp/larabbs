<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function view;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }
}
