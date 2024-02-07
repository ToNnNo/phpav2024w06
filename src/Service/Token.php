<?php

namespace App\Service;

class Token
{
    private string $token;

    public function create(string $key): string
    {
        return $this->token = password_hash($key, PASSWORD_BCRYPT);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function isValid(string $key, string $token): bool
    {
        return password_verify($key, $token);
    }
}
