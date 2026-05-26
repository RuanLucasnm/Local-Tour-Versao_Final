<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaCupomUso extends Model
{
    protected $table = 'reserva_cupom_uso';
    protected $primaryKey = 'id_reserva_cupom_uso';

    protected $fillable = ['id_cupom', 'id_users', 'id_reserva'];
}

