<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // categories page
    public function index()
    {
        return view('pages.categories.index');
    }

    // add new category
    public function create()
    {
        return view('pages.categories.create');
    }

    // edit category
    public function edit($id)
    {
        return view('pages.categories.edit', compact('id'));
    }
}
