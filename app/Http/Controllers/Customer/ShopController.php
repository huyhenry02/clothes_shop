<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function showIndex()
    {
        return view('customer.pages.index');
    }
    public function showContact()
    {
        return view('customer.pages.contact');
    }
}
