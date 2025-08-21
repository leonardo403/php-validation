<?php

namespace App\Repositories;

use App\DTOs\ClientDTO;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        private Client $model
    ) {}

    public function findAll(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Client
    {
        return $this->model->find($id);
    }

    public function create(ClientDTO $clientDTO): Client
    {
        return $this->model->create($clientDTO->toArray());
    }

    public function update(int $id, ClientDTO $clientDTO): Client
    {
        $client = $this->findById($id);
        $data = $clientDTO->toArray();

        if (!$data['password']) {
            unset($data['password']);
        }

        $client->update($data);
        return $client->fresh();
    }

    public function delete(int $id): bool
    {
        $client = $this->findById($id);
        return $client ? $client->delete() : false;
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function toggleStatus(int $id): Client
    {
        $client = $this->findById($id);
        $client->update(['is_active' => !$client->is_active]);
        return $client->fresh();
    }

    public function existsByEmail(string $email, ?int $excludeId = null): bool
    {
        $query = $this->model->where('email', $email);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function existsByCpf(string $cpf, ?int $excludeId = null): bool
    {
        $query = $this->model->where('cpf', $cpf);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
