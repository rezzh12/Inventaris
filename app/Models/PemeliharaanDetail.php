<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeliharaanDetail extends Model
{
    use HasFactory;
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id','id')
                        ->withDefault(['barang_id' => 'User Belum Dipilih']);
    }
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id','id')
                        ->withDefault(['inventaris_id' => 'Ruangan Belum Dipilih']);
    }
}
