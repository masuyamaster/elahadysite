<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'tblUser';
    protected $primaryKey = 'username';
    public $incrementing = false; // Because username is not auto-increment

    protected $fillable = ['username', 'email', 'password', 'birthDate', 'oAuthToken'];

    protected $hidden = ['password'];

    protected $casts = [
        'birthDate' => 'date',
    ];

    // JWT Methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
