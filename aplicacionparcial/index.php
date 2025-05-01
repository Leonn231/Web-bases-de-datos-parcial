<?php include('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        header {
            background-color: #1f1f1f;
        }
        .search-bar {
            background-color: #1a1a1a;
            border: 1px solid #6b21a8; /* Changed from #15803d */
        }
        .search-button {
            background-color: #6b21a8; /* Changed from #15803d */
        }
        .search-button:hover {
            background-color: #a855f7; /* Changed from #22c55e */
        }
        .category-icon {
            background-color: #1a1a1a;
            border: 2px solid #6b21a8; /* Changed from #15803d */
            transition: background-color 0.2s, transform 0.2s;
        }
        .category-icon:hover {
            background-color: #a855f7; /* Changed from #15803d */
            transform: scale(1.1);
        }
        .category-icon.active {
            background-color: #a855f7; /* Changed from #15803d */
        }
        .product-card {
            background-color: #1a1a1a;
            border: 2px solid #6b21a8; /* Changed from #15803d */
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 224px;
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
            border-radius: 0.25rem;
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
        .view-more-button {
            background-color: #6b21a8; /* Changed from #15803d */
        }
        .view-more-button:hover {
            background-color: #a855f7; /* Changed from #22c55e */
        }
        .back-button {
            background-color: #6b21a8; /* Changed from #15803d */
        }
        .back-button:hover {
            background-color: #a855f7; /* Changed from #22c55e */
        }
    </style>
</head>
<body class="font-sans">
    <header class="py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-purple-600">Explora Productos</h1> <!-- Changed from text-green-500 -->
        </div>
    </header>

    <!-- Barra de búsqueda y categorías -->
    <section class="container mx-auto px-4 py-6">
        <!-- Barra de búsqueda -->
        <form method="GET" action="index.php" class="mb-6">
            <div class="flex items-center">
                <input type="text" name="search" placeholder="Buscar productos..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="w-full md:w-1/3 search-bar rounded-l-lg px-4 py-2 focus:outline-none">
                <button type="submit" class="search-button px-4 py-2 rounded-r-lg transition">🔍</button>
                <?php if (isset($_GET['search']) && !empty($_GET['search'])) { ?>
                    <a href="index.php" class="ml-2 text-gray-400 hover:text-purple-400">Limpiar</a> <!-- Changed from hover:text-green-500 -->
                <?php } ?>
            </div>
        </form>

        <!-- Categorías con iconos -->
        <div class="flex flex-wrap gap-4 mb-8">
            <a href="index.php<?php echo isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''; ?>" class="category-icon <?php echo !isset($_GET['categoria']) ? 'active' : ''; ?> flex items-center justify-center w-12 h-12 rounded-full text-2xl">
                📋
            </a>
            <?php
            $cat_sql = "SELECT categoria_id, nombre FROM categorias ORDER BY nombre";
            $cat_result = $conn->query($cat_sql);
            $category_icons = [
                'Electrónica' => '📱',
                'Computación' => '💻',
                'Audio' => '🎧',
            ];
            if ($cat_result) {
                while ($cat_row = $cat_result->fetch_assoc()) {
                    $icon = isset($category_icons[$cat_row['nombre']]) ? $category_icons[$cat_row['nombre']] : '📦';
                    $is_active = isset($_GET['categoria']) && $_GET['categoria'] == $cat_row['categoria_id'] ? 'active' : '';
                    ?>
                    <a href="index.php?categoria=<?php echo $cat_row['categoria_id']; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>" class="category-icon <?php echo $is_active; ?> flex items-center justify-center w-12 h-12 rounded-full text-2xl" title="<?php echo htmlspecialchars($cat_row['nombre']); ?>">
                        <?php echo $icon; ?>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </section>

    <main class="container mx-auto px-4 py-12">
        <div class="mb-6">
            <a href="index.php" class="inline-block back-button text-white px-4 py-2 rounded-lg transition">Volver a Inicio</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $sql = "SELECT p.*, c.nombre AS categoria_nombre, v.video_url,
                           (SELECT COUNT(*) FROM likes l WHERE l.producto_id = p.producto_id AND l.estado = 'like') AS like_count,
                           (SELECT COUNT(*) FROM likes l WHERE l.producto_id = p.producto_id AND l.estado = 'dislike') AS dislike_count,
                           (SELECT COUNT(*) FROM reseñas r WHERE r.producto_id = p.producto_id AND r.estado = 'aprobada') AS review_count,
                           (SELECT AVG(r.calificacion) FROM reseñas r WHERE r.producto_id = p.producto_id AND r.estado = 'aprobada') AS avg_rating
                    FROM productos p
                    JOIN categorias c ON p.categoria_id = c.categoria_id
                    LEFT JOIN videos_producto v ON p.producto_id = v.producto_id
                    WHERE 1=1";

            if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
                $categoria_id = (int)$_GET['categoria'];
                $sql .= " AND p.categoria_id = $categoria_id";
            }

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = $conn->real_escape_string($_GET['search']);
                $sql .= " AND p.nombre LIKE '%$search%'";
            }

            $sql .= " ORDER BY p.nombre ASC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $avg_stars = round($row['avg_rating'] ?: 0);
                    $img_sql = "SELECT imagen_url FROM imagenes_producto WHERE producto_id = {$row['producto_id']} ORDER BY imagen_id ASC";
                    $img_result = $conn->query($img_sql);
                    $imagenes = [];
                    while ($img_row = $img_result->fetch_assoc()) {
                        $imagenes[] = $img_row['imagen_url'];
                    }
                    ?>
                    <div class="product-card rounded-lg p-4">
                        <h2 class="text-xl font-semibold mb-2 text-purple-600"><?php echo htmlspecialchars($row['nombre']); ?></h2> <!-- Changed from text-green-500 -->
                        <p class="text-gray-400 text-sm mb-2"><?php echo htmlspecialchars($row['categoria_nombre']); ?></p>
                        <?php if (!empty($imagenes)) { ?>
                            <div class="carousel" data-carousel>
                                <div class="carousel-inner" id="carousel-<?php echo $row['producto_id']; ?>">
                                    <?php foreach ($imagenes as $index => $imagen) { ?>
                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                            <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de <?php echo htmlspecialchars($row['nombre']); ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (count($imagenes) > 1) { ?>
                                    <button class="carousel-prev" onclick="moveCarousel(<?php echo $row['producto_id']; ?>, -1)">❮</button>
                                    <button class="carousel-next" onclick="moveCarousel(<?php echo $row['producto_id']; ?>, 1)">❯</button>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <img src="https://via.placeholder.com/600x400.png?text=Sin+Imagen" alt="Sin imagen" class="w-full h-56 object-cover rounded-lg mb-4">
                        <?php } ?>
                        <?php if (!empty($row['video_url'])) { ?>
                            <?php
                            $video_url = trim($row['video_url']);
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
                        <?php } ?>
                        <div class="flex items-center mb-3">
                            <span class="text-yellow-400"><?php echo str_repeat("★", $avg_stars) . str_repeat("☆", 5 - $avg_stars); ?></span>
                            <span class="ml-2 text-gray-400 text-sm">(<?php echo $row['review_count']; ?>)</span>
                        </div>
                        <div class="flex items-center mb-4 text-gray-400 text-sm">
                            <span class="mr-4">👍 <?php echo $row['like_count']; ?></span>
                            <span>👎 <?php echo $row['dislike_count']; ?></span>
                        </div>
                        <a href="producto.php?id=<?php echo $row['producto_id']; ?>" class="inline-block view-more-button text-white px-4 py-2 rounded-lg transition">Ver Más</a>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-gray-400'>No se encontraron productos.</p>";
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
            const carouselContainer = carousel.closest('[data-carousel]');
            clearInterval(carouselContainer.dataset.intervalId);
            carouselContainer.dataset.intervalId = setInterval(() => moveCarousel(productId, 1), 3000);
        }

        document.querySelectorAll('[data-carousel]').forEach(carousel => {
            const productId = carousel.querySelector('.carousel-inner').id.split('-')[1];
            const items = carousel.querySelectorAll('.carousel-item');
            if (items.length > 1) {
                carousel.dataset.intervalId = setInterval(() => moveCarousel(productId, 1), 3000);
            }
        });
    </script>
</body>
</html>