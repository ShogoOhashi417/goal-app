<?php

namespace App\TestService;

class TestService {
    private static $singlton;

    private int $id;
    private readonly string $message;
    private readonly array $data;

    private function __construct()
    {
        $this->message = 'Hello! This is MyService';
        $this->data = ['Hello', 'Welcome', 'Bye'];
    }

    public static function create()
    {
        if (isset(self::$singlton)) {
            return self::$singlton;
        }

        return new self();
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