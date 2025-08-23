@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cliente</h1>

    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" class="form-control" required>
            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $client->email) }}" class="form-control" required>
            @error('email') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label>Nova Senha (opcional)</label>
            <input type="password" name="password" class="form-control">
            @error('password') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label>Confirmar Senha</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="is_active" class="form-select">
                <option value="1" {{ $client->is_active ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ !$client->is_active ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
