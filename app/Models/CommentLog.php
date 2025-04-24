<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLog extends Model
{
    use HasFactory;
    
    protected $fillable = ['email', 'old_comment', 'new_comment', 'action'];
    
    public function userComment()
    {
        return $this->belongsTo(UserComment::class, 'email', 'email');
    }
}
