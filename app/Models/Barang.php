<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id','id')
                        ->withDefault(['kategori' => 'Kategori Belum Dipilih']);
    }
}
