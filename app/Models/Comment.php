<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
