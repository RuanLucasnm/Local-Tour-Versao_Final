@extends('layouts.app')

@section('title', 'Criar Promoção - Local Tour')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); max-width: 900px; margin: 0 auto;">
    <h1>➕ Criar Nova Promoção</h1>

    @if (session('success'))
        <div style="background:#d4edda;color:#155724;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">
            <ul style="margin:0;padding-left:1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/admin/promocoes">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div style="grid-column: span 2;">
                <label>Nome</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required class="form-control" />
            </div>

            <div style="grid-column: span 2;">
                <label>Descrição</label>
                <textarea name="descricao" class="form-control" rows="3">{{ old('descricao') }}</textarea>
            </div>

            <div>
                <label>Tipo de desconto</label>
                <select name="tipo_desconto" class="form-control" required>
                    <option value="percentual" {{ old('tipo_desconto','percentual')=='percentual'?'selected':'' }}>Percentual (%)</option>
                    <option value="valor" {{ old('tipo_desconto')=='valor'?'selected':'' }}>Valor fixo (R$)</option>
                </select>
            </div>

            <div>
                <label>Valor do desconto</label>
                <input type="number" step="0.01" name="valor_desconto" value="{{ old('valor_desconto') }}" required class="form-control" />
            </div>

            <div>
                <label>Data início</label>
                <input type="date" name="data_inicio" value="{{ old('data_inicio') }}" class="form-control" />
            </div>

            <div>
                <label>Data fim</label>
                <input type="date" name="data_fim" value="{{ old('data_fim') }}" class="form-control" />
            </div>

            <div>
                <label>Limite uso total (opcional)</label>
                <input type="number" name="limite_uso_total" value="{{ old('limite_uso_total') }}" min="1" class="form-control" />
            </div>

            <div>
                <label>Limite uso por usuário (opcional)</label>
                <input type="number" name="limite_uso_por_usuario" value="{{ old('limite_uso_por_usuario') }}" min="1" class="form-control" />
            </div>

            <div>
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="ativa" {{ old('status','ativa')=='ativa'?'selected':'' }}>Ativa</option>
                    <option value="inativa" {{ old('status')=='inativa'?'selected':'' }}>Inativa</option>
                </select>
            </div>

            <div style="grid-column: span 1;">
                <label>Código do cupom</label>
                <input type="text" name="codigo" value="{{ old('codigo') }}" required class="form-control" placeholder="EX: LOCAL10" />
            </div>

            <div>
                <label>Cupom início (opcional)</label>
                <input type="date" name="cupom_data_inicio" value="{{ old('cupom_data_inicio') }}" class="form-control" />
            </div>

            <div>
                <label>Cupom fim (opcional)</label>
                <input type="date" name="cupom_data_fim" value="{{ old('cupom_data_fim') }}" class="form-control" />
            </div>

            <div>
                <label>Limite uso total do cupom (opcional)</label>
                <input type="number" name="cupom_limite_uso_total" value="{{ old('cupom_limite_uso_total') }}" min="1" class="form-control" />
            </div>

            <div>
                <label>Limite uso por usuário do cupom (opcional)</label>
                <input type="number" name="cupom_limite_uso_por_usuario" value="{{ old('cupom_limite_uso_por_usuario') }}" min="1" class="form-control" />
            </div>

            <div>
                <label>Status do cupom</label>
                <select name="cupom_status" class="form-control" required>
                    <option value="ativa" {{ old('cupom_status','ativa')=='ativa'?'selected':'' }}>Ativa</option>
                    <option value="inativa" {{ old('cupom_status')=='inativa'?'selected':'' }}>Inativa</option>
                </select>
            </div>

            <div style="grid-column: span 2;">
                <label>Pacotes elegíveis (escopo do cupom)</label>
                <div style="max-height: 220px; overflow:auto; padding:0.5rem; border:1px solid #eee; border-radius:6px;">
                    @foreach($pacotes as $pacote)
                        <label style="display:block; padding:0.35rem 0;">
                            <input type="checkbox" name="pacotes[]" value="{{ $pacote->id_pacote }}" {{ in_array($pacote->id_pacote, old('pacotes', [])) ? 'checked' : '' }} />
                            <span>{{ $pacote->titulo }}</span>
                        </label>
                    @endforeach
                </div>
                <small style="color:#666;">Selecione ao menos 1 pacote.</small>
            </div>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1.5rem;">
            <button type="submit" class="btn btn-success" style="flex:1;">Salvar Promoção</button>
            <a href="/admin/promocoes" class="btn btn-secondary" style="flex:1; text-align:center;">← Voltar</a>
        </div>
    </form>
</div>
@endsection

