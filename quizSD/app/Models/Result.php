<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    // Tambahkan baris ini
    protected $fillable = [
        'user_id',
        'category_id',
        'skor',
        'benar',
        'salah',
    ];

    // Hubungan ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
