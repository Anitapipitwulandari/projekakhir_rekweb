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
        return Mahasiswa::latest()->get(); // Mengambil semua data mahasiswa terbaru
    }

    /**
     * Menyimpan data mahasiswa baru.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $fields = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|max:10|unique:mahasiswa,nim',
            'ipk' => 'required|numeric|between:0,4.0',
        ]);

        // Membuat data mahasiswa baru
        $mahasiswa = Mahasiswa::create($fields);

        // Mengembalikan response JSON
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
        // Cek otorisasi menggunakan Gate
        Gate::authorize('modify', $mahasiswa);

        // Validasi data input
        $fields = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|max:10|unique:mahasiswa,nim,' . $mahasiswa->id,
            'ipk' => 'required|numeric|between:0,4.0',
        ]);

        // Memperbarui data mahasiswa
        $mahasiswa->update($fields);

        // Mengembalikan response JSON
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
        // Cek otorisasi menggunakan Gate
        Gate::authorize('modify', $mahasiswa);

        // Menghapus data mahasiswa
        $mahasiswa->delete();

        return response()->json([
            'message' => 'Data mahasiswa berhasil dihapus',
        ]);
    }
}
