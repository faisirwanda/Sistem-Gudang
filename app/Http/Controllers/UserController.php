<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|max:255',
            // 'role_id' => 'required|'.Rule::in(['1','2','3','4']),
        ]);
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());

        return response(['$data' => $user]);
    }
    public function show($id){
        $user = User::findOrFail($id);
        return response(['data' => $user]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::findOrfail($id);
        $user->update($request->all());
        return response(['data' => $user]);
    }
    public function destroy(Request $request, $id)
    {
        $user = User::findOrfail($id);
        $user->delete();
        return response()->json([
            'message' => 'Data Berhasil Dihapus'
        ], 200);        
    }
}
