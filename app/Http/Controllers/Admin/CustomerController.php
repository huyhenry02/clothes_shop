<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showIndex()
    {
        $customers = Customer::all();
        return view('admin.pages.customer.index', [
            'customers' => $customers
        ]);
    }
    public function showCreate()
    {
        return view('admin.pages.customer.edit', [
            'mode' => 'create',
            'customer' => null,
        ]);
    }

    public function showEdit($id)
    {
        $customer = Customer::with('user')->findOrFail($id);
        return view('admin.pages.customer.edit', [
            'mode' => 'edit',
            'customer' => $customer,
        ]);
    }

}
