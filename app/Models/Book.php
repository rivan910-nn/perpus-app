<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [ 
        'kode_buku', 
        'judul', 
        'pengarang', 
        'tahun', 
        'stok', 
    ]; 
    use HasFactory; 

    public function loans() 
    { 
    return $this->hasMany(Loan::class); 
    }
}
