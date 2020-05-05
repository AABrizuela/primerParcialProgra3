<?php
require_once "classes/cliente.php";
require_once "classes/login.php";
require_once "classes/materia.php";
require_once "classes/profesor.php";
require_once "classes/asignacion.php";
require_once "lib/io.php";

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];
$array = array();
$key = "pro3-parcial";
switch($path)
{
    case '/usuario';
        switch($method)
        {
            case 'POST':
                $email = $_POST['email'];
                $clave = $_POST['clave'];                
                if(isset($email) && isset($clave))
                {
                    if(!empty($email) && !empty($clave))
                    {
                        $cliente = new Cliente($email, $clave);
                        $array = Io::LeerCosas("data/users.json");
                        if($array == false)
                        {
                            $array = array();
                            array_push($array, $cliente);
                        
                            $array = Io::cargarUno($array, "data/users.json");
                            if($array != false)
                            {
                                echo "Usuario cargado con exito.";
                            }                            
                        }
                        else
                        {
                            $array = Io::cargarVariosEmail($cliente, "data/users.json");
                            if($array != false)
                            {
                                echo "Usuario cargado con exito.";    
                            }                            
                        }
                    }
                    else
                    {
                        echo "Faltan Datos";
                    }
                }
                else
                {
                    echo "Faltan Datos";
                }
            break;

            default:
            echo "Metodo no soportado";
            break;
        }
    break;

    case '/login';
        switch($method)
        {            
            case 'POST':
                $email = $_POST['email'];
                $clave = $_POST['clave'];

                if(isset($email) && isset($clave))
                {
                    if(!empty($email) && !empty($clave))
                    {
                        $_SESSION['Usuario'] = Auth::login($_POST['email'],$_POST['clave'],$key);
                        
                        if(!$_SESSION['Usuario'])
                        {
                            echo "Email o Clave Incorrectos";
                        }
                        else
                        {
                            print_r($_SESSION['Usuario']);
                        }
                    }
                    else
                    {
                        echo "Debe cargar Email y Clave para ingresar";
                    }
                } 
                else 
                {
                    echo "Debe cargar Email y Clave para ingresar";
                }
            break;

            default:
            echo "Metodo no soportado";
            break;
        }
    break;

    case '/materia';
        switch($method)
        {
            case 'POST':
                $nombre = $_POST['nombre'];
                $cuatrimestre = $_POST['cuatrimestre'];
                $id = rand(0, 100);
                if(isset($nombre) && isset($cuatrimestre))
                {
                    if(!empty($nombre) && !empty($cuatrimestre))
                    {
                        $checkUsr = Auth::decodeJWT($key, "token");

                        if($checkUsr == true)
                        {
                            $materia = new Materia($nombre, $cuatrimestre, $id);
                            $array = Io::LeerCosas("data/materias.json");
                            if($array == false)
                            {
                                $array = array();
                                array_push($array, $materia);
                            
                                $array = Io::cargarUno($array, "data/materias.json");
                                if($array != false)
                                {
                                    echo "Materia cargada con exito.";
                                }                            
                            }
                            else
                            {
                                $array = Io::cargarVariosId($materia, "data/materias.json");
                                if($array != false)
                                {
                                    echo "Materia cargada con exito.";    
                                }                            
                            }
                        }                        
                    }
                    else
                    {
                        echo "Faltan Datos";
                    }
                }
                else
                {
                    echo "Faltan Datos";
                }
            break;

            case 'GET':
                $checkType = Auth::decodeJWT($key, "token");
                
                if($checkType == true)
                {                    
                    $array = Io::LeerCosas("data/materias.json");
                    var_dump($array);
                }
            break;

            default:
            echo "Metodo no soportado";                
            break;
        }
    break;

    case '/profesor';
        switch($method)
        {
            case 'POST':
                $origen = $_FILES['imagen']['tmp_name'];
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $hora = time();
                $nombreConExt = $_FILES['imagen']['name'];
                $nombreSinExt = explode(".", $nombreConExt);                
                $destino = "./imagenes/" . $nombreSinExt[0] . "_" . $hora . "." .$extension;
                $nombre = $_POST['nombre'];
                $legajo = $_POST['legajo'];
                $foto = $destino;
                if(isset($nombre) && isset($legajo) && isset($foto))
                {
                    if(!empty($nombre) && !empty($legajo) && !empty($foto))
                    {
                        $checkUsr = Auth::decodeJWT($key, "token");

                        if($checkUsr == true)
                        {
                            $profesor = new Profesor($nombre, $legajo, $foto);
                            $array = Io::LeerCosas("data/profesores.json");
                            if($array == false)
                            {
                                $array = array();
                                array_push($array, $profesor);
                            
                                $array = Io::cargarUno($array, "data/profesores.json");
                                move_uploaded_file($origen, $destino);
                                if($array != false)
                                {
                                    echo "Profesor cargado con exito.";
                                }                            
                            }
                            else
                            {
                                $array = Io::cargarVariosLegajo($profesor, "data/profesores.json");
                                move_uploaded_file($origen, $destino);
                                if($array != false)
                                {
                                    echo "Profesor cargado con exito.";    
                                }                            
                            }
                        }                                                
                    }
                    else
                    {
                        echo "Faltan Datos";
                    }
                }
                else
                {
                    echo "Faltan Datos";
                }
            break;

            case 'GET':
                $checkType = Auth::decodeJWT($key, "token");
                
                if($checkType == true)
                {                    
                    $array = Io::LeerCosas("data/profesores.json");
                    var_dump($array);
                }
            break;

            default:
            echo "Metodo no soportado";
            break;
        }
    break;

    case '/asignacion';
    switch($method)
    {
        case 'POST':
            $legajoProf = $_POST['legajo'];
            $idMateria = $_POST['id'];
            $turno = $_POST['turno'];
            if(isset($idMateria) && isset($legajoProf) && isset($turno))
            {
                if(!empty($idMateria) && !empty($legajoProf) && !empty($turno))
                {
                    $checkUsr = Auth::decodeJWT($key, "token");

                    if($checkUsr == true)
                    {
                        $asignacion = new Asignacion($legajoProf, $idMateria, $turno);
                        //$arrayMateria = Io::LeerCosas("data/materia.json");
                        //$arrayProfesor = Io::LeerCosas("data/profesor.json");
                        $array = Io::LeerCosas("data/materias-profesores.json");
                        $repetido = false;
                        if($array == false)
                        {
                            $array = array();
                            array_push($array, $asignacion);
                        
                            $array = Io::cargarUno($array, "data/materias-profesores.json");                            
                            if($array != false)
                            {
                                echo "Profesor cargado con exito.";
                            }                            
                        }
                        else
                        {
                            foreach($array as $item)
                            {
                                if($item->legajo == $legajoProf && $item->idMateria == $idMateria)
                                {
                                    $repetido = true;
                                    break;
                                }
                            }
                            if($repetido == false)
                            {
                                $array = Io::cargarVariosLegajo($asignacion, "data/materias-profesores.json");
                                if($array != false)
                                {
                                    echo "Profesor cargado con exito.";    
                                }
                            }
                            else
                            {
                                echo "Error.";
                            }
                        }
                    }                                                
                }
                else
                {
                    echo "Faltan Datos";
                }
            }
            else
            {
                echo "Faltan Datos";
            }
        break;

        case 'GET':
            $checkType = Auth::decodeJWT($key, "token");
            
            if($checkType == true)
            {                    
                $array = Io::LeerCosas("data/materias-profesores.json");
                print_r($array);
            }
        break;

        default:
        echo "Metodo no soportado";
        break;
    }
    break;

    default:
        echo "Metodo no soportado";
    break;
}

?>