<?php

namespace App\Model;

class Person
{
    public $firstname;
    public $lastname;

    public function __construct($firstname, $lastname)
    {
        $this->lastname = $lastname;
        $this->firstname = $firstname;
    }

    public static function CreateTestList()
    {
    return [
        new Person('Михаил','Иванов'),
        new Person('Дмитрий','Петров'),
        new Person('Владимир','Жуков')
    ];
    }
}