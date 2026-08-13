<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = User::where('user_type', 'company')->latest()->get();
        return view('company.index', compact('companies'));
    }

    public function edit($id)
    {
        $company = User::where('user_type', 'company')->findOrFail($id);
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = User::where('user_type', 'company')->findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $id,
            'phone'        => 'nullable|string|max:30',
            'status'       => 'required|in:active,inactive',
            'password'     => 'nullable|string|min:6',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        try {
            $company->name = $request->name;
            $company->company_name = $request->company_name;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->status = $request->status;

            if ($request->filled('password')) {
                $company->password = Hash::make($request->password);
            }

            if ($request->hasFile('logo')) {
                $destinationPath = public_path('uploads/company_logos');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                // Optional: Delete old logo file if it exists
                if ($company->logo && file_exists(public_path($company->logo))) {
                    @unlink(public_path($company->logo));
                }

                $file = $request->file('logo');
                $filename = time() . '_logo_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $company->logo = 'uploads/company_logos/' . $filename;
            }

            $company->save();

            return redirect()->route('company.index')
                ->with('success', 'Company updated successfully.');
        } catch (Exception $e) {
            Log::error('Company update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating company: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $company = User::where('user_type', 'company')->findOrFail($id);
            
            // Delete logo file
            if ($company->logo && file_exists(public_path($company->logo))) {
                @unlink(public_path($company->logo));
            }

            $company->delete();

            return redirect()->route('company.index')
                ->with('success', 'Company deleted successfully.');
        } catch (Exception $e) {
            Log::error('Company deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error deleting company: ' . $e->getMessage());
        }
    }
}
