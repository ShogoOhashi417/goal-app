<?php

namespace App\TestService;

class TestService {
    private int $id;
    private readonly string $message;
    private readonly array $data;

    public function __construct($id)
    {
        $this->id = $id;
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