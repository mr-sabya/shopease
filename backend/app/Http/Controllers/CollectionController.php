<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    //
    public function index()
    {
        return view('pages.collection.index');    
    }
    
    // create
    public function create()
    {
        return view('pages.collection.create');
    }


    // edit
    public function edit($id)
    {
        return view('pages.collection.edit', ['collectionId' => $id]);
    }
}
