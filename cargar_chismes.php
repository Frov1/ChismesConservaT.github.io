<?php
$conexion = new mysqli("localhost", "root", "", "muro_chismes");

$sql = "SELECT * FROM chismes WHERE aprobado = 1 ORDER BY creado_en DESC";
$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    echo "<div class='post'>";
    echo "<p>" . htmlspecialchars($fila['texto']) . "</p>";
    if ($fila['archivo']) {
        $ruta = 'uploads/' . $fila['archivo'];
        if ($fila['tipo_archivo'] == 'video') {
            echo "<video class='media' controls src='$ruta'></video>";
        } else {
            echo "<img class='media' src='$ruta' />";
        }
    }
    echo "</div>";
}

$conexion->close();
?>