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

//Incluimos las librerias necesarias
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
        $resultado .= '<tr><td colspan="5">No existen usuarios registrados</td></tr></table>';
    }
    //Se asigna a la respuesta el lugar que debe ocupar
    $respuesta->assign("usuarios", "innerHTML", $resultado);
    //Se devuelve el resultado
    return $respuesta;
}

/**
 * Función eliminarUsuario, que recibe como parametro un usuario de la tabla y procede 
 * a eliminarlo de la base de datos. Posteriormente devuelve la tabla de usuarios 
 * actualizada.
 * 
 * @param type $usuario
 * @return type
 */
function eliminarUsuario($usuario){
    //Llamada a la clase DB para eliminar un forero pasado
    DB::eliminarForero($usuario);
    //Devolvemos la tabla de usuarios actualizada
    return tablaUsuarios();
}


/* SUBFUNCIONES DE VALIDACION DE DATOS */
/***************************************/
/* Fork de la validación deL ejemplo del tema */
/**********************************************/

/**
 * Función validarLogin, valida la longitud del login de usuario
 * 
 * @param type $login string con el login
 * @return type boolean
 */
function validarLogin($login){
    //Si la longitud es menor de 4 caracteres
    if (strlen($login) < 4) {
        //Devolvemos falso
        return false;
    }else{
        //Devolvemos true (valido)
        return true;
    }
}

/**
 * Funcion validarEmail, valida si lo introducido corresponde a un email
 * 
 * @param type $email string con el email
 * @return type booleano si es valido o no como email
 */
function validarEmail($email){
    return preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email);
}

/**
 * Funcion validarPasswords, que compara si los passwords son iguales y si el
 * tamaño de los mismos supera los 5 caracteres de longitud
 * 
 * @param type $pass1 string con la pass1
 * @param type $pass2 string con las pass2
 * @return type boolean si se encuentra validado
 */
function validarPasswords($pass1, $pass2) {
    //Devuelve si las pass coinciden y la longitud supera los 5 caracteres
    return $pass1 == $pass2 && strlen($pass1) > 5;
}

/**
 * Funcion validarExiste que comprueba en base de datos un usuario pasado por 
 * parametro
 * 
 * @param type $login string con el login a comprobar
 * @return type boolean que indica si esta validado o no
 */
function validarExiste($login) {
    return DB::devuelveUsuario($login);
}

/**
 * Funcion validarUsuario, que mediante las subfunciones anteriores valida el 
 * usuario a registrar
 * 
 * @param type $valores array con los valores a validar
 * @return \xajaxResponse
 */
function validarUsuario($valores) {
    //Instanciamos una respuesta xajax
    $respuesta = new xajaxResponse();
    //Iniciamos un flag de control como false (sin errores)
    $error = false;
    
    //Comprobamos previamente si existe el usuario en base de datos
    if (validarExiste($valores['login'])) {
        //En caso negativo, indicamos este hecho en los mensajes de feedback
        //Activamos el campo para que sea visible
        $respuesta->assign("errorLogin2", "className", "text-danger small show");
        //Asignamos el mensaje correspondiente
        $respuesta->assign("errorLogin2", "innerHTML", "Ya existe dicho usuario");
        //Marcamos el flag como que ha existido un error
        $error = true;
    }else{
        //Limpiamos un posible mensaje de error previo de login si se valida
        $respuesta->clear("errorLogin2", "innerHTML");
    }
    //Comprobamos si el login es valido
    if (!validarLogin($valores['login'])) {
        //En caso negativo, indicamos este hecho en los mensajes de feedback
        //Activamos el campo para que sea visible
        $respuesta->assign("errorLogin", "className", "text-danger small show");
        //Asignamos el mensaje correspondiente
        $respuesta->assign("errorLogin", "innerHTML", "El nombre debe tener más de 3 caracteres.");
        //Marcamos el flag como que ha existido un error
        $error = true;
    }else{
        //Limpiamos un posible mensaje de error previo de login si se valida
        $respuesta->clear("errorLogin", "innerHTML");
    }

    //Comprobamos las passwords son validas
    if (!validarPasswords($valores['pass1'], $valores['pass2'])) {
        //En caso negativo, indicamos este hecho en los mensajes de feedback
        //Activamos el campo para que sea visible
        $respuesta->assign("errorPass2", "className", "text-danger small show");
        //Asignamos el mensaje correspondiente
        $respuesta->assign("errorPass2", "innerHTML", "La contraseña debe ser mayor de 5 caracteres o no coinciden.");
        //Marcamos el flag como que ha existido un error
        $error = true;
    }else{
        //Limpiamos un posible mensaje de error previo de passwords
        $respuesta->clear("errorPass2", "innerHTML");
    }

    //Comprobamos el email
    if (!validarEmail($valores['email'])) {
        //En caso negativo, indicamos este hecho en los mensajes de feedback
        //Activamos el campo para que sea visible
        $respuesta->assign("errorMail", "className", "text-danger small");
        //Asignamos el mensaje correspondiente
        $respuesta->assign("errorMail", "innerHTML", "La dirección de email no es válida.");
        //Marcamos el flag como que ha existido un error
        $error = true;
    }else{
        //Limpiamos un posible mensaje de error previo de email
        $respuesta->clear("errorMail", "innerHTML");
    }

    //En el caso de llegar a este punto y no estar el flag marcado como true,
    //quiere decir que esta todo correcto y validado, por lo que procedemos a la
    //grabación en BD del usuario
    if (!$error) {
        //Llamamos al metodo de la DB
        DB::insertarUsuario($valores);
        //Establecemos como respuesta la tabla actualizada
        $respuesta->setReturnValue(tablaUsuarios());
    }
    
    //Devolvemos los resultados
    return $respuesta;    
}

/**
 * Funcion editarUsuario, que obtiene los datos de un usuario pasado por parametro
 * y los devuelve al formulario de edicion
 * 
 * @param type $login
 * @return \xajaxResponse
 */
function editarUsuario($login){
    //Instanciamos una respuesta xajax
    $respuesta = new xajaxResponse();
    
    //Obtenemos el array de datos del la base de datos
    $valores = DB::devuelveUsuario($login);
    
    //Vamos asignando los diferentes valores de los campos del formulario
    //Valor del login (Campo a editar)
    $respuesta->assign("loginE", "value", $valores['login']);
    //Valor del login (El campo hidden, para saber que usuario estamos editando
    //por si queremos cambiar el nombre del usuario
    $respuesta->assign("loginM", "value", $valores['login']);
    //Valor del email (Campo a editar)
    $respuesta->assign("emailE", "value", $valores['email']);
    //Valor del bloqueado (Campo a editar)
    $respuesta->assign("bloqueadoE", "value", $valores['bloqueado']);
    
    //No se ha incluido los passwords dado que se devolverian encriptados y se
    //considera que ofreceria unicamente problemas. Se podria dar como una 
    //solucion a ello que si el campo estuviera vacio, cambiara la sentencia SQL
    //y no actualizara dichos datos. 

    return $respuesta;
}

/**
 * Funcion validarEdicion, que valida una vez los campos han sido editados y se 
 * procede a guardar al usuario nuevamente en la BD. Recibe un array con los datos
 * del formulario a validar.
 * 
 * @param type $usuario
 * @return \xajaxResponse
 */
function validarEdicion($usuario) {
    //Instanciamos una respuesta xajax
    $respuesta = new xajaxResponse();
    
    //Obtenemos el usuario recogido en el formulario (El que se Edita)
    $loginAct = $usuario['loginE'];
    //Obtenemos el usuario recogido en el campo hidden (El usuario que se va a editar)
    $loginMod = $usuario['loginM'];
    //Establecemos un flag de control
    $error = false;
    
    //Comprobamos previamente si el login que se va a guardar sigue siendo el 
    //mismo que se esta editando. Si se ha modificado quiere decir que son 
    //diferentes, quiere decir que modificamos el nombre de login del
    //usuario, por lo que tenemos que comprobar que no existe otro en BD.
    if ($loginAct != $loginMod){
        //Comprobamos que no existe el login nuevo en BD
        $resultado = validarExiste($loginAct);
        
        //Si existe, lanzamos mensaje de error
        if ($resultado) {
            //En caso negativo, indicamos este hecho en los mensajes de feedback
            //Activamos el campo para que sea visible
            $respuesta->assign("errorLogin2E", "className", "text-danger small");
            //Asignamos el mensaje correspondiente
            $respuesta->assign("errorLogin2E", "innerHTML", "Ya existe un usuario con este login");
            //Marcamos el flag como que ha existido un error
            $error = true;
        } else {
            //En caso contrario, eliminamos posible mensaje de validacion previo  
            $respuesta->clear("errorLogin2E", "innerHTML");
        }
    }
    
    //En este caso no se comprueba si existe en base de datos, porque se entiende
    //que el usuario ya existe, por lo que o lo actualizamos o lo modificamos.
    
    //Comprobamos la validez del login
    if (!validarLogin($usuario['loginE'])) {
        //En caso negativo, indicamos este hecho en los mensajes de feedback
        //Activamos el mensaje correspondiente
        $respuesta->assign("errorLoginE", "className", "text-danger small show");
        //Asignamos el mensaje correspondiente
        $respuesta->assign("errorLoginE", "innerHTML", "El nombre debe tener más de 3 caracteres.");
        //Marcamos el flag como que ha existido un error
        $error = true;
    }else{
        //En caso contrario, eliminamos posible mensaje de validacion previo
        $respuesta->clear("errorLoginE", "innerHTML");
    }

    //Comprobamos la validez del password introducido
    if (!validarPasswords($usuario['pass1E'], $usuario['pass2E'])) {
        //En caso negativo, indicamos este hecho en los mensajes de feedback
        //Activamos el mensaje correspondiente
        $respuesta->assign("errorPass2E", "className", "text-danger small show");
        //Asignamos el mensaje correspondiente
        $respuesta->assign("errorPass2E", "innerHTML", "La contraseña debe ser mayor de 5 caracteres o no coinciden.");
        //Marcamos el flag como que ha existido un error
        $error = true;
    }else{
        //En caso contrario, eliminamos posible mensaje de validacion previo
        $respuesta->clear("errorPass2E", "innerHTML");
    }

    //Comprobamos la validez del email
    if (!validarEmail($usuario['emailE'])) {
        //En caso negativo, indicamos este hecho en los mensajes de feedback
        //Activamos el mensaje correspondiente
        $respuesta->assign("errorMailE", "className", "text-danger small");
        //Asignamos el mensaje correspondiente
        $respuesta->assign("errorMailE", "innerHTML", "La dirección de email no es válida.");
        //Marcamos el flag como que ha existido un error
        $error = true;
    }else{
        //En caso contrario, eliminamos posible mensaje de validacion previo
        $respuesta->clear("errorMailE", "innerHTML");
    }

    //En el caso de llegar a este punto y no estar el flag marcado como true,
    //quiere decir que esta todo correcto y validado, por lo que procedemos a la
    //grabación en BD del usuario
    if (!$error) {
        //Llamamos al metodo de la clase DB
        DB::actualizarUsuario($usuario);
        //Establecemos como respuesta la tabla actualizada
        $respuesta->setReturnValue(tablaUsuarios());
    }
    
    //Devolvemos los resultados
    return $respuesta;
        
}

//Instanciamos un nuevo objeto xajax
$xajax = new xajax();
//Definimos las funciones xajax existentes
$xajax->register(XAJAX_FUNCTION,"tablaUsuarios");
$xajax->register(XAJAX_FUNCTION,"eliminarUsuario");
$xajax->register(XAJAX_FUNCTION,"validarUsuario");
$xajax->register(XAJAX_FUNCTION,"editarUsuario");
$xajax->register(XAJAX_FUNCTION,"validarEdicion");
//Configuramos la ruta de xajax_js con los archivos necesarios
$xajax->configure('javascript URI','include');
//Activamos el modo debug (si se desea)
//$xajax->configure('debug', true);
//Indicamos que se procesen todas las peticiones que lleguen
$xajax->processRequest();


