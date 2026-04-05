<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Support\Str;

class QuizSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Kategori
        $mtk = Category::create([
            'nama_kategori' => 'Matematika Dasar',
            'slug' => Str::slug('Matematika Dasar'),
        ]);

        // 2. Tambah Soal untuk Matematika
        Question::create([
            'category_id' => $mtk->id,
            'pertanyaan' => 'Berapakah hasil dari 15 + 25?',
            'opsi_a' => '30',
            'opsi_b' => '35',
            'opsi_c' => '40',
            'opsi_d' => '45',
            'jawaban_benar' => 'c',
        ]);

        Question::create([
            'category_id' => $mtk->id,
            'pertanyaan' => 'Bangun datar yang memiliki 3 sisi disebut...',
            'opsi_a' => 'Persegi',
            'opsi_b' => 'Segitiga',
            'opsi_c' => 'Lingkaran',
            'opsi_d' => 'Trapesium',
            'jawaban_benar' => 'b',
        ]);
    }
}
