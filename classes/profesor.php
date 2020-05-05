<?php

class Profesor
{
    public $nombre;
    public $legajo;
    public $foto;

    public function __construct($nombre, $legajo, $foto)
    {
        $this->nombre = $nombre;
        $this->legajo = $legajo;
        $this->foto = $foto;
    }
}

?>