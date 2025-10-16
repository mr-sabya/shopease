<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('pages.home.index');
    }

   
    


    // brands page
    public function brands()
    {
        return view('pages.brand.index');
    }

    

    // tags page
    public function tags()
    {
        return view('pages.tag.index');
    }
}
