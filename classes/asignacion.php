<?php

class Asignacion
{
    public $legajo;
    public $idMateria;
    public $turno;    

    public function __construct($legajo, $idMateria, $turno)
    {
        $this->legajo = $legajo;
        $this->idMateria = $idMateria;
        $this->turno = $legajo;
    }
}

?>