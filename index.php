
<?php
$conexion = new mysqli("localhost", "root", "", "muro_chismes");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$resultado = $conexion->query("SELECT contenido, archivo FROM chismes WHERE estado = 'aprobado' ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chismes Conservatorio Del Tolima</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Chismes Conservatorio Del Tolima</h1>
    <a href="login.php" style="position: absolute; top: 10px; right: 10px;">Admin</a>

    <form action="enviar.php" method="POST" enctype="multipart/form-data">
        <textarea name="chisme" placeholder="Escribe un chisme..." required></textarea><br>
        <input type="file" name="archivo" accept="image/*,video/*"><br>
        <button type="submit">Enviar</button>
    </form>

    <h2>Chismes</h2>
    <div id="chismes">
        <?php while ($row = $resultado->fetch_assoc()): ?>
            <div class="chisme">
                <p><?php echo htmlspecialchars($row['contenido']); ?></p>
                <?php
                    if ($row['archivo'] && file_exists($row['archivo'])) {
                        $tipo = mime_content_type($row['archivo']);
                        if (str_starts_with($tipo, "image")) {
                            echo "<img src='{$row['archivo']}' alt='imagen'>";
                        } elseif (str_starts_with($tipo, "video")) {
                            echo "<video controls><source src='{$row['archivo']}' type='{$tipo}'></video>";
                        }
                    }
                ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
