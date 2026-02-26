<?php
// Configuración básica
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Ajusta esto a tu dominio real en producción si es necesario

// Directorio donde se guardarán las imágenes
$target_dir = "uploads/";

// Crear directorio si no existe
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Verificar si se ha enviado un archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {

    $file = $_FILES['image'];
    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Validar que es una imagen real
    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        echo json_encode(['error' => 'El archivo no es una imagen.']);
        exit;
    }

    // Validar tamaño (ej. máx 5MB)
    if ($file['size'] > 5000000) {
        echo json_encode(['error' => 'La imagen es demasiado grande.']);
        exit;
    }

    // Generar nombre único para evitar sobrescribir
    $newFileName = uniqid('img_', true) . '.' . 'jpg'; // Forzamos jpg ya que el canvas lo envía así
    $target_file = $target_dir . $newFileName;

    // Intentar mover el archivo
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Devolver la URL completa
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $url = $protocol . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/" . $target_file;

        echo json_encode(['success' => true, 'url' => $url]);
    } else {
        echo json_encode(['error' => 'Hubo un error al subir el archivo al servidor.']);
    }
} else {
    echo json_encode(['error' => 'No se recibió ninguna imagen.']);
}
?>