<?php

namespace App\Services;

use App\Enums\MethodEnum;
use App\Enums\SendAsEnum;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class ApiService
{
    protected readonly string $endpoint;

    /** @throws RequestException */
    public function post(string $path, SendAsEnum $as = SendAsEnum::Json, array $body = [], array $headers = []): Response
    {
        return $this->request(MethodEnum::Post->value, $path, $as->value, $body, $headers);
    }

    /** @throws RequestException */
    public function get(string $path, SendAsEnum $as = SendAsEnum::Json, array $query = [], array $headers = []): Response
    {
        return $this->request(MethodEnum::Get->value, $path, $as->value, $query, $headers);
    }

    /** @throws RequestException */
    public function put(string $path, SendAsEnum $as = SendAsEnum::Json, array $body = [], array $headers = []): Response
    {
        return $this->request(MethodEnum::Put->value, $path, $as->value, $body, $headers);
    }

    /** @throws RequestException */
    public function delete(string $path, SendAsEnum $as = SendAsEnum::Json, array $body = [], array $headers = []): Response
    {
        return $this->request(MethodEnum::Delete->value, $path, $as->value, $body, $headers);
    }

    /** @throws RequestException */
    private function request(string $method, string $path, string $as, array $data = [], array $headers = []): Response
    {
        return Http::acceptJson()
            ->withHeaders(['Authorization' => 'Bearer ' . request()->cookie('jwt')] + $headers)
            ->$as()
            ->$method("$this->endpoint/$path", $data)
            ->throw();
    }
}
