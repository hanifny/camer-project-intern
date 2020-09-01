<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'api_token' 
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
