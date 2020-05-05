<?php

class Io
{
    public static function cargarUno($objeto, $archivo)
    {
        $referenceFile = fopen($archivo, "w");
        $escritura = fwrite($referenceFile, serialize($objeto));

        fclose($referenceFile);        
    }

    public static function cargarVariosEmail($objeto, $archivo)
    {
        $array = array();
        $repetido = false;
        $array = Io::LeerCosas($archivo);

        foreach($array as $items)
        {
            if($items->email == $objeto->email)
            {
                $repetido = true;
                break;
            }
        }

        if($repetido == true)
        {
            $escritura = false;
            echo "Ya existe en el registro.";
        }
        else
        {
            array_push($array, $objeto);
            $referenceFile = fopen($archivo, "w");
            $escritura = fwrite($referenceFile, serialize($array));
            fclose($referenceFile);            
        }

        return $escritura;
    }

    public static function cargarVariosId($objeto, $archivo)
    {
        $array = array();
        $repetido = false;
        $array = Io::LeerCosas($archivo);

        foreach($array as $items)
        {
            if($items->id == $objeto->id)
            {
                $repetido = true;
                break;
            }
        }

        if($repetido == true)
        {
            $escritura = false;
            echo "Ya existe en el registro.";
        }
        else
        {
            array_push($array, $objeto);
            $referenceFile = fopen($archivo, "w");
            $escritura = fwrite($referenceFile, serialize($array));
            fclose($referenceFile);            
        }

        return $escritura;
    }

    public static function cargarVariosLegajo($objeto, $archivo)
    {
        $array = array();
        $repetido = false;
        $array = Io::LeerCosas($archivo);

        foreach($array as $items)
        {
            if($items->legajo == $objeto->legajo)
            {
                $repetido = true;
                break;
            }
        }

        if($repetido == true)
        {
            $escritura = false;
            echo "Ya existe en el registro.";
        }
        else
        {
            array_push($array, $objeto);
            $referenceFile = fopen($archivo, "w");
            $escritura = fwrite($referenceFile, serialize($array));
            fclose($referenceFile);            
        }

        return $escritura;
    }

    public static function LeerCosas($archivo)
    {
        $array = array();
        $referenceFile = fopen($archivo, "r");
        $arrayAux = fgets($referenceFile);

        $array = unserialize($arrayAux);

        fclose($referenceFile);

        return $array;
    }
}

?>