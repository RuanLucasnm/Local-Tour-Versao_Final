<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacao';
    protected $primaryKey = 'id_avaliacao';
    protected $fillable = ['id_users', 'id_pacote', 'nota', 'comentario', 'status_moderacao'];

    public function usuario() {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function pacote() {
        return $this->belongsTo(Pacote::class, 'id_pacote', 'id_pacote');
    }
}
