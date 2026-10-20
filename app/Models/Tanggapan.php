<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    protected $table = 'tanggapan_pengaduans'; // nama tabel sesuai database

    protected $fillable = [
        'pengaduan_id',
        'admin_id',
        'status'
    ];

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    // Relasi ke Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id'); // sesuaikan nama model admin kamu
    }
}