<?php

namespace App\Repositories\Contracts;

use App\DTOs\ClientDTO;
use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
    public function findAll(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function findById(int $id): ?Client;
    public function create(ClientDTO $clientDTO): Client;
    public function update(int $id, ClientDTO $clientDTO): Client;
    public function delete(int $id): bool;
    public function bulkDelete(array $ids): int;
    public function toggleStatus(int $id): Client;
    public function existsByEmail(string $email, ?int $excludeId = null): bool;
    public function existsByCpf(string $cpf, ?int $excludeId = null): bool;
}
