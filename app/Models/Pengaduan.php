<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduans';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'kategori',
        'isi_pengaduan',
        'foto',
        'status',
    ];

    protected $casts = [
        'kategori' => 'string',
        'status'   => 'string',
    ];

    const KATEGORI = [
        'Penerangan Jalan Umum (PJU)',
        'Rambu dan Marka Jalan',
        'Lalu Lintas',
        'Angkutan Umum dan Terminal',
        'Parkir dan Fasilitas Pejalan Kaki',
    ];

    const STATUS = [
        'Menunggu Tindakan',
        'Sedang Diproses',
        'Selesai',
    ];

    // RELATIONSHIP KE USER (WAJIB!)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Scope biar gampang filter
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}