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

    public static function MarcaDeAgua($rutaBase, $rutaMarca, $rutaSalida, $margenX, $margenY, $opacidad)
    {
        $base  = imagecreatefromjpeg($rutaBase);
        $marca = imagecreatefrompng($rutaMarca);

        $Iax = imagesx($base);
        $Iay = imagesy($base);

        $marca=imagescale($marca, $Iax/4, $Iay/4);

        $ax = imagesx($marca);
        $ay = imagesy($marca);

        if(file_exists($rutaBase) && file_exists($rutaMarca))
        {
            if($opacidad < 0 || $opacidad > 100)
            {
                $opacidad = 0;
            }
            imagecopymerge($base,$marca,imagesx($base)-$ax-$margenX,imagesy($base)-$ay-$margenY,0,0,$ax,$ay,$opacidad);
            imagepng($base,$rutaSalida);
            imagedestroy($base);
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>