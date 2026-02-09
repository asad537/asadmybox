<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CrmUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        if (!Auth::guard('crm')->user()->isAdmin()) {
            return redirect()->route('crm.dashboard')->with('error', 'Unauthorized');
        }
        $users = CrmUser::paginate(9);
        return view('crm.users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::guard('crm')->user()->isAdmin()) {
            return redirect()->route('crm.dashboard')->with('error', 'Unauthorized');
        }
        return view('crm.users.create');
    }

    public function store(Request $request)
    {
        if (!Auth::guard('crm')->user()->isAdmin()) {
            return redirect()->route('crm.dashboard')->with('error', 'Unauthorized');
        }
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:crm_users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,sales',
            'allowed_ip' => 'nullable|ip',
        ]);

        CrmUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'allowed_ip' => $request->allowed_ip,
        ]);

        return redirect()->route('crm.users.index')->with('success', 'User created successfully.');
    }

    public function destroy($id)
    {
        if (!Auth::guard('crm')->user()->isAdmin()) {
            return redirect()->route('crm.dashboard')->with('error', 'Unauthorized');
        }
        
        CrmUser::destroy($id);
        return redirect()->back()->with('success', 'User deleted.');
    }
}
