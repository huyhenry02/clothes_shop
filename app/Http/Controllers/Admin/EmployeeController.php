<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function showIndex()
    {
        $employees = Employee::all();
        return view('admin.pages.employee.index', [
            'employees' => $employees
        ]);
    }
    public function showCreate()
    {
        return view('admin.pages.employee.edit', [
            'mode' => 'create',
            'employee' => null,
        ]);
    }

    public function showEdit($id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        return view('admin.pages.employee.edit', [
            'mode' => 'edit',
            'employee' => $employee,
        ]);
    }
}
