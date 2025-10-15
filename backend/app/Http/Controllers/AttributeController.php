<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttributeController extends Controller
{
    //
    public function attributes()
    {
        return view('attribute.attributes.index');
    }

    // attribute value
    public function attributeValues()
    {
        return view('attribute.attribute-value.index');
    }

    // attribute set
    public function attributeSets()
    {
        return view('attribute.attribute-set.index');
    }
}
