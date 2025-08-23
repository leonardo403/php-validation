@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h1 class="mb-4">Registrar</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label>Nome</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autofocus>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Senha</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Confirmar Senha</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrar</button>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Já possui conta? Entrar</a>
            </div>
        </form>
    </div>
</div>
@endsection
