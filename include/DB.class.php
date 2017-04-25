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
 * Description of DB
 *
 * @author felipon
 */
class DB {
    private static $instancia;
    private $con;
    
    /**
     * Constructor de la clase con los datos de conexión a la base de datos
     */
    private function __construct(){
        
        $db_host   = '192.168.0.250';    //  hostname por defecto: localhost/127.0.0.1 - 192.168.0.250 en red
        $db_name   = 'foro3';            //  nombre base datos
        $db_user   = 'dwes';             //  usuario
        $user_pw   = 'dwes';             //  contraseÃ±a

        try {
            $this->con = new PDO('mysql:host='.$db_host.'; dbname='.$db_name, $db_user, $user_pw);
            $this->con->exec("set names utf8");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) { //Se capturan los mensajes de error
            exit("<p class='errcon'>No se ha conectado a la DB. " . $e->getMessage() . "</p>");
            die();
        }
    }
    
    /**
     * Método estático que devuelve la conexión a la base de datos. En caso de
     * no haberse realizado la conexión se instancia el constructor a si mismo.
     * 
     * En el caso de haber sido ya instanciada devuelve el valor de la instancia
     * 
     * @return Objeto
     */
    public static function conexion(){
        if(!isset(self::$instancia)){
            self::$instancia = new DB;
        }
        return self::$instancia;
    }
   
    /**
     * Método que devuelve una consulta preparada
     * 
     * @param  string $sql
     * @return consulta
     */
    public static function prepare($sql){
        return self::$instancia->con->prepare($sql);
    }
    
    /**
     * Método estatico listadoForeros() que devuelve un array de objetos Foreros
     * 
     * @return object Forero
     */
    public static function listadoForeros(){
        try {
            //Creamos una conexión
            self::conexion();
            
            //Preparamos la sentencia SQL
            $sql = 'SELECT login, password, email, bloqueado FROM foreros';
            //Preparamos la consulta
            $resultado = self::$instancia->prepare($sql);
            //Ejecutamos la consulta
            $resultado->execute();
            //Recuperamos las filas
            $row = $resultado->fetch();
            
            //Si existen filas/resultados
            while ($row != null) {
                //Pasamos una fila a un objeto forero y lo insertamos en el array foreros
                $foreros[] = new Forero($row);
                $row = $resultado->fetch();
            }
            
            //Devuelve el listado de objetos foreros si existe y el booleano false si se encuentra vacio
            return !empty($foreros) ? $foreros : false;
        //En caso de existir errores, los capturamos y los mostramos
        } catch (PDOException $e) {
            echo $e->getMessage(); //Se captura el error y se lanza mensaje
        } 
    }
    
    /**
     * Función eliminarForero(), que elimina al forero indicado por parametro de
     * la tabla foreros de la base de datos.
     * 
     * @param type $forero
     */
    public static function eliminarForero($forero){
        try {
            //Creamos una conexión
            self::conexion();
            
            //Creamos la sentencia sql correspondiente
            $sql = 'DELETE FROM foreros WHERE login = :login';
            //Preparamos la consulta
            $row = self::$instancia->prepare($sql);
            //Pasamos los parametros de la consulta
            $row->bindParam(":login", $forero);
            //Ejecutamos la consulta
            $row->execute();
                    
        //En caso de existir errores, los capturamos y los mostramos
        } catch (PDOException $e) {
            echo $e->getMessage(); //Se captura el error y se lanza mensaje
        }
    }
    
    /**
     * Metodo que devuelve si existe un usuario en la base de datos. Devuelve un
     * array con el usuario si existiera. Booleano (false) en caso contrario.
     * 
     * @param  string $user
     * @return array
     */
    public static function devuelveUsuario($user) {
        try {
            //Creamos una conexión
            self::conexion();
            
            //Preparamos la sentencia SQL
            $sql = "SELECT login, password, email, bloqueado FROM foreros WHERE login=:login";
            //Llamamos a la preparacion de la consulta a la funcion correspondiente
            $row = self::$instancia->prepare($sql);
            //Introducimos los correspondientes parametros de la consulta
            $row->bindParam(":login",$user);
            //Ejecutamos la consulta
            $row->execute();
            //Flag de control de usuario. Valor devuelto si no aparecen resultados.
            $usuario = false;

            //Si existe un resultado
            if ($row->rowCount() == 1){
                //Guardamos los resultados para devolver
                $usuario = $row->fetch();
            }
            
            //Devolvemos el resultado
            return $usuario;
            
        //En caso de existir errores, los capturamos y los mostramos
        } catch (PDOException $e) {
            echo $e->getMessage(); //Se captura el error y se lanza mensaje
        }
    }
    
    public static function insertarUsuario($valores) {
        //Encriptamos la contraseña recibida
        $valores['pass1'] = crypt($valores['pass1'], '$1$H0nXwAHv$Db/qca/Yq.hubsry5S7bf1');

        try {
            //Creamos una conexión
            self::conexion();
            
            //Preparamos la sentencia SQL
            $sql = "INSERT INTO foreros (login, password, email, bloqueado) VALUES (?, ?, ?, 1)";
  
            //Preparamos la consulta
            $resultado = self::$instancia->prepare($sql);
            
            //Parámetros de la consulta
            $resultado->bindParam(1, $valores['login']);
            $resultado->bindParam(2, $valores['pass1']);
            $resultado->bindParam(3, $valores['email']);

            //Ejecutamos la consulta, añadimos el usuario
            $resultado->execute();
            
        } catch (PDOException $e) { //En caso de errores
            //Se captura el error y se muestra
            echo "<p class='errcon'>Se ha producido error " . $e->getMessage() . "</p>";
        }
    }
    
    public static function actualizarUsuario($valores){
        //Encriptamos la contraseña recibida
        $password = crypt($valores['pass1E'], '$1$H0nXwAHv$Db/qca/Yq.hubsry5S7bf1');
        
        try {
            //Creamos una conexión
            self::conexion();
            
            //Preparamos la sentencia SQL
            $sql = "UPDATE foreros SET login=:login, password=:pass, email=:email, bloqueado=:bloqueado WHERE login=:user";
            
            //Preparamos la consulta
            $resultado = self::$instancia->prepare($sql);
            
            //Parametros de la consulta
            $resultado->bindParam(":login", $valores['loginE']);
            $resultado->bindParam(":pass", $password);
            $resultado->bindParam(":email", $valores['emailE']);
            $resultado->bindParam(":bloqueado", $valores['bloqueadoE']);
            $resultado->bindParam(":user", $valores['loginM']);
            
            //Ejecutamos la consulta, actualizamos el usuario
            $resultado->execute();
            
        } catch (PDOException $e) { //En caso de errores
            //Se captura el error y se muestra
            echo "<p class='errcon'>Se ha producido error " . $e->getMessage() . "</p>";
        }
    }
    
    /**
     * Método que evita que por seguridad el objeto sea clonado
     */
    public function __clone() {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
}
