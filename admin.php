
<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "muro_chismes");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (isset($_GET["aprobar"])) {
    $id = $_GET["aprobar"];
    $conexion->query("UPDATE chismes SET estado='aprobado' WHERE id=$id");
}

if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conexion->query("DELETE FROM chismes WHERE id=$id");
}

$resultado = $conexion->query("SELECT * FROM chismes WHERE estado = 'pendiente' ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrador de Chismes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Panel de Administrador</h1>
    <a href="logout.php" style="position:absolute; top:10px; right:10px; background:#dc3545; color:white; padding:8px 12px; border-radius:8px; text-decoration:none;">Cerrar sesión</a>

    <?php while ($row = $resultado->fetch_assoc()): ?>
        <div class="chisme">
            <p><strong>ID:</strong> <?php echo $row['id']; ?></p>
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
            <br><br>
            <a href="?aprobar=<?php echo $row['id']; ?>"><button>Aprobar</button></a>
            <a href="?eliminar=<?php echo $row['id']; ?>"><button>Eliminar</button></a>
        </div>
    <?php endwhile; ?>
</body>
</html>
