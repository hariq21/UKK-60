<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('id_kategori', 20)->unique();
            $table->string('nama', 60)->unique();
            $table->string('deskripsi', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('kategoris')->insert([
            [
                'id_kategori' => 'KAT-001',
                'nama' => 'Fasilitas',
                'deskripsi' => 'Laporan terkait sarana dan prasarana sekolah.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
