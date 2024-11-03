<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'id' => 'required|max:255|unique:barang',
            'nama_barang' => 'required|max:255',
            'kategori' => 'required|max:255',
            'lokasi' => 'required|max:255',
        ]);
        $barang = Barang::create($request->all());
        return response(['$data' => $barang]);
    }
    public function show($id){
        $barang = Barang::findOrFail($id);
        return response(['data' => $barang]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|max:255|unique:barang',
            'nama_barang' => 'required|max:255',
            'kategori' => 'required|max:255',
            'lokasi' => 'required|max:255',
        ]);
        $barang = Barang::findOrfail($id);
        $barang->update($request->all());
        return response(['data' => $barang]);
    }
    public function destroy(Request $request, $id)
    {
        $barang = Barang::findOrfail($id);
        $barang->delete();
        return response()->json([
            'message' => 'Data Berhasil Dihapus'
        ], 200);        
    }
}
