<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

abstract class ApiService
{
    protected readonly string $endpoint;

    public function post(string $path, array $data)
    {
        return Http::post("$this->endpoint/$path", $data)->json();
    }
}
