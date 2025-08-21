<?php

namespace Tests\Unit;

use App\DTOs\ClientDTO;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ClientRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ClientRepository(new Client());
    }

    public function test_can_create_client(): void
    {
        $clientDTO = new ClientDTO(
            name: 'João Silva',
            email: 'joao@example.com',
            phone: '(11) 99999-9999',
            cpf: '123.456.789-01',
            birth_date: '1990-01-01',
            address: 'Rua A, 123',
            city: 'São Paulo',
            state: 'SP',
            zip_code: '01234-567',
            password: 'password123'
        );

        $client = $this->repository->create($clientDTO);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('João Silva', $client->name);
        $this->assertEquals('joao@example.com', $client->email);
    }

    public function test_can_find_client_by_id(): void
    {
        $client = Client::factory()->create();

        $foundClient = $this->repository->findById($client->id);

        $this->assertNotNull($foundClient);
        $this->assertEquals($client->id, $foundClient->id);
    }

    public function test_can_update_client(): void
    {
        $client = Client::factory()->create(['name' => 'Nome Original']);

        $clientDTO = new ClientDTO(
            name: 'Nome Atualizado',
            email: $client->email,
            phone: $client->phone,
            cpf: $client->cpf,
            birth_date: $client->birth_date->format('Y-m-d'),
            address: $client->address,
            city: $client->city,
            state: $client->state,
            zip_code: $client->zip_code
        );

        $updatedClient = $this->repository->update($client->id, $clientDTO);

        $this->assertEquals('Nome Atualizado', $updatedClient->name);
    }

    public function test_can_delete_client(): void
    {
        $client = Client::factory()->create();

        $result = $this->repository->delete($client->id);

        $this->assertTrue($result);
        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    public function test_can_toggle_client_status(): void
    {
        $client = Client::factory()->create(['is_active' => true]);

        $updatedClient = $this->repository->toggleStatus($client->id);

        $this->assertFalse($updatedClient->is_active);
    }
}
