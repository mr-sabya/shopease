<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    //country
    public function countries()
    {
        return view('pages.locations.countries');
    }

    // state
    public function states()
    {
        return view('pages.locations.states');
    }

    // city
    public function cities()
    {
        return view('pages.locations.cities');
    }
}
