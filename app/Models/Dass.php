<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dass extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'depression_score',
        'anxiety_score',
        'stress_score',
        'category',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
