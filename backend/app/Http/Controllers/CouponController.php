<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // coupons page
    public function index()
    {
        return view('pages.coupon.index');
    }

    // create coupon
    public function create()
    {
        return view('pages.coupon.create');
    }

    // edit coupon
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('pages.coupon.edit', compact('coupon'));
    }
}
