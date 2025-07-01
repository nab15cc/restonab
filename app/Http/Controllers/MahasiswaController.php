<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();

        // ✅ Bungkus dengan 'data' agar DataTables bisa baca
        return response()->json([
            'data' => MahasiswaResource::collection($mahasiswa)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|string|max:10|unique:mahasiswa',
            'nama_menu' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string|max:255'
        ]);

        $mahasiswa = Mahasiswa::create($request->all());

        return (new MahasiswaResource($mahasiswa))->additional([
            'success' => true,
            'message' => 'Menu berhasil dibuat'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return response()->json($mahasiswa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_menu' => 'required|string|max:10|unique:mahasiswa,id_menu,' . $id . ',id_menu',
            'nama_menu' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string|max:255'
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        return (new MahasiswaResource($mahasiswa))->additional([
            'success' => true,
            'message' => 'Menu Berhasil diupdate'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return (new MahasiswaResource($mahasiswa))->additional([
            'success' => true,
            'message' => 'Menu berhasil dihapus'
        ]);
    }
}
