<?php
include('conexion.php');
$producto_id = (int)$_GET['id']; // Sanitize input

$sql = "SELECT p.*, c.nombre AS categoria_nombre, v.video_url,
               (SELECT COUNT(*) FROM likes l WHERE l.producto_id = p.producto_id AND l.estado = 'like') AS like_count,
               (SELECT COUNT(*) FROM likes l WHERE l.producto_id = p.producto_id AND l.estado = 'dislike') AS dislike_count,
               (SELECT COUNT(*) FROM reseñas r WHERE r.producto_id = p.producto_id AND r.estado = 'aprobada') AS review_count,
               (SELECT AVG(r.calificacion) FROM reseñas r WHERE r.producto_id = p.producto_id AND r.estado = 'aprobada') AS avg_rating
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.categoria_id
        LEFT JOIN videos_producto v ON p.producto_id = v.producto_id
        WHERE p.producto_id = $producto_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $producto = $result->fetch_assoc();
    $avg_stars = round($producto['avg_rating'] ?: 0);
} else {
    die("Producto no encontrado o error en la consulta: " . htmlspecialchars($conn->error));
}

// Obtener imágenes del producto
$img_sql = "SELECT imagen_url FROM imagenes_producto WHERE producto_id = $producto_id ORDER BY imagen_id ASC";
$img_result = $conn->query($img_sql);
$imagenes = [];
while ($img_row = $img_result->fetch_assoc()) {
    $imagenes[] = $img_row['imagen_url'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 224px; /* h-56 en Tailwind, matches index.php */
        }
        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease;
        }
        .carousel-item {
            flex: 0 0 100%;
            width: 100%;
            height: 224px;
        }
        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.25rem; /* matches index.php */
        }
        .carousel-prev, .carousel-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #6b21a8; /* Changed from #15803d */
            color: #fff;
            padding: 0.5rem;
            cursor: pointer;
            border-radius: 0.25rem;
            z-index: 10;
        }
        .carousel-prev { left: 10px; }
        .carousel-next { right: 10px; }
        .carousel-prev:hover, .carousel-next:hover {
            background: #a855f7; /* Changed from #22c55e */
        }
        .star-rating .star {
            cursor: pointer;
            font-size: 1.5rem;
            color: #9ca3af; /* text-gray-400 */
            transition: color 0.2s, transform 0.2s;
        }
        .star-rating .star:hover,
        .star-rating .star.active {
            color: #f59e0b; /* text-yellow-400, unchanged */
            transform: scale(1.2);
        }
    </style>
</head>
<body class="font-sans">
    <header class="py-6" style="background-color: #1f1f1f;">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <a href="index.php" class="bg-[#6b21a8] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#a855f7] transition">← Volver al Inicio</a> <!-- Changed from #15803d, #22c55e -->
            <h1 class="text-4xl font-extrabold tracking-tight text-purple-600"><?php echo htmlspecialchars($producto['nombre']); ?></h1> <!-- Changed from text-green-500 -->
        </div>
    </header>
    <main class="container mx-auto px-4 py-12">
        <div class="bg-[#1a1a1a] rounded-xl p-8 border border-[#6b21a8] shadow-2xl"> <!-- Changed from #15803d -->
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/2">
                    <?php if (!empty($imagenes)) { ?>
                        <div class="carousel" data-carousel>
                            <div class="carousel-inner" id="carousel-<?php echo $producto_id; ?>">
                                <?php foreach ($imagenes as $index => $imagen) { ?>
                                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                        <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de <?php echo htmlspecialchars($producto['nombre']); ?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (count($imagenes) > 1) { ?>
                                <button class="carousel-prev" onclick="moveCarousel(<?php echo $producto_id; ?>, -1)">❮</button>
                                <button class="carousel-next" onclick="moveCarousel(<?php echo $producto_id; ?>, 1)">❯</button>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <img src="https://via.placeholder.com/600x400.png?text=Sin+Imagen" alt="Sin imagen" class="w-full h-56 object-cover rounded-lg mb-6">
                    <?php } ?>
                    <h3 class="text-2xl font-bold text-purple-600 mb-3 mt-6">Video del producto:</h3> <!-- Changed from text-green-500 -->
                    <?php if (!empty($producto['video_url'])) { ?>
                        <?php
                        $video_url = trim($producto['video_url']);
                        $youtube_id = '';
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $match)) {
                            $youtube_id = $match[1];
                        }
                        if ($youtube_id) {
                            $embed_url = "https://www.youtube.com/embed/$youtube_id";
                            ?>
                            <iframe class="w-full h-56 rounded-lg mb-4" src="<?php echo htmlspecialchars($embed_url); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <?php
                        } else {
                            ?>
                            <video class="w-full h-56 rounded-lg mb-4" controls>
                                <source src="<?php echo htmlspecialchars($video_url); ?>" type="video/mp4">
                                Tu navegador no soporta el elemento de video.
                            </video>
                            <?php
                        }
                        ?>
                    <?php } else { ?>
                        <p class="text-gray-400">No hay video disponible.</p>
                    <?php } ?>
                </div>
                <div class="md:w-1/2">
                    <p class="text-gray-400 mb-4"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <p class="text-gray-400 mb-4"><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria_nombre']); ?></p>
                    <div class="flex items-center mb-4">
                        <span class="text-yellow-400"><?php echo str_repeat("★", $avg_stars) . str_repeat("☆", 5 - $avg_stars); ?></span>
                        <span class="ml-2 text-gray-400">(<?php echo $producto['review_count']; ?> reseñas)</span>
                    </div>
                    <div class="flex items-center mb-6 text-gray-400">
                        <span class="mr-4">👍 <?php echo $producto['like_count']; ?> Likes</span>
                        <span>👎 <?php echo $producto['dislike_count']; ?> Dislikes</span>
                    </div>
                    <form method="POST" action="like.php" class="mb-6">
                        <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
                        <button type="submit" name="accion" value="like" class="bg-[#6b21a8] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#a855f7] transition mr-2">👍 Like</button> <!-- Changed from #15803d, #22c55e -->
                        <button type="submit" name="accion" value="dislike" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">👎 Dislike</button>
                    </form>
                    <h3 class="text-2xl font-bold text-purple-600 mb-3">Deja tu reseña:</h3> <!-- Changed from text-green-500 -->
                    <form method="POST" action="enviar_resena.php" class="bg-[#1a1a1a] p-6 rounded-lg">
                        <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
                        <div class="mb-4">
                            <label class="block text-gray-400">Nombre:</label>
                            <input type="text" name="nombre" class="w-full bg-[#1a1a1a] border border-[#6b21a8] rounded px-3 py-2 text-white" required> <!-- Changed from #15803d -->
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-400">Ciudad:</label>
                            <input type="text" name="ciudad" class="w-full bg-[#1a1a1a] border border-[#6b21a8] rounded px-3 py-2 text-white" required> <!-- Changed from #15803d -->
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-400">Calificación:</label>
                            <div class="star-rating flex">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <input type="hidden" name="calificacion" id="calificacion" value="0">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-400">Comentario:</label>
                            <textarea name="contenido" class="w-full bg-[#1a1a1a] border border-[#6b21a8] rounded px-3 py-2 text-white" rows="4" required></textarea> <!-- Changed from #15803d -->
                        </div>
                        <button type="submit" class="bg-[#6b21a8] text-white px-6 py-3 rounded-lg font-semibold border border-[#6b21a8] hover:bg-[#a855f7] transition">Enviar Reseña</button> <!-- Changed from #15803d, #22c55e -->
                    </form>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-purple-600 mt-8 mb-3">Reseñas:</h3> <!-- Changed from text-green-500 -->
            <?php
            $res = $conn->query("SELECT resena_id, contenido, calificacion, ciudad_declarada, ip_capturada, fecha_creacion 
                                 FROM reseñas 
                                 WHERE producto_id = $producto_id AND estado = 'aprobada' 
                                 ORDER BY fecha_creacion DESC");
            if ($res && $res->num_rows > 0) {
                while ($r = $res->fetch_assoc()) {
                    $ip_display = $r['ip_capturada'] ?: 'No disponible';
                    ?>
                    <div class="bg-[#1a1a1a] p-4 rounded-lg mb-4 border border-[#6b21a8]"> <!-- Changed from #15803d -->
                        <p class="text-gray-400">
                            <strong>Reseña #<?php echo $r['resena_id']; ?> - <?php echo htmlspecialchars($r['ciudad_declarada']); ?></strong> - 
                            <span class="text-yellow-400"><?php echo str_repeat("★", $r['calificacion']); ?></span>
                        </p>
                        <p class="text-gray-400"><?php echo htmlspecialchars($r['contenido']); ?></p>
                        <p class="text-gray-500 text-sm">IP: <?php echo htmlspecialchars($ip_display); ?></p>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-gray-400'>No hay reseñas disponibles.</p>";
            }
            ?>
        </div>
    </main>
    <script>
        function moveCarousel(productId, direction) {
            const carousel = document.getElementById(`carousel-${productId}`);
            const items = carousel.querySelectorAll('.carousel-item');
            let activeIndex = Array.from(items).findIndex(item => item.classList.contains('active'));
            items[activeIndex].classList.remove('active');
            activeIndex = (activeIndex + direction + items.length) % items.length;
            items[activeIndex].classList.add('active');
            carousel.style.transform = `translateX(-${activeIndex * 100}%)`;
            // Reset auto-rotation timer
            const carouselContainer = carousel.closest('[data-carousel]');
            clearInterval(carouselContainer.dataset.intervalId);
            carouselContainer.dataset.intervalId = setInterval(() => moveCarousel(productId, 1), 3000);
        }

        // Initialize carousel
        const carousel = document.querySelector('[data-carousel]');
        if (carousel) {
            const productId = carousel.querySelector('.carousel-inner').id.split('-')[1];
            const items = carousel.querySelectorAll('.carousel-item');
            if (items.length > 1) {
                carousel.dataset.intervalId = setInterval(() => moveCarousel(productId, 1), 3000);
            }
        }

        // Star rating functionality
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                document.getElementById('calificacion').value = value;
                document.querySelectorAll('.star').forEach(s => {
                    s.classList.remove('active');
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>