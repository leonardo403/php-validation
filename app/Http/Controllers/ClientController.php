<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        // Filtros dinâmicos
        foreach ($request->all() as $field => $value) {
            if (in_array($field, ['name','email','is_active']) && $value !== null) {
                $query->where($field, 'like', "%$value%");
            }
        }

        // Ordenação
        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->get('sort'), $request->get('direction'));
        }

        $clients = $query->paginate(20);
        return view('clients.index', compact('clients'));
    }

    public function create() {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:clients,email',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function edit(Client $client) {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:clients,email,' . $client->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->all();
        if (!$request->password) {
            unset($data['password']);
        }

        $client->update($data);
        return redirect()->route('clients.index')->with('success', 'Cliente atualizado!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente removido!');
    }
}
