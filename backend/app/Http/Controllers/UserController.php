<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // customers
    public function customers()
    {
        return view('users.customers.index');
    }

    // create customer
    public function createCustomer()
    {
        return view('users.customers.create');
    }

    // edit customer
    public function editCustomer($id)
    {
        return view('users.customers.edit', ['userId' => $id]);
    }

    // investors
    public function investors()
    {
        return view('users.investors.index');
    }

    // create investor
    public function createInvestor()
    {
        return view('users.investors.create');
    }

    // edit investor
    public function editInvestor($id)
    {
        return view('users.investors.edit', ['userId' => $id]);
    }


    // vendors
    public function vendors()
    {
        return view('users.investors.index');
    }

    // create vendors
    public function createVendors()
    {
        return view('users.vendors.create');
    }

    // edit vendors
    public function editVendors($id)
    {
        return view('users.vendors.edit', ['userId' => $id]);
    }
}
