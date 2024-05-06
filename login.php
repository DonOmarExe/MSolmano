<?php
// Obtener los datos enviados desde el formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Validar y filtrar los datos (agrega más validaciones según tus necesidades)

// Realizar la conexión a Oracle SQL
$servername = "tu_servidor";
$username = "tu_usuario";
$password = "tu_contraseña";
$database = "tu_base_de_datos";

$conn = oci_connect($username, $password, $servername);

if (!$conn) {
    $error = oci_error();
    echo "Error de conexión a Oracle: " . $error['message'];
    exit();
}

// Realizar la consulta SQL para verificar las credenciales del usuario
$sql = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":email", $email);
oci_bind_by_name($stmt, ":password", $password);
oci_execute($stmt);

// Verificar si se encontró un usuario con las credenciales proporcionadas
if ($row = oci_fetch_assoc($stmt)) {
    // Autenticación exitosa, puedes realizar las acciones necesarias aquí
    echo "Inicio de sesión exitoso";
} else {
    // Autenticación fallida, puedes mostrar un mensaje de error o redirigir al usuario a otra página
    echo "Credenciales inválidas";
}

// Cerrar la conexión a Oracle SQL
oci_free_statement($stmt);
oci_close($conn);
?>
