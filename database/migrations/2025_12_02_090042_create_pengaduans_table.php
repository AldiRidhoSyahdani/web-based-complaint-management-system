<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            
            // Opsional: kalau nanti ada login masyarakat, bisa dipakai
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Data pelapor (wajib diisi meskipun tanpa login)
            $table->string('nama', 100);
            $table->string('email', 100);

            // Kategori pengaduan — pakai enum supaya 100% aman dan terbatas
            $table->enum('kategori', [
                'Penerangan Jalan Umum (PJU)',
                'Rambu dan Marka Jalan',
                'Lalu Lintas',
                'Angkutan Umum dan Terminal',
                'Parkir dan Fasilitas Pejalan Kaki'
            ]);

            // Isi pengaduan
            $table->text('isi_pengaduan');

            // Foto pendukung
            $table->string('foto')->nullable();

            // Status pengaduan — lebih rapi pakai enum juga
            $table->enum('status', [
                'Menunggu Tindakan',
                'Sedang Diproses',
                'Selesai'
            ])->default('Menunggu Tindakan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};