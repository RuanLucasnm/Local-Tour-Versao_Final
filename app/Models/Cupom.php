<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $table = 'cupom';
    protected $primaryKey = 'id_cupom';

    protected $fillable = [
        'codigo',
        'id_promocao',
        'data_inicio',
        'data_fim',
        'limite_uso_total',
        'limite_uso_por_usuario',
        'status'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
    ];

    public function promocao()
    {
        return $this->belongsTo(Promocao::class, 'id_promocao', 'id_promocao');
    }

    public function pacotes()
    {
        return $this->belongsToMany(Pacote::class, 'cupom_pacote', 'id_cupom', 'id_pacote');
    }
}

