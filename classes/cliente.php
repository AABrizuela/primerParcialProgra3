<?php

class Cliente
{
    public $email;
    public $clave;

    public function __construct($email, $clave)
    {
        $this->email = $email;
        $this->clave = $clave;
    }
}

?>