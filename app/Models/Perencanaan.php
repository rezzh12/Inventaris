<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perencanaan extends Model
{
    use HasFactory;
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id','id')
                        ->withDefault(['ruangan_id' => 'Ruangan Belum Dipilih']);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id')
                        ->withDefault(['user_id' => 'User Belum Dipilih']);
    }
}
