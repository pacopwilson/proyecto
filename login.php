<?php
session_start();
// Se utiliza para llamar al archivo que contine la conexion a la base de datos
require ('conexion.php');

// Validamos que el formulario y que el boton login haya sido presionado
if(isset($_POST['login'])) {
    // Obtener los valores enviados por el formulario
    $usuario = $_POST['nombre_user'];
    $contraseña = $_POST['contrasena_user'];

    // Ejecutamos la consulta a la base de datos utilizando la función mysqli_query
    $sql = "SELECT * FROM empleados WHERE cve_empleado = '$usuario' and contraseña = '$contraseña'";
    $resultado = mysqli_query($conexion,$sql);
    $numero_registros = mysqli_num_rows($resultado);
    if($numero_registros != 0) {
        // Inicio de sesión exitoso
        //echo "Inicio de sesión exitoso. Bienvenido, " . $usuario . "!";
        header("Location: /website/generar_reportes/index.php");
        exit();
    } else {
        // Credenciales inválidas
        header("Location: index.php?error=Clave de empleado o contraseña incorrecta.");
        exit();
    }
}
?>