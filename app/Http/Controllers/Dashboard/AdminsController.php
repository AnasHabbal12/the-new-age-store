<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Role;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::paginate();
        return view('dashboard.admins.index', compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admins.create', [
            'role' => Role::all(),
            'admin' => new Admin(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);
        $admin = Admin::create($request->all());
        $admin->roles()->attach($request->roles);
        return redirect()->route('dashboard.admins.index')->with('success', 'Admin Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $role = Role::all();
        $admin_roles = Admin::roles()->pluck('id')->toArray();
        return view('dashboard.admins.edit', compact('role', 'admin_roles', 'admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array',
        ]);
        $admin->update($request->all());
        $admin->roles()->sync($request->roles);
        return redirect()->route('dashboard.admins.index')->with('success', 'Admin Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Admin::destroy($id);
        return redirect()->route('dashboard.admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
