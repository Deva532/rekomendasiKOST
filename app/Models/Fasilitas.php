<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $fillable = ['nama_fasilitas'];

    public function kost()
    {
        return $this->belongsToMany(Kost::class, 'fasilitas_kost');
    }
}
