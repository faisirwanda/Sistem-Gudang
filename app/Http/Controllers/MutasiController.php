<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_mutasi' => 'required|string',
            'jumlah' => 'required|numeric',
            'barang_id' => 'required|numeric|exists:barang,id',
            'user_id' => 'required|numeric|exists:users,id',
        ]);
        $mutasi = Mutasi::create($request->all());

        return response(['$data' => $mutasi], 201);
    }
    public function show($id){
        $mutasi = Mutasi::findOrFail($id);
        return response(['data' => $mutasi]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_mutasi' => 'required|string',
            'jumlah' => 'required|numeric',
            'barang_id' => 'required|numeric|exists:barang,id',
            'user_id' => 'required|numeric|exists:users,id',
        ]);
        $mutasi = Mutasi::findOrfail($id);
        $mutasi->update($request->all());
        return response(['data' => $mutasi]);
    }
    public function destroy(Request $request, $id)
    {
        $mutasi = Mutasi::findOrfail($id);
        $mutasi->delete();
        return response()->json([
            'message' => 'Data Berhasil Dihapus'
        ], 200);        
    }
    public function getMutasiByBarang($barangId)
    {
        $mutasi = Mutasi::with('barang')->where('barang_id', $barangId)->get();
        if ($mutasi->isEmpty()) {
            return response()->json(['message' => 'Data mutasi tidak ditemukan untuk barang tersebut'], 404);
        }
        return response()->json($mutasi);
    }

    public function getMutasiByUser($userId)
    {
        $mutasi = Mutasi::with('user')->where('user_id', $userId)->get();
        if ($mutasi->isEmpty()) {
            return response()->json(['message' => 'Data mutasi tidak ditemukan untuk barang tersebut'], 404);
        }
        return response()->json($mutasi);
    }


}
