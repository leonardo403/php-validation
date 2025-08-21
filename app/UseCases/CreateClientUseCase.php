<?php
// app/UseCases/CreateClientUseCase.php
namespace App\UseCases;

use App\DTOs\ClientDTO;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Services\RecaptchaService;
use Illuminate\Validation\ValidationException;

class CreateClientUseCase
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private RecaptchaService $recaptchaService
    ) {}

    public function execute(array $data): Client
    {
        // Verificar reCAPTCHA
        if (!$this->recaptchaService->verify($data['recaptcha_token'])) {
            throw ValidationException::withMessages([
                'recaptcha' => ['Verificação reCAPTCHA falhou.']
            ]);
        }

        // Verificar duplicidade
        if ($this->clientRepository->existsByEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => ['Este email já está cadastrado.']
            ]);
        }

        if ($this->clientRepository->existsByCpf($data['cpf'])) {
            throw ValidationException::withMessages([
                'cpf' => ['Este CPF já está cadastrado.']
            ]);
        }

        $clientDTO = ClientDTO::fromArray($data);
        return $this->clientRepository->create($clientDTO);
    }
}
