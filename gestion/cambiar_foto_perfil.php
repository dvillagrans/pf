<?php
// Datos de conexión a MySQL
$host = "localhost";
$dbname = "escuela";
$user = "root";
$password = "";

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo del formulario de cambiar foto de perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manejo de la foto de perfil
    if (isset($_FILES['foto-perfil']) && $_FILES['foto-perfil']['error'] === UPLOAD_ERR_OK) {
        $fotoPerfil = file_get_contents($_FILES['foto-perfil']['tmp_name']);
        $fotoPerfil = $conn->real_escape_string($fotoPerfil);
        // Supongamos que se está cambiando la foto de perfil del usuario con ID 1
        $query = "UPDATE usuarios SET foto_perfil='$fotoPerfil' WHERE id=1";
        if ($conn->query($query) === TRUE) {
            $success_message = "Foto de perfil cambiada exitosamente.";
        } else {
            $error_message = "Error al cambiar la foto de perfil: " . $conn->error;
        }
    } else {
        $error_message = "Error al subir la foto de perfil.";
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
    <title>Cambiar Foto de Perfil - SAES</title>
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