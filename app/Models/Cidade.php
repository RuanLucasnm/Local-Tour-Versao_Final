<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = 'cidade';
    protected $primaryKey = 'id_cidade';
    protected $fillable = ['nome', 'estado'];

    public function pacotes() {
        return $this->hasMany(Pacote::class, 'id_cidade', 'id_cidade');
    }
}
