<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Mail\NewCompanyCreated;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->page == 'all') {
            return Company::with('employees')->get();
        } else {
            return Company::with('employees')->paginate(10);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if ($request->file('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '-' . $request->name . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('storage/company_logos'),$logoName);
        
            $company->logo = 'storage/company_logos/' . $logoName;
        } else {
            $company->logo = 'dummy_company_logo.png';
        }

        $company->save();

        if ($company->id) {
            Mail::to($company->email)->send(new NewCompanyCreated($company));

            $status = true;
            $message = 'Company is created successfully';
        } else {
            $status = false;
            $message = 'Something went wrong while creating company';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return $company;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, Company $company)
    {
        if ($company) {
            $company->name = $request->name;
            $company->email = $request->email;
            $company->website = $request->website;

            if ($request->file('logo')) {
                $logo = $request->file('logo');
                $logoName = time() . '-' . $request->name . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('storage/company_logos'),$logoName);
            
                $company->logo = 'storage/company_logos/' . $logoName;
            }
            
            $company->save();

            $status = true;
            $message = 'Company is updated successfully';
        } else {
            $status = false;
            $message = 'Company not found';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if ($company) {
            $company->delete();

            $status = true;
            $message = 'Company is deleted successfully';
        } else {
            $status = false;
            $message = 'Company not found';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }
}
