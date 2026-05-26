<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';
    protected $primaryKey = 'id_reserva';
    protected $fillable = ['id_users', 'id_pacote', 'data_reserva', 'status_pagamento', 'cupom_aplicado'];

    public function usuario() {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }


    public function pacote() {
        return $this->belongsTo(Pacote::class, 'id_pacote', 'id_pacote');
    }
}
