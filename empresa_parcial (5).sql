-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2025 a las 23:10:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `empresa_parcial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `nombre`, `imagen_url`) VALUES
(1, 'Electrónica', 'https://ejemplo.com/imagenes/categorias/tecnologia.jpg'),
(2, 'Computación', 'https://ejemplo.com/imagenes/categorias/tecnologia.jpg'),
(3, 'Audio', 'https://ejemplo.com/imagenes/categorias/tecnologia.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_producto`
--

CREATE TABLE `imagenes_producto` (
  `imagen_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_producto`
--

INSERT INTO `imagenes_producto` (`imagen_id`, `producto_id`, `imagen_url`, `fecha_subida`, `nombre_producto`) VALUES
(1, 1, 'https://th.bing.com/th/id/OIP.OBhiQd3cbJYH9Eexhr7HYAHaFu?rs=1&pid=ImgDetMain', '2025-04-20 10:30:00', 'iPhone 14 Pro'),
(2, 1, 'https://i0.wp.com/imgs.hipertextual.com/wp-content/uploads/2022/09/iPhone-14-Pro.jpg?fit=1500%2C938&quality=50&strip=all&ssl=1', '2025-04-20 10:45:00', 'iPhone 14 Pro'),
(3, 2, 'https://images.macrumors.com/t/lyB4c1iPX6XBNTsqFd19N14goLQ=/2672x/article-new/2022/08/14-vs-16-inch-mbp-m2-pro-and-max-feature-1.jpg', '2025-04-22 12:00:00', 'MacBook Pro 14 M2'),
(4, 3, 'https://manofmany.com/wp-content/uploads/2022/06/Sony-WH-1000XM5-feature-2-1.jpg', '2025-04-25 15:30:00', 'Sony WH-1000XM5'),
(5, 3, 'https://th.bing.com/th/id/OIP.4fd-VUm_wSdzjvM-lgRD_gHaHa?rs=1&pid=ImgDetMain', '2025-04-25 15:35:00', 'Sony WH-1000XM5'),
(6, 1, 'https://cdn.andro4all.com/andro4all/2022/09/iPhone-14-Pro.jpg', '2025-05-01 12:01:44', 'iPhone 14 Pro'),
(7, 4, 'https://s.zst.com.br/cms-assets/2024/01/samsung-galaxy-s24-ultra-titanio.webp', '2025-05-02 10:00:00', 'Samsung Galaxy S23 Ultra'),
(8, 4, 'https://th.bing.com/th/id/OIP.trPNc6t8M_9T-t4TITDp1wHaE8?w=1500&h=1000&rs=1&pid=ImgDetMain', '2025-05-02 10:05:00', 'Samsung Galaxy S23 Ultra'),
(9, 5, 'https://th.bing.com/th/id/R.7346063dd0ea4cdfc0b0f3c85b8dacf0?rik=DKY76cwJfJZBNw&pid=ImgRaw&r=0', '2025-05-02 11:00:00', 'Dell XPS 13'),
(10, 6, 'https://cdn.vox-cdn.com/thumbor/jZfqkbCsGUPnN7QM19mOCOCBba8=/0x0:2040x1360/1200x675/filters:focal(901x731:1227x1057)/cdn.vox-cdn.com/uploads/chorus_image/image/69925313/cwelch_202109_4775_5603.0.jpg', '2025-05-02 12:00:00', 'Bose QuietComfort 45'),
(11, 7, 'https://www.macstoreonline.com.mx/img/lp/ipad-pro-m2/hero_mdm_2x.png?1665787246669', '2025-05-02 13:00:00', 'iPad Pro 12.9 M2'),
(12, 8, 'https://th.bing.com/th/id/R.cd64af731998699e7d5514de3f449679?rik=e40BtfOAYbox3Q&pid=ImgRaw&r=0', '2025-05-02 14:00:00', 'Apple Watch Series 8'),
(13, 9, 'https://www.techtoyreviews.com/wp-content/uploads/2022/02/JBL-Flip-6-Review-1-1024x652.jpg', '2025-05-02 15:00:00', 'JBL Flip 6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `estado` enum('like','dislike') DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`like_id`, `producto_id`, `usuario_id`, `estado`, `fecha`) VALUES
(2, 2, 2, 'like', '2025-04-22 12:10:00'),
(3, 3, 3, 'dislike', '2025-04-25 15:45:00'),
(4, 1, 2, 'like', '2025-04-22 12:20:00'),
(5, 2, 3, 'dislike', '2025-04-25 15:50:00'),
(10, 1, 1, 'like', '2025-05-01 11:23:26'),
(11, 1, 1, 'like', '2025-05-01 11:29:29'),
(12, 1, 1, 'like', '2025-05-01 11:29:44'),
(13, 1, 1, 'like', '2025-05-01 11:29:44'),
(14, 1, 1, 'dislike', '2025-05-01 11:29:45'),
(15, 1, 1, 'dislike', '2025-05-01 11:29:46'),
(16, 1, 1, 'like', '2025-05-01 12:10:36'),
(17, 3, 1, 'like', '2025-05-01 15:45:33'),
(18, 3, 1, 'like', '2025-05-01 15:45:34'),
(19, 3, 1, 'like', '2025-05-01 15:45:35'),
(20, 7, 1, 'like', '2025-05-01 16:00:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `producto_id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `ficha_tecnica` text DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `categoria_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`producto_id`, `nombre`, `descripcion`, `ficha_tecnica`, `imagen_url`, `fecha_publicacion`, `estado`, `categoria_id`, `categoria_nombre`) VALUES
(1, 'iPhone 14 Pro', 'Smartphone premium con pantalla Super Retina XDR y chip A16 Bionic.', 'Chip A16 Bionic, pantalla 6.1\" Super Retina XDR, cámara 48MP, 256GB almacenamiento', 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone-14-pro-finish-select-202209-6-1inch-deeppurple?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1663790196922', '2025-04-20 10:00:00', 'activo', 1, 'Electrónica'),
(2, 'MacBook Pro 14 M2', 'Laptop profesional con chip M2 Pro y pantalla Liquid Retina.', 'Chip M2 Pro, pantalla 14.2\" Liquid Retina, 16GB RAM, 1TB SSD', 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/mbp-14-spacegray-select-202301?wid=5120&hei=2880&fmt=jpeg&qlt=90&.v=1670622623665', '2025-04-22 11:00:00', 'activo', 2, 'Computación'),
(3, 'Sony WH-1000XM5', 'Auriculares inalámbricos con cancelación de ruido líder en la industria.', 'Cancelación de ruido, Bluetooth 5.2, batería 30 horas', 'https://www.sony.com/image/3e59f54a5f7b5f3f2b5f4a7b8c9d0e1f?fmt=png-alpha&wid=1200', '2025-04-25 14:00:00', 'activo', 3, 'Audio'),
(4, 'Samsung Galaxy S23 Ultra', 'Smartphone flagship con cámara de 200MP y S Pen.', 'Snapdragon 8 Gen 2, pantalla 6.8\" Dynamic AMOLED, cámara 200MP, 512GB almacenamiento', 'https://images.samsung.com/is/image/samsung/p6pim/es/8806094683911/feature/es-8806094683911-feature-samsung-galaxy-s23-ultra-537373785?$FB_TYPE_A_MO_JPG$', '2025-05-02 10:00:00', 'activo', 1, 'Electrónica'),
(5, 'Dell XPS 13', 'Laptop ultraligera con pantalla OLED y gran rendimiento.', 'Intel i7-1260P, pantalla 13.4\" OLED, 16GB RAM, 512GB SSD', 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/notebooks/xps-notebooks/xps-13-9315/media-gallery/xps-13-9315-tml-silver-gallery-1.psd?fmt=png-alpha&wid=1200', '2025-05-02 11:00:00', 'activo', 2, 'Computación'),
(6, 'Bose QuietComfort 45', 'Auriculares con cancelación de ruido y sonido equilibrado.', 'Cancelación de ruido, Bluetooth 5.1, batería 24 horas', 'https://assets.bose.com/content/dam/Bose_DAM/Web/consumer_electronics/global/products/headphones/quietcomfort_headphones_45/product_images/QC45_Black_Front.png/_jcr_content/renditions/cq5dam.web.1200.1200.png', '2025-05-02 12:00:00', 'activo', 3, 'Audio'),
(7, 'iPad Pro 12.9 M2', 'Tablet potente con chip M2 y pantalla Liquid Retina.', 'Chip M2, pantalla 12.9\" Liquid Retina, 128GB almacenamiento', 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/ipad-pro-12-2022-silver-wifi?wid=5120&hei=2880&fmt=jpeg&qlt=90&.v=1664579781120', '2025-05-02 13:00:00', 'activo', 1, 'Electrónica'),
(8, 'Apple Watch Series 8', 'Reloj inteligente con monitoreo avanzado de salud.', 'Chip S8, pantalla Retina siempre activa, resistencia al agua', 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/MQJ83_VW_34FR+watch-45-alum-midnight-nc-8s_VW_34FR_WF_CO?wid=5120&hei=3280&fmt=jpeg&qlt=90&.v=1678745639184', '2025-05-02 14:00:00', 'activo', 1, 'Electrónica'),
(9, 'JBL Flip 6', 'Altavoz portátil con sonido potente y resistencia al agua.', 'Bluetooth 5.1, resistencia IP67, batería 12 horas', 'https://th.bing.com/th/id/OIP.JHkz2wmTy6UtqkLB3py_XQHaFj?rs=1&pid=ImgDetMain', '2025-05-02 15:00:00', 'activo', 3, 'Audio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rangos_ip`
--

CREATE TABLE `rangos_ip` (
  `rango_id` int(11) NOT NULL,
  `ip_inicio` varchar(45) DEFAULT NULL,
  `ip_fin` varchar(45) DEFAULT NULL,
  `ubicacion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rangos_ip`
--

INSERT INTO `rangos_ip` (`rango_id`, `ip_inicio`, `ip_fin`, `ubicacion_id`) VALUES
(1, '192.168.1.0', '192.168.1.255', 1),
(2, '192.168.2.0', '192.168.2.255', 2),
(3, '192.168.3.0', '192.168.3.255', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `resena_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `calificacion` tinyint(1) DEFAULT NULL CHECK (`calificacion` >= 1 and `calificacion` <= 5),
  `fecha_creacion` datetime DEFAULT NULL,
  `ciudad_declarada` varchar(100) DEFAULT NULL,
  `ip_capturada` varchar(45) DEFAULT NULL,
  `coincide_ubicacion` tinyint(1) DEFAULT NULL,
  `estado` enum('aprobada','pendiente','rechazada') DEFAULT NULL,
  `fecha_subida` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`resena_id`, `producto_id`, `usuario_id`, `contenido`, `calificacion`, `fecha_creacion`, `ciudad_declarada`, `ip_capturada`, `coincide_ubicacion`, `estado`, `fecha_subida`) VALUES
(1, 1, 1, 'Me encanta este smartphone, tiene una gran cámara y es muy rápido.', 5, '2025-04-20 10:30:00', 'Bogotá', '192.168.1.1', 1, 'aprobada', '2025-05-01 14:12:46'),
(2, 2, 2, 'La laptop es excelente para trabajar, aunque un poco pesada.', 4, '2025-04-22 12:00:00', 'Medellín', '192.168.1.2', 1, 'aprobada', '2025-05-01 14:12:46'),
(3, 3, 3, 'Los auriculares tienen buen sonido, pero la cancelación de ruido no es perfecta.', 3, '2025-04-25 15:30:00', 'Cali', '192.168.1.3', 1, 'aprobada', '2025-05-01 14:12:46'),
(4, 1, NULL, '', 1, '2025-05-01 10:45:30', '', '::1', 1, 'aprobada', '2025-05-01 14:12:46'),
(5, 1, NULL, ' buen producto', 1, '2025-05-01 10:46:06', 'armenia', '::1', 1, 'aprobada', '2025-05-01 14:12:46'),
(6, 1, NULL, 'Buena producto', 3, '2025-05-01 11:11:43', 'armenia', '::1', 1, 'aprobada', '2025-05-01 14:12:46'),
(7, 1, NULL, 'gran producto!', 5, '2025-05-01 11:35:18', 'Medellín', '::1', 1, 'aprobada', '2025-05-01 14:12:46'),
(8, 1, NULL, 'bofff productazo', 5, '2025-05-01 11:44:47', 'Cali', '::1', 1, 'aprobada', '2025-05-01 14:12:46'),
(9, 1, NULL, 'que pedazo de celuco ', 5, '2025-05-01 12:10:55', 'armenia', '127.0.0.1', 1, 'aprobada', '2025-05-01 14:12:46'),
(10, 1, NULL, 'buen celular', 5, '2025-05-01 14:44:57', 'Cali', '127.0.0.1', 1, 'aprobada', '2025-05-01 14:44:57'),
(11, 7, NULL, 'es un buen producto, pero muy frágil', 3, '2025-05-01 15:59:47', 'Andorra', '127.0.0.1', 1, 'aprobada', '2025-05-01 15:59:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `ubicacion_id` int(11) NOT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`ubicacion_id`, `ciudad`, `departamento`, `pais`, `codigo_postal`) VALUES
(1, 'Bogotá', 'Cundinamarca', 'Colombia', '110001'),
(2, 'Medellín', 'Antioquia', 'Colombia', '050010'),
(3, 'Cali', 'Valle del Cauca', 'Colombia', '760001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `nombre`, `email`, `password_hash`, `fecha_registro`, `ultimo_acceso`, `estado`) VALUES
(1, 'Carlos Pérez', 'carlos.perez@ejemplo.com', 'hashed_password_123', '2025-04-10 09:00:00', '2025-04-29 10:00:00', 'activo'),
(2, 'María Gómez', 'maria.gomez@ejemplo.com', 'hashed_password_456', '2025-04-12 10:30:00', '2025-04-29 11:00:00', 'activo'),
(3, 'Juan López', 'juan.lopez@ejemplo.com', 'hashed_password_789', '2025-04-15 08:15:00', '2025-04-29 12:00:00', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos_producto`
--

CREATE TABLE `videos_producto` (
  `video_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp(),
  `nombre_producto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `videos_producto`
--

INSERT INTO `videos_producto` (`video_id`, `producto_id`, `video_url`, `fecha_subida`, `nombre_producto`) VALUES
(1, 1, 'https://www.youtube.com/watch?v=fqaBXpObsQg', '2025-04-30 19:08:16', 'iPhone 14 Pro'),
(2, 2, 'https://youtu.be/1yVF-N__JKk?si=C_tBq4qCDkHVvHCv', '2025-04-30 19:08:16', 'MacBook Pro 14 M2'),
(3, 3, 'https://youtu.be/v6EjmbMgv80?si=fkoP3aZLG1D835Pz', '2025-04-30 19:08:16', 'Sony WH-1000XM5'),
(4, 4, 'https://www.youtube.com/watch?v=OZNs1r8fQM0', '2025-05-02 10:00:00', 'Samsung Galaxy S23 Ultra'),
(5, 5, 'https://www.youtube.com/watch?v=wNS1ubbgJE4', '2025-05-02 11:00:00', 'Dell XPS 13'),
(6, 6, 'https://youtu.be/qPx4_GuHI4w?si=cIMEfZhquSkb5XOV', '2025-05-02 12:00:00', 'Bose QuietComfort 45'),
(7, 7, 'https://youtu.be/Btd8z72OpEc?si=nSGJGW0YLdlMntNx', '2025-05-02 13:00:00', 'iPad Pro 12.9 M2'),
(8, 8, 'https://www.youtube.com/watch?v=csPXt4OpCMw', '2025-05-02 14:00:00', 'Apple Watch Series 8'),
(9, 9, 'https://youtu.be/r53ZxsuxM1M?si=bxpnK0pUJsZm41p2', '2025-05-02 15:00:00', 'JBL Flip 6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD PRIMARY KEY (`imagen_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `idx_producto_id` (`producto_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `rangos_ip`
--
ALTER TABLE `rangos_ip`
  ADD PRIMARY KEY (`rango_id`),
  ADD KEY `ubicacion_id` (`ubicacion_id`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`resena_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`ubicacion_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `videos_producto`
--
ALTER TABLE `videos_producto`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  MODIFY `imagen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rangos_ip`
--
ALTER TABLE `rangos_ip`
  MODIFY `rango_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `resena_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `ubicacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `videos_producto`
--
ALTER TABLE `videos_producto`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD CONSTRAINT `imagenes_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`);

--
-- Filtros para la tabla `rangos_ip`
--
ALTER TABLE `rangos_ip`
  ADD CONSTRAINT `rangos_ip_ibfk_1` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`ubicacion_id`);

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`),
  ADD CONSTRAINT `reseñas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Filtros para la tabla `videos_producto`
--
ALTER TABLE `videos_producto`
  ADD CONSTRAINT `videos_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
