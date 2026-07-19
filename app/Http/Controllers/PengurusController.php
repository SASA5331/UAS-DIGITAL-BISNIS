<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $penguruses = Pengurus::with('jabatan')->get();
        return view('pengurus.index', compact('penguruses'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        return view('pengurus.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'max:255',
            'salary' => 'required|numeric'
        ]);

        $data = $request->all();
        $data['created_by'] = 'Admin';

        Pengurus::create($data);
        return redirect()->route('pengurus.index')->with('success', 'Data Pengurus berhasil ditambahkan');
    }

    public function edit(Pengurus $pengurus)
    {
        $jabatans = Jabatan::all();
        return view('pengurus.edit', compact('pengurus', 'jabatans'));
    }

    public function update(Request $request, Pengurus $pengurus)
    {
        $request->validate([
            'jabatan_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'max:255',
            'salary' => 'required|numeric'
        ]);

        $data = $request->all();
        $data['updated_by'] = 'Admin';

        $pengurus->update($data);
        return redirect()->route('pengurus.index')->with('success', 'Data Pengurus berhasil diubah');
    }

    public function destroy(Pengurus $pengurus)
    {
        $pengurus->delete();
        return redirect()->route('pengurus.index')->with('success', 'Data Pengurus berhasil dihapus');
    }
}