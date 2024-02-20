<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use Session;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Employee::with('company')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->company_id = $request->company_id;
        $employee->save();

        if ($employee->id) {
            $status = true;
            $message = 'Employee is created successfully';
        } else {
            $status = false;
            $message = 'Something went wrong while creating employee';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        if ($employee) {
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->company_id = $request->company_id;
            $employee->save();

            $status = true;
            $message = 'Employee is updated successfully';
        } else {
            $status = false;
            $message = 'Employee not found';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee) {
            $employee->delete();

            $status = true;
            $message = 'Employee is deleted successfully';
        } else {
            $status = false;
            $message = 'Employee not found';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }
}
