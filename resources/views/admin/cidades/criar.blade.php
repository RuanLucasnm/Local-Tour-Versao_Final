@extends('layouts.app')

@section('title', 'Criar Cidade - Local Tour')

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
    .form-container h1 { margin-bottom: 2rem; color:#333; }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display:block; margin-bottom:0.5rem; font-weight:600; color:#333; }
    .form-group input { width:100%; padding:0.75rem; border:1px solid #ddd; border-radius:4px; font-family:inherit; font-size:1rem; }
    .form-actions { display:flex; gap:1rem; margin-top:2rem; }
    .btn-submit { flex:1; padding:0.75rem; background:#51cf66; color:white; border:none; border-radius:4px; font-size:1rem; font-weight:600; cursor:pointer; }
    .btn-cancel { flex:1; padding:0.75rem; background:#667eea; color:white; border:none; border-radius:4px; font-size:1rem; font-weight:600; cursor:pointer; text-decoration:none; text-align:center; }
    .error-message { color:#dc3545; font-size:0.875rem; margin-top:0.25rem; }
</style>

<div class="form-container">
    <h1>➕ Criar Cidade</h1>

    <form method="POST" action="/admin/cidades">
        @csrf

        <div class="form-group">
            <label for="nome">Nome *</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required placeholder="Ex: Niterói">
            @error('nome')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="estado">Estado (Sigla ou Nome) *</label>
            <input type="text" id="estado" name="estado" value="{{ old('estado') }}" required placeholder="Ex: RJ">
            @error('estado')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Criar Cidade</button>
            <a href="/admin/cidades" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
@endsection

