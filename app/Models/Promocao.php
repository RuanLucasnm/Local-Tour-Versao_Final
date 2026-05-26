<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocao extends Model
{
    protected $table = 'promocao';
    protected $primaryKey = 'id_promocao';

    protected $fillable = [
        'nome',
        'descricao',
        'tipo_desconto',
        'valor_desconto',
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

    public function cupons()
    {
        return $this->hasMany(Cupom::class, 'id_promocao', 'id_promocao');
    }
}

