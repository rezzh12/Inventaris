<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id','id')
                        ->withDefault(['ruangan_id' => 'Ruangan Belum Dipilih']);
    }
    public function perencanaan()
    {
        return $this->belongsTo(Perencanaan::class, 'perencanaan_id','id')
                        ->withDefault(['perencanaan_id' => 'User Belum Dipilih']);
    }
}
