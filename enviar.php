
<?php
$conexion = new mysqli("localhost", "root", "", "muro_chismes");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$chisme = $_POST["chisme"];
$archivoNombre = null;

if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
    $directorio = "uploads/";
    $archivoNombre = basename($_FILES["archivo"]["name"]);
    $rutaCompleta = $directorio . time() . "_" . $archivoNombre;
    move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaCompleta);
} else {
    $rutaCompleta = null;
}

$stmt = $conexion->prepare("INSERT INTO chismes (contenido, archivo, estado) VALUES (?, ?, 'pendiente')");
$stmt->bind_param("ss", $chisme, $rutaCompleta);
$stmt->execute();
$stmt->close();
$conexion->close();

header("Location: index.php");
exit();
?>
