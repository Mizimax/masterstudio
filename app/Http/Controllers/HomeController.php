<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index() {
        return view('home');
    }

    public function activity()
    {
        return view('activity');
    }

    public function getContent()
    {
        return view('components.activity-grid-card', ['activities' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]]);
    }
}
