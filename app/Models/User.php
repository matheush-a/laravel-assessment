<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'email',
        'name',
        'password',
        'type_id',
    ];

    protected $hidden = [
        'password'
    ];

    public function attempt($credentials) {
        $user = $this->newQuery()
            ->whereEmail($credentials['email'])
            ->first();
        
        if(!$user) {
            $user = $this->register($credentials);
        }

        $isValid = Hash::check($credentials['password'], $user->getAuthPassword());
    
        return $isValid
            ? $user
            : null;
    }

    public function byEmail($email) {
        return $this->newInstance()
            ->whereEmail($email)
            ->first();
    }

    public function register($data) {
        $instance = $this->newInstance($data);
        $instance->name = Str::random(16);
        $instance->save();

        return $instance;
    }

    public function setEmailVerified($user) {
        $user->email_verified_at = Carbon::now();
        $user->save();

        return $user;
    }

    public function setPasswordAttribute($password) {
        $this->attributes['password'] = Hash::make($password);
    }
}