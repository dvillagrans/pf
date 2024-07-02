<?php
// Datos de conexión a MySQL
$host = "servidorcit0.mysql.database.azure.com";
$dbname = "escuela";
$user = "alana";
$password = "Losdelaesquina5";

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo del formulario de agregar alumnos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar datos de entrada para evitar inyecciones SQL
    $nombre = $conn->real_escape_string($_POST['nombre-alumno']);
    $boleta = $conn->real_escape_string($_POST['boleta']);
    $contrasena = $conn->real_escape_string($_POST['contrasena']);
    $edad = $conn->real_escape_string($_POST['edad']);

    // Manejo de la foto de perfil
    $fotoPerfil = null;
    if (isset($_FILES['FotoPerfil']) && $_FILES['FotoPerfil']['error'] === UPLOAD_ERR_OK) {
        $fotoPerfil = file_get_contents($_FILES['FotoPerfil']['tmp_name']);
        $fotoPerfil = $conn->real_escape_string($fotoPerfil);
    }

    // Consulta para insertar el nuevo alumno
    $query = "INSERT INTO alumnos (Boleta, NombreCompleto, Contrasena, Edad, FotoPerfil) 
                            VALUES ('$boleta', '$nombre', '$contrasena', '$edad', '$fotoPerfil')";

    if ($conn->query($query) === TRUE) {
        $success_message = "Alumno agregado exitosamente.";
    } else {
        $error_message = "Error al agregar alumno: " . $conn->error;
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
    <title>Agregar Alumno - SAES</title>
    <link rel="stylesheet" href="gestion.css">
</head>

<body>
    <?php if (!empty($success_message)) : ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php elseif (!empty($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <a href="gestion.html">Regresar</a>
</body>

</html>