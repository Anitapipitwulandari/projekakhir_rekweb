<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MahasiswaController extends Controller
{
    /**
     * Menambahkan middleware pada controller.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Menampilkan semua data mahasiswa.
     */
    public function index()
    {
        return Mahasiswa::latest()->get(); // Mengambil data mahasiswa terbaru
    }

    /**
     * Menyimpan data mahasiswa baru.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|max:20|unique:mahasiswa,nim',
            'email' => 'required|email|unique:mahasiswa,email',
        ]);

        $mahasiswa = Mahasiswa::create($fields);

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan',
            'mahasiswa' => $mahasiswa,
        ], 201);
    }

    /**
     * Menampilkan data mahasiswa berdasarkan ID.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return response()->json([
            'mahasiswa' => $mahasiswa,
        ]);
    }

    /**
     * Memperbarui data mahasiswa berdasarkan ID.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        Gate::authorize('modify', $mahasiswa); // Memastikan pengguna memiliki izin

        $fields = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|max:20|unique:mahasiswa,nim,' . $mahasiswa->id,
            'email' => 'required|email|unique:mahasiswa,email,' . $mahasiswa->id,
        ]);

        $mahasiswa->update($fields);

        return response()->json([
            'message' => 'Data mahasiswa berhasil diperbarui',
            'mahasiswa' => $mahasiswa,
        ]);
    }

    /**
     * Menghapus data mahasiswa berdasarkan ID.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        Gate::authorize('modify', $mahasiswa); // Memastikan pengguna memiliki izin

        $mahasiswa->delete();

        return response()->json([
            'message' => 'Data mahasiswa berhasil dihapus',
        ]);
    }
}
