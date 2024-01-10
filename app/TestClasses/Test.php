<?php
namespace App\TestClasses;

class Test implements TestInterface {

    // public function __construct($id)
    // {
    //     $this->num = rand();
    //     echo $this->num;
    //     $this->id = $id;
    // }

    public function test($id = "指定されていない") {
        echo $id;
    }
}