<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno - SAES</title>
    <link rel="stylesheet" href="../assets/css/alumno.css">
    <script src="../assets/js/alumno.js" defer></script>
</head>

<body>
    <?php
    session_start(); // Inicia la sesión al principio del archivo

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

    // Verifica si la boleta está en la sesión
    if (isset($_SESSION['boleta'])) {
        $boleta = $_SESSION['boleta'];

        // Consulta para obtener la imagen de perfil del alumno
        $query = "SELECT foto_perfil FROM alumnos WHERE boleta = '$boleta'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $foto_perfil = $row['foto_perfil'];
        } else {
            // Establece una imagen por defecto si no se encuentra la imagen de perfil
            $foto_perfil = '../assets/images/default_profile.png';
        }
    } else {
        // Redirige al usuario al login si no está autenticado
        header("Location: ../login.php");
        exit();
    }

    // Cierra la conexión
    $conn->close();
    ?>
    <header>
        <h1>Panel de Alumno</h1>
        <img src="<?php echo $foto_perfil; ?>" alt="Foto de Perfil" class="foto-perfil">
    </header>
    <nav>
        <ul>
            <li><a href="#" onclick="showSection('ver-materias')">Ver Materias</a></li>
            <li><a href="#" onclick="showSection('perfil')">Perfil</a></li>
        </ul>
    </nav>
    <main>
        <section id="ver-materias">
            <h2>Materias y Calificaciones</h2>
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Parcial 1</th>
                        <th>Parcial 2</th>
                        <th>Parcial 3</th>
                        <th>Calificación Final</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reabrir la conexión para obtener las materias y calificaciones del alumno
                    $conn = new mysqli($host, $user, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Consulta para obtener las materias y calificaciones del alumno
                    $query = "SELECT materias.nombre, inscripciones.parcial1, inscripciones.parcial2, inscripciones.parcial3, 
                              (inscripciones.parcial1 + inscripciones.parcial2 + inscripciones.parcial3) / 3 AS calificacion_final
                              FROM inscripciones
                              JOIN materias ON inscripciones.MateriaID = materias.id
                              WHERE inscripciones.AlumnoBoleta = '$boleta'";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        // Salida de datos de cada fila
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['parcial1']}</td>
                                    <td>{$row['parcial2']}</td>
                                    <td>{$row['parcial3']}</td>
                                    <td>{$row['calificacion_final']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay materias inscritas.</td></tr>";
                    }

                    // Cierra la conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
        <section id="perfil" style="display:none;">
            <h2>Perfil</h2>
            <form>
                <label for="foto-perfil">Foto de Perfil:</label>
                <input type="file" id="foto-perfil" name="foto-perfil">
                <button type="submit">Cambiar Foto</button>
            </form>
        </section>
    </main>
    <img src="../assets/images/logo.png" alt="Imagen Inferior Derecha" class="imagen-inferior-derecha">
</body>

</html>