<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendistribusian extends Model
{
    use HasFactory;
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'pengadaan_id','id')
                        ->withDefault(['pengadaan_id' => 'User Belum Dipilih']);
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id','id')
                        ->withDefault(['ruangan_id' => 'Ruangan Belum Dipilih']);
    }
}
