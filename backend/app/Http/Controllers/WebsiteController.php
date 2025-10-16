<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    // banner page
    public function banners()
    {
        return view('website.banner.index');
    }
}
