@extends('layouts.app')

@section('title', 'Criar Transporte - Local Tour')

@section('content')
<style>
    .form-container { max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
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
    <h1>➕ Criar Transporte</h1>

    <form method="POST" action="/admin/transportes">
        @csrf

        <div class="form-group">
            <label for="tipo_transporte">Tipo de Transporte *</label>
            <input type="text" id="tipo_transporte" name="tipo_transporte" value="{{ old('tipo_transporte') }}" required placeholder="Ex: Ônibus">
            @error('tipo_transporte')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="companhia">Companhia *</label>
            <input type="text" id="companhia" name="companhia" value="{{ old('companhia') }}" required placeholder="Ex: Expresso Brasil">
            @error('companhia')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Criar Transporte</button>
            <a href="/admin/transportes" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
@endsection

