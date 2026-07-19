<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);
        
        $data = $request->all();
        $data['created_by'] = 'Admin';

        Jabatan::create($data);
        return redirect()->route('jabatan.index')->with('success', 'Data Jabatan berhasil ditambahkan');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $data = $request->all();
        $data['updated_by'] = 'Admin'; 

        $jabatan->update($data);
        return redirect()->route('jabatan.index')->with('success', 'Data Jabatan berhasil diubah');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Data Jabatan berhasil dihapus');
    }
}