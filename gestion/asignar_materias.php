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

// Manejo del formulario de asignación de materias
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar datos de entrada para evitar inyecciones SQL
    $boleta = $conn->real_escape_string($_POST['boleta']);
    $materia = $conn->real_escape_string($_POST['materia']);
    $parcial1 = $conn->real_escape_string($_POST['parcial1']);
    $parcial2 = $conn->real_escape_string($_POST['parcial2']);
    $parcial3 = $conn->real_escape_string($_POST['parcial3']);
    $calificacion_final = ($parcial1 + $parcial2 + $parcial3) / 3;

    // Consulta para obtener el ID de la materia basada en su nombre
    $materia_query = "SELECT ID FROM materias WHERE Nombre = '$materia'";
    $materia_result = $conn->query($materia_query);

    if ($materia_result->num_rows == 1) {
        $materia_row = $materia_result->fetch_assoc();
        $materia_id = $materia_row['ID'];

        // Consulta para insertar la asignación de la materia y calificaciones
        $query = "INSERT INTO inscripciones (AlumnoBoleta, MateriaID, Parcial1, Parcial2, Parcial3, CalificacionFinal) VALUES ('$boleta', '$materia_id', '$parcial1', '$parcial2', '$parcial3', '$calificacion_final')";

        if ($conn->query($query) === TRUE) {
            $success_message = "Materia asignada y calificaciones guardadas exitosamente.";
        } else {
            $error_message = "Error al asignar materia: " . $conn->error;
        }
    } else {
        $error_message = "Materia no encontrada.";
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
    <title>Asignar Materia - SAES</title>
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