<?php

namespace App\TestService;

class TestService implements TestServiceInterface {
    private int $id;
    private readonly string $message;
    private readonly array $data;

    public function __construct()
    {
        $this->message = 'Hello! This is MyService';
        $this->data = ['Hello', 'Welcome', 'Bye'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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