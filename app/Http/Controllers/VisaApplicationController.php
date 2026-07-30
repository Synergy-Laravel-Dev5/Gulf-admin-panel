<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaType;
use Illuminate\Http\Request;

class VisaApplicationController extends Controller
{
    public function index()
    {
        $applications = VisaApplication::with('visaType.country')
            ->latest()
            ->get();

        return view('visa-application.index', compact('applications'));
    }


    public function show($id)
    {
        $application = VisaApplication::with('visaType.country')
            ->findOrFail($id);

        return view('visa-application.show', compact('application'));
    }


    public function edit($id)
    {
        $application = VisaApplication::findOrFail($id);

        $visaTypes = VisaType::where('is_active', 1)
            ->with('country')
            ->get();

        return view('visa-application.edit', compact(
            'application',
            'visaTypes'
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'visa_type_id' => 'required|exists:visa_types,id',
            'full_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'cnic'         => 'nullable|string|max:20',
            'status'       => 'required|in:pending,processing,approved,rejected',
            'remarks'      => 'nullable|string',
        ]);


        $application = VisaApplication::findOrFail($id);


        $application->update([
            'visa_type_id' => $request->visa_type_id,
            'full_name'    => $request->full_name,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'cnic'         => $request->cnic,
            'status'       => $request->status,
            'remarks'      => $request->remarks,
        ]);


        return redirect()
            ->route('visa-application.index')
            ->with('success', 'Visa application updated successfully.');
    }


    public function destroy($id)
    {
        $application = VisaApplication::findOrFail($id);

        $application->delete();


        return redirect()
            ->route('visa-application.index')
            ->with('success', 'Visa application deleted successfully.');
    }


    public function trash()
    {
        $applications = VisaApplication::onlyTrashed()
            ->with('visaType.country')
            ->latest()
            ->get();


        return view('visa-application.trash', compact('applications'));
    }


    public function restore($id)
    {
        VisaApplication::onlyTrashed()
            ->findOrFail($id)
            ->restore();


        return redirect()
            ->route('visa-application.trash')
            ->with('success', 'Visa application restored successfully.');
    }


    public function forceDelete($id)
    {
        VisaApplication::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();


        return redirect()
            ->route('visa-application.trash')
            ->with('success', 'Visa application deleted permanently.');
    }
}
