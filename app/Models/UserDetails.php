<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    //these are fillabble input
    protected $fillable = [
        'user_id',
        'bio_data',
        'fav', //update this
        'status',
    ];

    //state this is belong to user table
    public function user(){
        return $this->belongsTo(User::class);
    }
}
