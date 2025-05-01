<?php
include('conexion.php');

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$producto_id = (int)$_POST['producto_id']; // Sanitize input
$ciudad = $conn->real_escape_string($_POST['ciudad']);
$contenido = $conn->real_escape_string($_POST['contenido']);
$calificacion = (int)$_POST['calificacion']; // Ensure integer

// Capture the user's IP address
$ip = 'unknown'; // Default value

// Try REMOTE_ADDR first (should work in localhost)
if (!empty($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
}

// Check for proxy headers (useful in public servers)
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $proxy_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $proxy_ip = trim($proxy_ips[0]); // Take the first IP (client's IP)
    if (filter_var($proxy_ip, FILTER_VALIDATE_IP)) {
        $ip = $proxy_ip;
    }
} elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    // Alternative proxy header
    if (filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
}

// Special handling for localhost IPv6
if ($ip === '::1') {
    $ip = '127.0.0.1'; // Convert localhost IPv6 to IPv4 for consistency
}

// Try to get local network IP if accessing from another device
if ($ip === '127.0.0.1' && !empty($_SERVER['HTTP_HOST'])) {
    // Attempt to detect if accessed from another device in the local network
    $local_ip = gethostbyname(trim($_SERVER['HTTP_HOST']));
    if (filter_var($local_ip, FILTER_VALIDATE_IP) && $local_ip !== '127.0.0.1') {
        $ip = $local_ip;
    }
}

// Validate IP or set to 'unknown' if invalid
if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    $ip = 'unknown';
}

// Log IP for debugging (remove in production)
error_log("IP capturada para reseña: $ip");

// Validate rating (1-5)
if ($calificacion < 1 || $calificacion > 5) {
    die("Calificación inválida");
}

// Insert the review (resena_id is auto-incremented by the database)
$sql = "INSERT INTO reseñas (producto_id, contenido, calificacion, fecha_creacion, ciudad_declarada, ip_capturada, coincide_ubicacion, estado)
        VALUES ($producto_id, '$contenido', $calificacion, NOW(), '$ciudad', '$ip', 1, 'aprobada')";

if ($conn->query($sql)) {
    header("Location: producto.php?id=" . $producto_id);
} else {
    die("Error al guardar la reseña: " . htmlspecialchars($conn->error));
}
exit;
?>