<?php

namespace App\Http\Controllers;

use App\Models\Makul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MakulController extends Controller
{
    /**
     * Menambahkan middleware pada controller.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Menampilkan semua data mata kuliah.
     */
    public function index()
    {
        return Makul::latest()->get(); // Mengambil semua data makul terbaru
    }

    /**
     * Menyimpan data mata kuliah baru.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $fields = $request->validate([
            'namamakul' => 'required|max:255',
            'idmakul' => 'required|max:20|unique:makul,idmakul',
            'semester' => 'required|max:50',
        ]);

        // Membuat data makul baru
        $makul = Makul::create($fields);

        // Mengembalikan response JSON
        return response()->json([
            'message' => 'Mata kuliah berhasil ditambahkan',
            'makul' => $makul,
        ], 201);
    }

    /**
     * Menampilkan data mata kuliah berdasarkan ID.
     */
    public function show(Makul $makul)
    {
        return response()->json([
            'makul' => $makul,
        ]);
    }

    /**
     * Memperbarui data mata kuliah berdasarkan ID.
     */
    public function update(Request $request, Makul $makul)
    {
        // Cek otorisasi menggunakan Gate
        Gate::authorize('modify', $makul);

        // Validasi data input
        $fields = $request->validate([
            'namamakul' => 'required|max:255',
            'idmakul' => 'required|max:20|unique:makul,idmakul,' . $makul->id,
            'semester' => 'required|max:50',
        ]);

        // Memperbarui data makul
        $makul->update($fields);

        // Mengembalikan response JSON
        return response()->json([
            'message' => 'Mata kuliah berhasil diperbarui',
            'makul' => $makul,
        ]);
    }

    /**
     * Menghapus data mata kuliah berdasarkan ID.
     */
    public function destroy(Makul $makul)
    {
        // Cek otorisasi menggunakan Gate
        Gate::authorize('modify', $makul);

        // Menghapus data makul
        $makul->delete();

        return response()->json([
            'message' => 'Mata kuliah berhasil dihapus',
        ]);
    }
}
