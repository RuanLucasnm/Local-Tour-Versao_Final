<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_perfil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_users', 'id_users');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'id_users', 'id_users');
    }

    public function isAdmin()
    {
        return $this->tipo_perfil === 'admin';
    }
}
