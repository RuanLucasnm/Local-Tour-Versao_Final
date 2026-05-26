<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $fillable = ['nome', 'email', 'senha', 'tipo_perfil'];

    public function reservas() {
        return $this->hasMany(Reserva::class, 'id_users', 'id_users');
    }

    public function avaliacoes() {
        return $this->hasMany(Avaliacao::class, 'id_users', 'id_users');
    }
}
