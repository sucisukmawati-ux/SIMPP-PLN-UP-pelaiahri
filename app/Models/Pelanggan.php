<?php

namespace App\Models;

use Database\Factories\PelangganFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /** @use HasFactory<PelangganFactory> */
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'id_pelanggan',
        'nama',
        'petugas',
        'unit',
        'nomor_telepon',
        'alamat',
        'latitude',
        'longitude',
        'status',
    ];
}
