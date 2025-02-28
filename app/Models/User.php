<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = ['name', 'job', 'email', 'password', 'admin', 'phone'];

    protected $hidden = ['password', 'remember_token'];

    protected $table = 'users';

}
