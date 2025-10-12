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

    // settings page
    public function settings()
    {
        return view('pages.settings.index');
    }

    // categories page
    public function categories()
    {
        return view('pages.categories.index');
    }

    // add new category
    public function addCategory()
    {
        return view('pages.categories.create');
    }

    // edit category
    public function editCategory($id)
    {
        return view('pages.categories.edit', compact('id'));
    }


    // brands page
    public function brands()
    {
        return view('pages.brand.index');
    }
}
