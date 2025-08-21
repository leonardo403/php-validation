<?php

namespace App\DTOs;

class ClientDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $cpf,
        public readonly string $birth_date,
        public readonly ?string $address,
        public readonly string $city,
        public readonly string $state,
        public readonly string $zip_code,
        public readonly bool $is_active = true,
        public readonly ?string $password = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            cpf: $data['cpf'],
            birth_date: $data['birth_date'],
            address: $data['address'] ?? null,
            city: $data['city'],
            state: $data['state'],
            zip_code: $data['zip_code'],
            is_active: $data['is_active'] ?? true,
            password: $data['password'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cpf' => $this->cpf,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'is_active' => $this->is_active,
            'password' => $this->password ? bcrypt($this->password) : null,
        ];
    }
}
