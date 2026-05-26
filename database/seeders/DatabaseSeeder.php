<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cidade;
use App\Models\Transporte;
use App\Models\Pacote;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@localtour.com',
            'password' => Hash::make('admin123'),
            'tipo_perfil' => 'admin',
        ]);

        // Criar usuário cliente de teste
        User::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@localtour.com',
            'password' => Hash::make('cliente123'),
            'tipo_perfil' => 'cliente',
        ]);

        // Criar cidades
        $cidades = [
            ['nome' => 'São Paulo', 'estado' => 'SP'],
            ['nome' => 'Rio de Janeiro', 'estado' => 'RJ'],
            ['nome' => 'Belo Horizonte', 'estado' => 'MG'],
            ['nome' => 'Salvador', 'estado' => 'BA'],
            ['nome' => 'Recife', 'estado' => 'PE'],
        ];

        foreach ($cidades as $cidade) {
            Cidade::create($cidade);
        }

        // Criar transportes
        $transportes = [
            ['tipo_transporte' => 'Ônibus', 'companhia' => 'Greyhound'],
            ['tipo_transporte' => 'Avião', 'companhia' => 'LATAM'],
            ['tipo_transporte' => 'Trem', 'companhia' => 'SuperVia'],
            ['tipo_transporte' => 'Carro', 'companhia' => 'Localiza'],
        ];

        foreach ($transportes as $transporte) {
            Transporte::create($transporte);
        }

        // Criar pacotes de exemplo
        $pacotes = [
            [
                'id_cidade' => 1,
                'id_transporte' => 1,
                'titulo' => 'Fim de Semana em São Paulo',
                'descricao' => 'Explore a maior metrópole do Brasil com conforto e segurança.',
                'roteiro' => 'Dia 1: Chegada e passeio pelo Bairro da Liberdade. Dia 2: Museu do Ipiranga e Pinacoteca. Dia 3: Retorno.',
                'preco' => 1500.00,
            ],
            [
                'id_cidade' => 2,
                'id_transporte' => 2,
                'titulo' => 'Maravilhas do Rio de Janeiro',
                'descricao' => 'Visite o Cristo Redentor, Pão de Açúcar e as belas praias do Rio.',
                'roteiro' => 'Dia 1: Chegada e Copacabana. Dia 2: Cristo Redentor e Pão de Açúcar. Dia 3: Retorno.',
                'preco' => 2000.00,
            ],
            [
                'id_cidade' => 3,
                'id_transporte' => 1,
                'titulo' => 'Belo Horizonte e Ouro Preto',
                'descricao' => 'Descubra a história de Minas Gerais em cidades coloniais.',
                'roteiro' => 'Dia 1: Belo Horizonte. Dia 2: Ouro Preto. Dia 3: Retorno.',
                'preco' => 1200.00,
            ],
            [
                'id_cidade' => 4,
                'id_transporte' => 2,
                'titulo' => 'Praia e Cultura em Salvador',
                'descricao' => 'Conheça as praias paradisíacas e a cultura baiana.',
                'roteiro' => 'Dia 1: Chegada e Pelourinho. Dia 2: Praias de Itapuã. Dia 3: Retorno.',
                'preco' => 1800.00,
            ],
            [
                'id_cidade' => 5,
                'id_transporte' => 1,
                'titulo' => 'Recife e Olinda',
                'descricao' => 'Visite as cidades históricas do Nordeste.',
                'roteiro' => 'Dia 1: Recife Antigo. Dia 2: Olinda e Praia de Porto de Galinhas. Dia 3: Retorno.',
                'preco' => 1400.00,
            ],
        ];

        foreach ($pacotes as $pacote) {
            Pacote::create($pacote);
        }
    }
}
