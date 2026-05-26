@extends('layouts.app')

@section('title', 'Criar Pacote - Local Tour')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-container h1 {
        margin-bottom: 2rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: inherit;
        font-size: 1rem;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-submit {
        flex: 1;
        padding: 0.75rem;
        background-color: #51cf66;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #40c057;
    }

    .btn-cancel {
        flex: 1;
        padding: 0.75rem;
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s;
    }

    .btn-cancel:hover {
        background-color: #5568d3;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<div class="form-container">
    <h1>➕ Criar Novo Pacote</h1>

    <form method="POST" action="/admin/pacotes" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="titulo">Título do Pacote *</label>
            <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required placeholder="Ex: Viagem para São Paulo">
            @error('titulo')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_cidade">Destino (Cidade) *</label>
            <select id="id_cidade" name="id_cidade" required>
                <option value="">-- Selecione uma cidade --</option>
                @foreach($cidades as $cidade)
                    <option value="{{ $cidade->id_cidade }}" {{ old('id_cidade') == $cidade->id_cidade ? 'selected' : '' }}>
                        {{ $cidade->nome }} - {{ $cidade->estado }}
                    </option>
                @endforeach
            </select>
            @error('id_cidade')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_transporte">Transporte *</label>
            <select id="id_transporte" name="id_transporte" required>
                <option value="">-- Selecione um transporte --</option>
                @foreach($transportes as $transporte)
                    <option value="{{ $transporte->id_transporte }}" {{ old('id_transporte') == $transporte->id_transporte ? 'selected' : '' }}>
                        {{ $transporte->tipo_transporte }} - {{ $transporte->companhia }}
                    </option>
                @endforeach
            </select>
            @error('id_transporte')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="preco">Preço (R$) *</label>
            <input type="number" id="preco" name="preco" value="{{ old('preco') }}" required placeholder="0.00" step="0.01" min="0">
            @error('preco')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" placeholder="Descreva o pacote de viagem...">{{ old('descricao') }}</textarea>
            @error('descricao')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="roteiro">Roteiro</label>
            <textarea id="roteiro" name="roteiro" placeholder="Descreva o roteiro da viagem...">{{ old('roteiro') }}</textarea>
            @error('roteiro')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="imagens">Imagens do Pacote (múltiplas) *</label>
            <input type="file" id="imagens" name="imagens[]" multiple accept="image/*">
            <div class="error-message" style="margin-top:0.5rem;">Envie 1 ou mais imagens. Se vazio, o pacote será exibido sem imagem (placeholder).</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Criar Pacote</button>
            <a href="/admin/pacotes" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
@endsection
