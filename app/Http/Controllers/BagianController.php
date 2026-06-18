<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagian;

class BagianController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $bagian = Bagian::when($search, function ($query) use ($search) {

            $query->where('nama_bagian', 'like', '%' . $search . '%')
                  ->orWhere('kode_bagian', 'like', '%' . $search . '%');

        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view('admin.daftarbagian_admin', compact('bagian'));
}

    public function store(Request $request)
    {
        $request->validate([
            'kode_bagian' => 'required|unique:bagian,kode_bagian',
            'nama_bagian' => 'required|unique:bagian,nama_bagian',
        ]);

        bagian::create([
            'kode_bagian' => $request->kode_bagian,
            'nama_bagian' => $request->nama_bagian,
        ]);

        return back()->with('success', 'bagian berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bagian = bagian::findOrFail($id);

        $request->validate([
            'kode_bagian' => 'required|unique:bagian,kode_bagian,' . $id,
            'nama_bagian' => 'required|unique:bagian,nama_bagian,' . $id,
        ]);

        $bagian->update([
            'kode_bagian' => $request->kode_bagian,
            'nama_bagian' => $request->nama_bagian,
        ]);

        return back()->with('success', 'bagian berhasil diupdate');
    }

    public function destroy($id)
    {
        bagian::findOrFail($id)->delete();

        return back()->with('success', 'bagian berhasil dihapus');
    }
}