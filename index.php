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

require_once ("include/fxajax.inc.php");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>DWES - Tarea 6 - Aplicaciones web dinámicas: PHP y Javascript </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <link type="text/css" href="css/estilos.css" rel="stylesheet" />

    <?php
    //Indicamos a xajax que incluya el código JavaScript necesario
    $xajax->printJavascript(); 
    ?>
    <script type="text/javascript" src="include/funciones.js"></script>
</head>

<body>
    <h1>DWES - Tarea 06</h1> 
    
    <button id="btn-registro" type="button" class="btn btn-primary" onclick="mostrarRegistro();">Crear nuevo usuario</button>
    
    <div id="registro" class="container reg-hidden" >
        <h2>Registrar usuario</h2>
        <form id="form-registro" role="form" action="javascript:void(null);" onsubmit="registrarUser();">
            <div class="form-group">
                <input type="text" id="login" name="login" class="form-control" maxlength="20" placeholder="Nombre de usuario">
                <span id="errorLogin" class="text-danger small"></span>
                <span id="errorLogin2" class="text-danger small"></span>
            </div>
            <div class="form-group">
                <input type="password" id="pass1" name="pass1" class="form-control" maxlength="128" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" id="pass2" name="pass2" class="form-control" maxlength="128" placeholder="Repita password">
                <span id="errorPass2" class="text-danger small"></span>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" class="form-control" maxlength="50" placeholder="Correo electrónico">
                <span id="errorMail" class="text-danger small"></span>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-warning" type=reset onclick="eliminaMsgValidacion()">Limpiar campos</button>
                <button class="btn btn-primary" type="submit">Registrar</button>
            </div>
        </form>
    </div>
    
    <div id="modificar" class="container reg-hidden" >
        <h2>Editar usuario</h2>
        <form id="form-editar" role="form" action="javascript:void(null);" onsubmit="guardaUser();">
            <div class="form-group">
                <input type="text" id="loginE" name="loginE" class="form-control" maxlength="20" placeholder="Nombre de usuario">
                <span id="errorLoginE" class="text-danger small"></span>
                <span id="errorLogin2E" class="text-danger small"></span>
            </div>
            <div class="form-group">
                <input type="password" id="pass1E" name="pass1E" class="form-control" maxlength="128" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" id="pass2E" name="pass2E" class="form-control" maxlength="128" placeholder="Repita password">
                <span id="errorPass2E" class="text-danger small"></span>
            </div>
            <div class="form-group">
                <input type="email" id="emailE" name="emailE" class="form-control" maxlength="50" placeholder="Correo electrónico">
                <span id="errorMailE" class="text-danger small"></span>
            </div>
            <div class="form-group">
              <label for="sel1">Bloqueado:</label>
              <select class="form-control" id="bloqueadoE" name="bloqueadoE">
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="form-group text-center">
                <input id="loginM" name="loginM" type="hidden">
                <button id="guardar" class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" onclick="ocultarEdicion();">Cancelar</button>
            </div>
        </form>
    </div>
    
    <div id="usuarios"><script type="text/javascript">renderizaUsuarios();</script></div>

    <footer>DWES - Tarea 6 - Felipe Rodríguez Gutiérrez - 2016/2017</footer>
</body>

</html>
