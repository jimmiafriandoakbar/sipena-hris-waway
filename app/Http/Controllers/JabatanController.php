<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $jabatan = Jabatan::when($search, function ($query) use ($search) {

                $query->where('nama_jabatan', 'like', '%' . $search . '%');

            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.daftarjabatan_admin', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|unique:jabatan,nama_jabatan'
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan
        ]);

        return back()->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $request->validate([
            'nama_jabatan' => 'required|unique:jabatan,nama_jabatan,' . $id
        ]);

        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan
        ]);

        return back()->with('success', 'Jabatan berhasil diupdate');
    }

    public function destroy($id)
    {
        Jabatan::findOrFail($id)->delete();

        return back()->with('success', 'Jabatan berhasil dihapus');
    }
}