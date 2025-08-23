@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h1 class="mb-4">Login</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Senha</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Lembrar-me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>

            <div class="mt-3 d-flex justify-content-between">
                <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
                <a href="{{ route('register') }}">Registrar</a>
            </div>
        </form>
    </div>
</div>
@endsection
