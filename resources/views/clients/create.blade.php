@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Cliente</h1>

    <form method="POST" action="{{ route('clients.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            @error('email') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label>Confirmar Senha</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            {!! NoCaptcha::display() !!}
            @error('g-recaptcha-response') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Voltar</a>
    </form>

    {!! NoCaptcha::renderJs() !!}
</div>
@endsection
