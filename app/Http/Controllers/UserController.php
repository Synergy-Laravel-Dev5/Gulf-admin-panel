<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // $this->authorize('user_view');

        $user = Auth::user();
        $trashuser = User::onlyTrashed()->count();
        $users = User::with('roles')->get();

        return view('user.index', compact('users', 'trashuser'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function create()

    {
        $this->authorize('user_create');


        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:3',
            'status'   => 'required|in:active,inactive',
            'roles'    => 'required|array',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->syncRoles($request->roles);

            return redirect()->route('user.index')
                ->with('success', 'User created successfully.');
        } catch (Exception $e) {
            Log::error('User create failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // $this->authorize('user_edit');

        $user = User::findOrFail($id);
        $roles = \Spatie\Permission\Models\Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $id,
            'phone'           => 'nullable|string|max:30',
            'status'          => 'required|in:active,inactive',
            'roles'           => 'nullable|array',
            'password'        => 'nullable|string|min:3',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'passport'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'cnic_front'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'cnic_back'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'visa'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'ticket'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        try {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $destinationPath = public_path('uploads/user_documents');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_avatar_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $user->profile_picture = 'uploads/user_documents/' . $filename;
            }

            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $filename = time() . '_passport_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $user->passport = 'uploads/user_documents/' . $filename;
            }

            if ($request->hasFile('cnic_front')) {
                $file = $request->file('cnic_front');
                $filename = time() . '_cnic_front_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $user->cnic_front = 'uploads/user_documents/' . $filename;
            }

            if ($request->hasFile('cnic_back')) {
                $file = $request->file('cnic_back');
                $filename = time() . '_cnic_back_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $user->cnic_back = 'uploads/user_documents/' . $filename;
            }

            if ($request->hasFile('visa')) {
                $file = $request->file('visa');
                $filename = time() . '_visa_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $user->visa = 'uploads/user_documents/' . $filename;
            }

            if ($request->hasFile('ticket')) {
                $file = $request->file('ticket');
                $filename = time() . '_ticket_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $user->ticket = 'uploads/user_documents/' . $filename;
            }

            $user->save();
            
            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            return redirect()->route('user.index')
                ->with('success', 'User updated successfully.');
        } catch (Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('user.index')
                ->with('success', 'User deleted successfully.');
        } catch (Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $this->authorize('user_trash_view');

        $users = User::onlyTrashed()
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.trash', compact('users'));
    }

    public function restore($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            return redirect()->route('user.index')
                ->with('success', 'User restored successfully.');
        } catch (Exception $e) {
            Log::error('User restore failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error restoring user: ' . $e->getMessage());
        }
    }
}
