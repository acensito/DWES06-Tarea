##
#  DWES - Tarea 06

## Enunciado:

Vamos a seguir utilizando para esta tarea la base de datos creada en la tarea 4 (la base de datos tenía el nombre: foro4). El usuario de acceso a la base de datos seguirá siendo &quot;dwes&quot; con contraseña &quot;dwes&quot;.

En la página principal de la aplicación ( **index.php** ) se debe visualizar el contenido de la tabla foreros de la base de datos.

Todas las acciones que se enumeran a continuación deben ser realizadas en esta misma página (independientemente de que se creen otras para funciones, clases, etc). Las funciones javascript deben estar en un fichero llamado  **funciones.js**.

- La página mostrará la consulta de la tabla foreros obteniendo todos los datos de la misma. La lista de foreros se visualizará en una tabla de 6 columnas, una para cada uno de los 4 campos de ésta (login, password, email, bloqueado), una quinta columna que tenga un botón para modificar (botón o imagen) y la sexta para borrar.
- Al pinchar en modificar se deben cargar los datos editables (correspondientes a esa fila) en un formulario que previamente estaba oculto (en la misma página, debajo de la tabla). Al pulsar sobre el botón del formulario se actualizarán los datos de la clase en la base de datos y en la lista, y se ocultará el formulario.
- Al pinchar en eliminar se deberá eliminar la fila seleccionada de la tabla. La eliminación debe realizarse mediante AJAX. Antes de realizar la eliminación completa se pedirá confirmación al usuario mediante una ventana emergente. Una vez realizada la eliminación de un elemento, la tabla deberá actualizarse sin que la página deba recargarse completamente.
- Implementar la opción de insertar nuevos registros (utilizando AJAX) usando un formulario oculto como se solicita con la opción de modificar. Una vez realizada la inserción de un elemento, la tabla deberá actualizarse sin que la página deba recargarse completamente. Recordad que tanto para modificar, como para insertar, previamente debéis validar los campos, mostrando errores en caso de que sea necesario. La contraseña deberá ser de tipo password (\*\*\*\*) y deberá haber un segundo campo de confirmación de contraseña (tal y como hemos visto en anteriores tareas).
- Deberás emplear la clase DB (para los accesos a base de datos) y la clase Forero, tal y como vimos en unidades anteriores.

Las librerías utilizadas para la tarea deben incluirse dentro del propio proyecto, en una carpeta llamada  **include, ** y hacerse referencia a esta ruta ( **Rutas relativas** ).

**NOTA** : No se puede hacer ninguna modificación sobre la estructura de la base de datos ni el usuario de acceso a ésta, de ser así no se corregirá la tarea.

##

## **Criterios de corrección:**

**NOTA\_TOTAL\_TAREA 1 = 0,5\*NOTA\_PARTES1y2 + 0,5\*NOTA\_PARTE3**

| **Puntuación Máxima** | **Criterio** |
| --- | --- |
| Sin calificación | Tarea no entregada. |
| 0 | La tarea entregada no se corresponde con lo que se  pide.El fichero está corrupto o no se puede abrir.La tarea se ha entregado fuera de plazo.La tarea ha sido copiada.No se han usado arrays para desarrollar la tarea. |
| 4 | La tarea se realiza usando bases de datos, Sesiones, Cookies, AJAX, etc que se trabajarán en unidades posteriores.La tarea no se puede ejecutar. |
| 10 | La tarea entregada y que funcione correctamente (que no corresponda a ninguno de los apartados mencionados anteriormente) será corregida según la siguiente valoración: |

** **
|  Se valorará con la puntuación señalada la consecución de cada uno de los siguientes ítems:

| **Clases** | Crear correctamente la clase DB. | 1 |
| --- | --- | --- |
| Crear correctamente la clase Forero. | 0,3 |
| **Tabla** | Correcta visualización de la tabla con los datos de las clases y las opciones de modificar y eliminar. | 1 |
| **Inserción** | Gestión del formulario oculto. Mostrar y ocultar. | 0,5 |
| Validación de campos y visualización de mensajes de error. | 0,5 |
| Actualización de los datos en la lista tras la modificación. | 0,5 |
| Actualización en la BD tras la modificación. | 0,5 |
| **Modificar** | Gestión del formulario oculto. Mostrar y ocultar. | 0,5 |
| Validación de campos y visualización de mensajes de error. | 0,5 |
| Inserción de una fila usando AJAX. | 0,5 |
| Inserción en la BD. | 0,5 |
| **Eliminar** | Gestión de la petición de confirmación. | 0,5 |
| Eliminación de la fila usando AJAX. | 0,5 |
| **General** | Correcta funcionalidad de la aplicación | 1 |
| Control de errores mediante excepciones. | 0,2 |
| Estética y organización de la aplicación. | 0,5 |
| Impresión general de la aplicación. | 1 |

  **Recuerda:**  Las librerías utilizadas para la tarea deben incluirse dentro del propio proyecto, en una carpeta llamada ** include,**  y hacerse referencia a esta ruta. |

## Recursos necesarios:

- Al menos será necesario tener instalado y configurado XAMPP con Apache y MySQL arrancados, y un editor para php, por ejemplo NetBeans o Notepad++
- Script de la base de datos:  Script para la base de datos
- Aclaración: es necesario tener creada la base de datos de la tarea con el script que se aporta en dicha tarea.
- [Manual de php.](http://es1.php.net/manual/es/index.php)
- Ayuda para el uso de la [ función crypt() ](http://php.net/manual/es/function.crypt.php)para la generación de hash de contraseñas.
- Ayuda para el uso de la  [función password\_verify() ](http://php.net/manual/es/function.password-verify.php)para comprobar el hash de una contraseña.

## Consejos y recomendaciones:

Se recomienda ir desarrollando cada una de las partes solicitadas hasta que se obtenga toda la funcionalidad completa.

Se aconseja hacer uso del manual de la página oficial de php.

## Corrección:
