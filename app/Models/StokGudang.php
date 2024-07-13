<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokGudang extends Model
{
    use HasFactory;
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang','kode')
                        ->withDefault(['kode_barang' => 'Kategori Belum Dipilih']);
    }
}
