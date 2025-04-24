<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserProfile;
use Database\Factories\UserCommentFactory;

class UserComment extends Model
{
    use HasFactory;
    
    protected static function newFactory()
    {
        return UserCommentFactory::new();
    }
    
    protected $fillable = [
        'email',
        'comment'
    ];
    
    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'email', 'email');
    }
}
