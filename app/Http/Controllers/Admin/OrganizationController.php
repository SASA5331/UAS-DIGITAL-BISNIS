<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::withCount('events')
                            ->with('users')
                            ->latest()
                            ->get();
        return view('admin.organizations.index', compact('organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo_url'    => 'nullable|url',
        ]);

        Organization::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'logo_url'    => $request->logo_url,
            'status'      => 'active',
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil ditambahkan.');
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'status' => 'required|in:pending,active,suspended',
        ]);

        $organization->update(['status' => $request->status]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Status organisasi berhasil diperbarui.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil dihapus.');
    }
}