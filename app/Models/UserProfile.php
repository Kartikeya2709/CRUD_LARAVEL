<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserProfileFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UserProfileFactory::new();
    }

    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'email',
        'name',
        'username',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip'
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];

    public function comment()
    {
        return $this->hasOne(UserComment::class, 'email', 'email');
    }
}
