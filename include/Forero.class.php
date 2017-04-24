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

/**
 * Description of Forero
 *
 * @author felipon
 */
class Forero {
    protected $login;
    protected $password;
    protected $email;
    protected $bloqueado;
    
    function __construct($row) {
        $this->login = $row['login'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->bloqueado = $row['bloqueado'];
    }

    //GETTERS Y SETTERS
    //*****************
    
    function getLogin() {
        return $this->login;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getBloqueado() {
        if ($this->bloqueado == true) {
            $devuelve = "Si";
        } else {
            $devuelve = "No";
        }
        return $devuelve;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }

    /**
     * Método al que se le pasa el valor de un campo formulario e indica si el 
     * campo esta vacio(true) o lleno(false).
     * 
     * @param  string $campo
     * @return boolean
     */
    public static function comprueba_campo_vacio($campo){
        $comprobacion = empty($campo) ? true:false;
        return $comprobacion;
    }
    
    /**
     * Metodo generico para comprobar el tamaño de un campo pasandole como un
     * parametro el tamaño máximo que puede tener dicho campo. Retornará false
     * si esta validado y true en el caso de no cumplir requisitos
     * 
     * @param  string $campo a comprobar
     * @param  int $tam_max tamaño máximo que puede tener
     * @return boolean resultado verdader/falso
     */
    public static function longitud_campo($campo, $tam_max){
        return strlen($campo) > $tam_max ? true:false;
    }

}
