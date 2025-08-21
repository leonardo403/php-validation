<?php

namespace App\UseCases;

use App\DTOs\ClientDTO;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Validation\ValidationException;

class UpdateClientUseCase
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository
    ) {}

    public function execute(int $id, array $data): Client
    {
        // Verificar se o cliente existe
        $client = $this->clientRepository->findById($id);
        if (!$client) {
            throw new \Exception('Cliente não encontrado.');
        }

        // Verificar duplicidade
        if ($this->clientRepository->existsByEmail($data['email'], $id)) {
            throw ValidationException::withMessages([
                'email' => ['Este email já está cadastrado por outro cliente.']
            ]);
        }

        if ($this->clientRepository->existsByCpf($data['cpf'], $id)) {
            throw ValidationException::withMessages([
                'cpf' => ['Este CPF já está cadastrado por outro cliente.']
            ]);
        }

        $clientDTO = ClientDTO::fromArray($data);
        return $this->clientRepository->update($id, $clientDTO);
    }
}
