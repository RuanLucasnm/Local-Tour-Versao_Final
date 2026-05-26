<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupomPacote extends Model
{
    protected $table = 'cupom_pacote';
    protected $primaryKey = 'id_cupom_pacote';

    protected $fillable = ['id_cupom', 'id_pacote'];
}

