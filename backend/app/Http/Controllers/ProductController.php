<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        return view('product.index');
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('product.create');
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }
}
