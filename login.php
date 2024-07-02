<?php
session_start(); // Inicia la sesión al principio del archivo

// Datos de conexión a MySQL
$host = "servidorcit0.mysql.database.azure.com";
$dbname = "escuela";
$user = "alana";
$password = "Losdelaesquina5";

// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname, 3306);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo del formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar datos de entrada para evitar inyecciones SQL
    $boleta = $conn->real_escape_string($_POST['boleta']);
    $contrasena = $conn->real_escape_string($_POST['contrasena']);

    // Consulta para verificar usuario y contraseña
    $query = "SELECT * FROM alumnos WHERE boleta = '$boleta' AND contrasena = '$contrasena'";
    $result = $conn->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    // Verificación adicional para el gestor
    if ($boleta === '0000000000' && $contrasena === 'admin') {
        header("Location: gestion/gestion.html");
        exit(); // Asegúrate de llamar a exit() después de header()
    }

    // Si el usuario y la contraseña son correctos, redirige a la página principal
    if ($result->num_rows == 1) {
        $_SESSION['boleta'] = $boleta; // Almacena la boleta en la sesión
        header("Location: alumno/alumno.php"); // Redirige al panel de alumno
        exit(); // Asegúrate de llamar a exit() después de header()
    } else {
        $error_message = "Usuario o contraseña incorrectos.";
    }
}

// Cierra la conexión al final
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAES</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Login</h2>
    <form method="post">
        <label for="boleta">Boleta:</label>
        <input type="text" id="boleta" name="boleta" required>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if (!empty($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>

</html>