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

/**
 * Función renderizaUsuarios() que genera la tabla de usuarios del foro
 */
function renderizaUsuarios(){
    xajax_tablaUsuarios();
}

/**
 * Función a la que se le indica un usuario en concreto y que tras la confirmación
 * del eliminado del mismo, procede a ello.
 * 
 * @param {type} usuario nombre del usuario a eliminar
 */
function eliminaUser(usuario){
    //Preguntamos si desea realmente eliminar a dicho usuario y si es positivo,
    //procedemos a eliminar el mismo llamando a la función correspondiente.
    if (confirm('¿Desea eliminar al forero ' + usuario + '?')) {
        //Llamamos a la funcion correspondiente para eliminar usuario
        xajax_eliminarUsuario(usuario);
        //Mandamos mensaje de feedback
        alert("Se ha procedido a eliminar al usuario " + usuario);
    }
}

/**
 * Funcion que recoge los datos del formulario de registro y los envia para que
 * sean validados y actualiza la tabla
 * 
 */
function registrarUser() {
    //Se solicita una respuesta sincrona con el servidor, enviando como parametros
    //los datos del formulario
    var respuesta = xajax.request({xjxfun:"validarUsuario"}, {mode:'synchronous', parameters: [xajax.getFormValues("form-registro")]});
    
    //Si la respuesta es positiva (se ha grabado bien)
    if (respuesta) {
        //Lanzamos mensaje de feedback
        alert('Se ha creado el nuevo usuario. Puede verlo disponible en la tabla de usuarios');
        //Ocultamos el formulario de registro
        mostrarRegistro();
    }
    //Actualizamos la tabla de usuarios para que puedan verse los cambios
    renderizaUsuarios();
}

/**
 * Función mostrarRegistro() para mostrar/ocultar el formulario de registro
 */
function mostrarRegistro(){
    //Obtenemos el valor de visibilidad del elemento
    var visibilidad = document.getElementById('registro').className;
    //Si la clase indica que esta oculto, hacemos que sea visible
    if (visibilidad === 'container reg-hidden') {
        //Ocultamos el formulario de Editar usuario, por si estuviera activo
        document.getElementById('modificar').setAttribute('class', 'container reg-hidden');
        //Hacemos visible el contenedor
        document.getElementById('registro').setAttribute('class', 'container reg-visible');
        //Cambiamos el estilo del boton pulsado
        document.getElementById('btn-registro').setAttribute('class', 'btn btn-danger');
        //Cambiamos el texto del botón pulsado
        document.getElementById('btn-registro').childNodes[0].nodeValue = 'Cancelar registro';
        //Asignamos el foco en el primer campo del formulario
        document.getElementById('login').focus();
    //Si la clase indica que esta visible, la ocultamos
    } else {
        //Vaciamos el contenido del formulario por si existieran datos previos
        document.getElementById("form-registro").reset();
        //Eliminamos contenido del formulario y mensajes de validacion existentes
        eliminaMsgValidacion();
        //Ocultamos el contenedor
        document.getElementById('registro').setAttribute('class', 'container reg-hidden');
        //Cambiamos el estilo del boton de registro
        document.getElementById('btn-registro').setAttribute('class', 'btn btn-primary');
        //Cambiamos el texto del boton pulsado a su estado original
        document.getElementById('btn-registro').childNodes[0].nodeValue = 'Crear nuevo usuario';
    }
}

/**
 * Función que muestra el formulario de edición del usuario pasado por parametro
 * del que se recuperarán los datos.
 * 
 * @param {type} login
 * @returns {undefined}
 */
function mostrarEdicion(login){
    //Ocultamos el formulario de registro, por si estuviera activo
    document.getElementById('registro').setAttribute('class', 'container reg-hidden');
    //Cambiamos el estilo del boton de registro
    document.getElementById('btn-registro').setAttribute('class', 'btn btn-primary');
    //Cambiamos el texto del boton pulsado a su estado original
    document.getElementById('btn-registro').childNodes[0].nodeValue = 'Crear nuevo usuario';
    //Hacemos visible el contenedor de edicion
    document.getElementById('modificar').setAttribute('class', 'container reg-visible');
    //Asignamos el foco en el primer campo del formulario
    document.getElementById('loginE').focus();
    eliminaMsgEdicion();
    //Recuperamos los datos para asignarlos al formulario
    xajax_editarUsuario(login);
}

/**
 * Funcion que procede al guardado/actualizado del user a modificar cuando se
 * pulsa sobre el boton guardar.
 * 
 */
function guardaUser(){
    //Se solicita una respuesta sincrona con el servidor, al que se le mandan 
    //los datos del formulario para validar
    var respuesta = xajax.request({xjxfun:"validarEdicion"}, {mode:'synchronous', parameters: [xajax.getFormValues("form-editar")]});
    
    //Si la respuesta es correcta (se ha guardado correctamente el usuario) 
    if (respuesta) {
        //Lanzamos mensaje de feedback
        alert('Se ha se ha modificado el usuario. Puede verlo disponible en la tabla de usuarios');
        //ocultamos el formulario de edicion
        ocultarEdicion();
    }
    //Actualizamos la tabla con los datos más actuales
    renderizaUsuarios();
}

/**
 * Función que oculta el formulario de edición de usuario al pulsar en cancelar
 * 
 */
function ocultarEdicion(){
    //Ocultamos el contenedor
    document.getElementById('modificar').setAttribute('class', 'container reg-hidden');
    //Borramos rastros de mensajes de validacion previos
    eliminaMsgEdicion();
}

/**
 * Función que elimina los mensajes de validación (ya sea al pulsar limpiar, al
 * cancelar o proceder con el formulario de registro.
 */
function eliminaMsgValidacion(){
    //Limpiamos el contenido de loe mensajes
    document.getElementById("errorLogin").innerHTML = "";
    document.getElementById("errorLogin2").innerHTML = "";
    document.getElementById("errorPass2").innerHTML = "";
    document.getElementById("errorMail").innerHTML = "";
}

/**
 * Función que elimina los mensajes de validacion (ya sea guardando un registro
 * editado o cancelando la acción).
 */
function eliminaMsgEdicion(){
    //Vaciamos el contenido del formulario por si existieran datos previos
    document.getElementById("form-editar").reset();
    //Limpiamos el contenido de los mensajes
    document.getElementById("errorLoginE").innerHTML = "";
    document.getElementById("errorLogin2E").innerHTML = "";
    document.getElementById("errorPass2E").innerHTML = "";
    document.getElementById("errorMailE").innerHTML = "";
}



