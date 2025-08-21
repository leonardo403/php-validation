<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\UseCases\CreateClientUseCase;
use App\UseCases\UpdateClientUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private CreateClientUseCase $createClientUseCase,
        private UpdateClientUseCase $updateClientUseCase
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 20), 100);
        $filters = $request->only(['search', 'is_active', 'sort_by', 'sort_direction']);

        $clients = $this->clientRepository->findAll($filters, $perPage);

        return response()->json($clients);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        try {
            $client = $this->createClientUseCase->execute($request->validated());
            return response()->json($client, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function show(int $id): JsonResponse
    {
        $client = $this->clientRepository->findById($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        return response()->json($client);
    }

    public function update(UpdateClientRequest $request, int $id): JsonResponse
    {
        try {
            $client = $this->updateClientUseCase->execute($id, $request->validated());
            return response()->json($client);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->clientRepository->delete($id);

            if (!$deleted) {
                return response()->json(['message' => 'Cliente não encontrado'], 404);
            }

            return response()->json(['message' => 'Cliente excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir cliente'], 500);
        }
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:clients,id'
        ]);

        try {
            $deletedCount = $this->clientRepository->bulkDelete($request->ids);
            return response()->json(['message' => "{$deletedCount} clientes excluídos com sucesso"]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir clientes'], 500);
        }
    }

    public function toggleStatus(int $id): JsonResponse
    {
        try {
            $client = $this->clientRepository->toggleStatus($id);
            return response()->json($client);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }
    }
}
