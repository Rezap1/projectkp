<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Menambahkan user_id sebagai foreign key yang merujuk ke tabel users
            // constrained() memastikan ID tersebut harus ada di tabel users
            // cascadeOnDelete() berarti jika guru dihapus, kuis buatannya juga ikut terhapus
            $table->integer('kelas')->nullable()->after('nama_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Menghapus relasi dan kolomnya
            $table->dropColumn('kelas');
        });
    }
};
