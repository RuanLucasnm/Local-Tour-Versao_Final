<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    protected $table = 'pacote';
    protected $primaryKey = 'id_pacote';
    protected $fillable = ['id_cidade', 'id_transporte', 'titulo', 'descricao', 'roteiro', 'preco'];

    public function cidade() {
        return $this->belongsTo(Cidade::class, 'id_cidade', 'id_cidade');
    }

    public function transporte() {
        return $this->belongsTo(Transporte::class, 'id_transporte', 'id_transporte');
    }

    public function reservas() {
        return $this->hasMany(Reserva::class, 'id_pacote', 'id_pacote');
    }

    public function avaliacoes() {
        return $this->hasMany(Avaliacao::class, 'id_pacote', 'id_pacote');
    }

    public function imagens() {
        return $this->hasMany(PacoteImagem::class, 'id_pacote', 'id_pacote')
            ->orderBy('ordem', 'asc');
    }

    public function cupons()
    {
        return $this->belongsToMany(Cupom::class, 'cupom_pacote', 'id_pacote', 'id_cupom');
    }
}
