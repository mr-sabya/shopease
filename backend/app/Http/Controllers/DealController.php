<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealController extends Controller
{
    //
    public function index()
    {
        return view('pages.deal.index');    
    }
    
    // create
    public function create()
    {
        return view('pages.deal.create');    
    }

    // edit
    public function edit($id)
    {
        return view('pages.deal.edit', ['dealId' => $id]);    
    }
}
