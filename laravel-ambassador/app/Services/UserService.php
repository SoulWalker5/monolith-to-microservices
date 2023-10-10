<?php

namespace App\Services;

class UserService extends ApiService
{
    public function __construct(protected readonly string $endpoint)
    {
    }
}
