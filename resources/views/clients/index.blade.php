@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Clientes</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('clients.index') }}" class="mb-4 d-flex gap-2">
        <input type="text" name="name" value="{{ request('name') }}" placeholder="Nome" class="form-control">
        <input type="text" name="email" value="{{ request('email') }}" placeholder="Email" class="form-control">
        <select name="is_active" class="form-select">
            <option value="">-- Status --</option>
            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Ativo</option>
            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inativo</option>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Limpar</a>
    </form>

    <!-- Tabela -->
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach(['id'=>'ID','name'=>'Nome','email'=>'Email','is_active'=>'Status','created_at'=>'Criado em'] as $field => $label)
                    <th>
                        <a href="{{ route('clients.index', array_merge(request()->all(), [
                            'sort' => $field,
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                        ])) }}">
                            {{ $label }}
                            @if(request('sort') === $field)
                                ({{ request('direction') }})
                            @endif
                        </a>
                    </th>
                @endforeach
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>
                        @if($client->is_active)
                            <span class="badge bg-success">Ativo</span>
                        @else
                            <span class="badge bg-danger">Inativo</span>
                        @endif
                    </td>
                    <td>{{ $client->created_at->format('d/m/Y H:i') }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Tem certeza?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Nenhum cliente encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="mt-3">
        {{ $clients->withQueryString()->links() }}
    </div>

    <a href="{{ route('clients.create') }}" class="btn btn-success mt-3">+ Novo Cliente</a>
</div>
@endsection
