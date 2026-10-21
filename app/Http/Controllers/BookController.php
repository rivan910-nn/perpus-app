<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->paginate(10);

        return inertia('Books/Index', [ 
            'books' => $books, 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Books/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari form (lihat Dasar Teori E.5) 
    $validated = $request->validate([ 
        'kode_buku'  => 'required|unique:books',   // wajib diisi, tidak boleh sama dengan kode_buku lain 
        'judul'      => 'required|max:255', 
        'pengarang'  => 'required|max:255', 
        'penerbit'   => 'nullable|max:255',        // boleh kosong 
        'tahun'      => 'nullable|digits:4',       // jika diisi, harus 4 digit angka 
        'stok'       => 'required|integer|min:0', 
    ]); 
  
    // 2. Jika seluruh data valid, simpan sebagai baris baru di tabel books 
    Book::create($validated); 
  
    // 3. Arahkan kembali ke halaman daftar buku, sertakan pesan sukses 
    return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
