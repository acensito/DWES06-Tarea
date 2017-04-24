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
 * Función mostrarRegistro() para mostrar/ocultar el formulario de registro
 */
function mostrarRegistro(){
    //Obtenemos el valor de visibilidad del elemento
    var visibilidad = document.getElementById('registro').className;
    //Si la clase indica que esta oculto, hacemos que sea visible
    if (visibilidad === 'container reg-hidden') {
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
        //Cambiamos el estilo del boton pulsado
        document.getElementById('btn-registro').setAttribute('class', 'btn btn-primary');
        //Cambiamos el texto del boton pulsado a su estado original
        document.getElementById('btn-registro').childNodes[0].nodeValue = 'Crear nuevo usuario';
    }
}

/**
 * Función mostrarRegistro() para mostrar/ocultar el formulario de registro
 */
function mostrarEdicion(){

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
        
        alert("Se ha procedido a eliminar al usuario " + usuario);
    }
}


function registrarUser() {

    var respuesta = xajax.request({xjxfun:"validarUsuario"}, {mode:'synchronous', parameters: [xajax.getFormValues("form-registro")]});
    
    if (respuesta) {
        alert('Se ha creado el nuevo usuario. Puede verlo disponible en la tabla de usuarios');
        mostrarRegistro();
    }
}


function eliminaMsgValidacion(){
    document.getElementById("errorLogin").innerHTML = "";
    document.getElementById("errorPass2").innerHTML = "";
    document.getElementById("errorMail").innerHTML = "";
}

function mostrarEdicion(login){
    var respuesta = xajax_editarUsuario(login);
}
