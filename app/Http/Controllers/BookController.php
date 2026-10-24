<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; 

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $books = Book::when($request->search, function ($query, $search) { 
            // Blok ini HANYA dijalankan apabila $request->search tidak kosong 
            // where(...)->orWhere(...) berarti: cocok di judul ATAU cocok di pengarang 
            $query->where('judul', 'like', "%{$search}%") 
                ->orWhere('pengarang', 'like', "%{$search}%"); 
        })->latest()->paginate(10)->withQueryString();


        return inertia('Books/Index', [ 
            'books' => $books, 
            'search' => $request->search,
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
    public function edit(Book $book)
    {
         return inertia('Books/Edit', [ 
            'book' => $book, 
        ]); 
    }

    public function update(Request $request,Book $book)
    {
         $validated = $request->validate([ 
            'kode_buku'  => 'required|unique:books,kode_buku,' . $book->id,  // kecualikan id buku ini 
            'judul'      => 'required|max:255', 
            'pengarang'  => 'required|max:255', 
            'penerbit'   => 'nullable|max:255', 
            'tahun'      => 'nullable|digits:4', 
            'stok'       => 'required|integer|min:0', 
        ]); 

        $book->update($validated); 

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete(); 
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus'); 
    }
}
