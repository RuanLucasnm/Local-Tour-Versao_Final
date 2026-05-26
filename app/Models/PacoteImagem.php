<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacoteImagem extends Model
{
    protected $table = 'pacote_imagem';
    protected $primaryKey = 'id_pacote_imagem';

    protected $fillable = ['id_pacote', 'url_imagem', 'ordem'];

    public function pacote()
    {
        return $this->belongsTo(Pacote::class, 'id_pacote', 'id_pacote');
    }
}

