<?php

namespace App\TestService;

class TestService {
    private readonly string $message;
    private readonly array $data;

    public function __construct(string $message, array $data)
    {
        $this->message = $message;
        $this->data = $data;
    }

    public function say()
    {
        return $this->message;
    }

    public function getData()
    {
        return $this->data;
    }
}