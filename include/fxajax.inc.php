<?php

/*
 * 2017 Felipe Rodríguez Gutiérrez
 *
 * CODIGO CREADO BAJO LICENCIA CREATIVE COMMONS
 *
 * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa): 
 *
 * No se permite un uso comercial de la obra original ni de las posibles obras 
 * derivadas, la distribución de las cuales se debe hacer con una licencia igual
 * a la que regula la obra original.
 */

/*
 * Módulo: Desarrollo Web Entorno Servidor
 * Tema 06: Aplicaciones web dinámicas: PHP y Javascript 
 * Tarea 6: Foro 3 vol. 3
 * Alumno: Felipe Rodríguez Gutiérrez
 */

require_once 'xajax_core/xajax.inc.php';
require_once 'DB.class.php';
require_once 'Forero.class.php';

/**
 * Función tablaUsuarios, que devuelve una respuesta xajax con la tabal dibujada
 * 
 * @return \xajaxResponse
 */
function tablaUsuarios(){
    //Instanciamos una respuesta xajax
    $respuesta = new xajaxResponse();
    //Comenzamos a incorporar el encabezado de la tabla de resultados
    $resultado = '<h2>Foreros registrados</h2><div class="container users">'
                . '<table class="table table-striped table-bordered">'
                . '<tr><th>Login</th><th>Password</th><th>Email</th><th>Bloqueado</th><th colspan="2">Editar</th></tr>';
    
    //Se obtienen los foreros de la base de datos      
    $usuarios = DB::listadoForeros();
    
    //Si existen usuarios
    if($usuarios){
        //Se listan y se muestran, sumandose como resultado de la tabla
        foreach ($usuarios as $usuario) {
            $resultado .= '<tr><td>'.$usuario->getLogin().'</td>'
                    . '<td>••••••••</td>'
                    . '<td>'.$usuario->getEmail().'</td>'
                    . '<td>'.$usuario->getBloqueado().'</td>'
                    . '<td><button class="btn btn-primary" onclick="mostrarEdicion(\''.$usuario->getLogin().'\')"><i class="fa fa-pencil" aria-hidden="true"></i></button></td>'
                    . '<td><button class="btn btn-danger" onclick="eliminaUser(\''.$usuario->getLogin().'\')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>'; 
        }
        $resultado .= '</table>';
    //En el caso de no existir usuarios, se muestra el resutlado en la tabla
    } else {
        $resultado .= '<tr>No existen usuarios registrados</tr></table>';
    }
    //Se asigna a la respuesta el lugar que debe ocupar
    $respuesta->assign("usuarios", "innerHTML", $resultado);
    //Se devuelve el resultado
    return $respuesta;
}

/**
 * Función eliminarUsuario, que recibe como parametro un usuario de la tabla y procede a eliminarlo de la base de
 * datos. Posteriormente devuelve la tabla de usuarios actualizada.
 * 
 * @param type $usuario
 * @return type
 */
function eliminarUsuario($usuario){
    DB::eliminarForero($usuario);
    
    return tablaUsuarios();
}


/* VALIDACION DE DATOS */
/* Fork de la validación dej ejemplo del tema */

/**
 * Función validarLogin, valida la longitud del login de usuario
 * 
 * @param type $login string con el login
 * @return type boolean
 */
function validarLogin($login){
    if (strlen($login) < 4) {
        return false;
    }else{
        return true;
    }
}

function validarEmail($email){
    return preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email);
}

function validarPasswords($pass1, $pass2) {
    return $pass1 == $pass2 && strlen($pass1) > 5;
}

function validarExiste($login) {
    return DB::devuelveUsuario($login);
}

function validarUsuario($valores) {
    $respuesta = new xajaxResponse();
    $error = false;
    
    if (validarExiste($valores['login'])) {
        $respuesta->assign("errorLogin", "className", "text-danger small show");
        $respuesta->assign("errorLogin", "innerHTML", "Ya existe dicho usuario");
        $error = true;
    }else{
        //Limpiamos un posible mensaje de error previo
        $respuesta->clear("errorLogin", "innerHTML");
        
        if (!validarLogin($valores['login'])) {
            $respuesta->assign("errorLogin", "className", "text-danger small show");
            $respuesta->assign("errorLogin", "innerHTML", "El nombre debe tener más de 3 caracteres.");
            $error = true;
        }else{
            $respuesta->clear("errorLogin", "innerHTML");
        }

        if (!validarPasswords($valores['pass1'], $valores['pass2'])) {
            $respuesta->assign("errorPass2", "className", "text-danger small show");
            $respuesta->assign("errorPass2", "innerHTML", "La contraseña debe ser mayor de 5 caracteres o no coinciden.");
            $error = true;
        }else{
            $respuesta->clear("errorPass2", "innerHTML");
        }

        if (!validarEmail($valores['email'])) {
            $respuesta->assign("errorMail", "className", "text-danger small");
            $respuesta->assign("errorMail", "innerHTML", "La dirección de email no es válida.");
            $error = true;
        }else{
            $respuesta->clear("errorMail", "innerHTML");
        }

        if (!$error) {
            DB::insertarUsuario($valores);
            $respuesta->setReturnValue(tablaUsuarios());
        }
    }
    
    return $respuesta;    
}

//LLAMANDO EDICION DE USUARIO

function editarUsuario($login){
    $respuesta = new xajaxResponse();
    
    $respuesta->setReturnValue(DB::devuelveUsuario($login));
    //IR AQUI ASIGNANDO LOS CAMPOS DEL FORMULARIO, QUE SE DEBE DE ACTIVAR
    
    return $respuesta;
    
}


//Instanciamos un nuevo objeto xajax
$xajax = new xajax();
//Definimos las funciones xajax existentes
$xajax->register(XAJAX_FUNCTION,"tablaUsuarios");
$xajax->register(XAJAX_FUNCTION,"eliminarUsuario");
$xajax->register(XAJAX_FUNCTION,"validarUsuario");
$xajax->register(XAJAX_FUNCTION,"editarUsuario");
//Configuramos la ruta de xajax_js con los archivos necesarios
$xajax->configure('javascript URI','include');
//Activamos el modo debug (si se desea)
$xajax->configure('debug', true);
//Indicamos que se procesen todas las peticiones que lleguen
$xajax->processRequest();


