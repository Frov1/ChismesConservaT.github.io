
<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "muro_chismes");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id = $_POST["id"];
$accion = $_POST["accion"];

if ($accion === "aprobar") {
    $stmt = $conexion->prepare("UPDATE chismes SET estado = 'aprobado' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
} elseif ($accion === "eliminar") {
    $stmt = $conexion->prepare("DELETE FROM chismes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();
header("Location: admin.php");
exit();
?>
