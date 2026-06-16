<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kost',
        'harga',
        'jarak',
        'jenis_kost',
        'alamat',
        'no_hp',
        'status',
        'deskripsi',
        'foto',
    ];

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_kost');
    }
}
