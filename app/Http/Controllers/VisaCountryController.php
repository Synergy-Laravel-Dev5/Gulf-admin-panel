<?php

namespace App\Http\Controllers;

use App\Models\VisaCountry;
use App\Models\VisaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VisaCountryController extends Controller
{
    
    public function index()
    {
        $countries = VisaCountry::with('visaTypes')->latest()->get();

        return view('visa-country.index', compact('countries'));
    }
    public function create()
    {
        return view('visa-country.create');
    }

    protected function rules(): array
    {
        return [
            'country_name'                  => 'required|string|max:255',
            'country_code'                  => 'nullable|string|max:10',
            'flag'                          => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'is_active'                     => 'nullable|boolean',

            'visa_types'                    => 'required|array|min:1',
            'visa_types.*.visa_name'        => 'required|string|max:255',
            'visa_types.*.b2b_rate'         => 'nullable|string|max:255',
            'visa_types.*.visa_fee'         => 'nullable|string|max:255',
            'visa_types.*.process_time'     => 'nullable|string|max:255',
            'visa_types.*.notes'            => 'nullable|string|max:255',
            'visa_types.*.is_active'        => 'nullable|boolean',
            'visa_types.*.requirements'     => 'nullable|array',
            'visa_types.*.requirements.*'   => 'nullable|string|max:255',
        ];
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), $this->rules())->validate();

        DB::transaction(function () use ($validated, $request) {
            $data = [
                'country_name' => $validated['country_name'],
                'country_code' => $validated['country_code'] ?? null,
                'is_active'    => $request->boolean('is_active', true),
            ];

            if ($request->hasFile('flag')) {
                $file     = $request->file('flag');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/visa_flags'), $filename);
                $data['flag'] = $filename;
            }

            $country = VisaCountry::create($data);

            foreach ($validated['visa_types'] as $type) {
                $requirements = array_values(array_filter($type['requirements'] ?? []));

                $country->visaTypes()->create([
                    'visa_name'    => $type['visa_name'],
                    'b2b_rate'     => $type['b2b_rate'] ?? null,
                    'visa_fee'     => $type['visa_fee'] ?? null,
                    'process_time' => $type['process_time'] ?? null,
                    'requirements' => $requirements,
                    'notes'        => $type['notes'] ?? null,
                    'is_active'    => isset($type['is_active']) ? (bool) $type['is_active'] : true,
                ]);
            }
        });

        return redirect()->route('visa-country.index')
            ->with('success', 'Visa country created successfully.');
    }

    public function edit($id)
    {
        $country = VisaCountry::with('visaTypes')->findOrFail($id);

        return view('visa-country.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = VisaCountry::findOrFail($id);

        $validated = Validator::make($request->all(), $this->rules())->validate();

        DB::transaction(function () use ($validated, $country, $request) {
            $data = [
                'country_name' => $validated['country_name'],
                'country_code' => $validated['country_code'] ?? null,
                'is_active'    => $request->boolean('is_active', true),
            ];

            if ($request->hasFile('flag')) {
                if ($country->flag && file_exists(public_path('assets/images/visa_flags/' . $country->flag))) {
                    unlink(public_path('assets/images/visa_flags/' . $country->flag));
                }

                $file     = $request->file('flag');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/visa_flags'), $filename);
                $data['flag'] = $filename;
            }

            $country->update($data);

            $keepIds = [];

            foreach ($validated['visa_types'] as $type) {
                $requirements = array_values(array_filter($type['requirements'] ?? []));

                $data = [
                    'visa_name'    => $type['visa_name'],
                    'b2b_rate'     => $type['b2b_rate'] ?? null,
                    'visa_fee'     => $type['visa_fee'] ?? null,
                    'process_time' => $type['process_time'] ?? null,
                    'requirements' => $requirements,
                    'notes'        => $type['notes'] ?? null,
                    'is_active'    => isset($type['is_active']) ? (bool) $type['is_active'] : true,
                ];

                if (!empty($type['id'])) {
                    $visaType = $country->visaTypes()->find($type['id']);
                    if ($visaType) {
                        $visaType->update($data);
                        $keepIds[] = $visaType->id;
                        continue;
                    }
                }

                $newType = $country->visaTypes()->create($data);
                $keepIds[] = $newType->id;
            }

            $country->visaTypes()->whereNotIn('id', $keepIds)->delete();
        });

        return redirect()->route('visa-country.index')
            ->with('success', 'Visa country updated successfully.');
    }

    public function destroy($id)
    {
        $country = VisaCountry::findOrFail($id);
        $country->delete();

        return redirect()->route('visa-country.index')
            ->with('success', 'Visa country moved to trash.');
    }


    public function trash()
    {
        $countries = VisaCountry::onlyTrashed()->with('visaTypes')->latest()->get();

        return view('visa-country.trash', compact('countries'));
    }

    public function restore($id)
    {
        $country = VisaCountry::onlyTrashed()->findOrFail($id);
        $country->restore();

        return redirect()->route('visa-country.trash')
            ->with('success', 'Visa country restored successfully.');
    }
}
