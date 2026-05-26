<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    protected $table = 'transporte';
    protected $primaryKey = 'id_transporte';
    protected $fillable = ['tipo_transporte', 'companhia'];

    public function pacotes() {
        return $this->hasMany(Pacote::class, 'id_transporte', 'id_transporte');
    }
}
