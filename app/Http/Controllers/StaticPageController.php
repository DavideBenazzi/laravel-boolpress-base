<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    // HOMEPAGE
    public function index() {
        return view('home');
    }
    // ABOUT
    public function about() {
        return view('about');
    }

}
