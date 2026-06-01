-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2026 a las 21:07:11
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
-- Base de datos: `stepup_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Adidas'),
(2, 'Asics'),
(3, 'Converse'),
(4, 'New Balance'),
(5, 'Nike'),
(6, 'Puma'),
(7, 'Vans'),
(8, 'Reebok');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Urbanas'),
(2, 'Running'),
(3, 'Basquet'),
(4, 'Skate');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_brand` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `alt`, `stock`, `id_category`, `id_brand`) VALUES
(1, 'Forum', 'Zapatilla urbana clasica con diseno retro y gran comodidad para uso diario.', 150000, 'adidas_forum_low_cl', 'Zapatilla Adidas Forum Low CL color blanco con franjas azules vista lateral.', 50, 1, 1),
(2, 'Runfalcon', 'Zapatilla de running ligera para entrenamientos diarios y caminatas.', 75000, 'adidas_runfalcon_5', 'Zapatilla Adidas Runfalcon 5 negra con detalles blancos y suela degradada.', 37, 2, 1),
(3, 'Ultraboost', 'Modelo running con amortiguacion responsiva y ajuste comodo.', 175000, 'adidas_ultraboost_light', 'Zapatilla Adidas Ultraboost Light blanca con detalles verdes y suela gruesa.', 20, 2, 1),
(4, 'Yeezy', 'Zapatilla urbana premium con estilo moderno y silueta distintiva.', 200000, 'adidas_yeezy', 'Zapatilla Adidas Yeezy color crema con diseno tejido y suela translcida.', 12, 1, 1),
(5, 'Gel Nimbus', 'Zapatilla de running con foco en confort para largas distancias.', 300000, 'asics_gel_nimbus_27', 'Zapatilla Asics Gel Nimbus 27 gris con lineas claras y suela alta.', 58, 2, 2),
(6, 'Chuck Taylor', 'Clasica silueta de cana alta con plataforma y look casual.', 130000, 'converse_chuck_taylor_all_star_lift_hi_sintético', 'Zapatilla Converse Chuck Taylor All Star Lift Hi negra de cana alta.', 10, 1, 3),
(7, 'Fresh Foam', 'Calzado de running con amortiguacion suave para uso intensivo.', 150000, 'fresh_foam_x_1080_v_13', 'Zapatilla New Balance Fresh Foam X 1080 v13 azul con suela blanca.', 16, 2, 4),
(8, 'Air Force 1', 'Icono urbano de Nike con diseno limpio y atemporal.', 180000, 'nike_air_force_1_07', 'Zapatilla Nike Air Force 1 \'07 blanca clasica vista lateral.', 68, 2, 5),
(9, 'Air Jordan', 'Modelo de basquet inspirado en estilo retro y alto rendimiento.', 240000, 'nike_air_jordan', 'Zapatilla Nike Air Jordan de cana alta en negro, rojo y blanco.', 68, 3, 5),
(10, 'Dunk Low', 'Sneaker urbana clasica, ideal para outfits casuales diarios.', 185000, 'nike_dunk_low_retro', 'Zapatilla Nike Dunk Low Retro en blanco y negro estilo urbano.', 78, 1, 5),
(11, 'Pegasus', 'Zapatilla de running versatil para entrenamientos y fondo.', 100000, 'nike_air_zoom_pegasus_37', 'Zapatilla Nike Air Zoom Pegasus 37 negra con suela blanca.', 82, 2, 5),
(12, 'Puma Smash', 'Diseño urbano minimalista con inspiracion en tenis clasico.', 45000, 'puma_smash_v2', 'Zapatilla Puma Smash v2 gris con suela blanca y perfil bajo.', 100, 1, 6),
(13, 'Velocity Nitro', 'Modelo de running con buena respuesta y traccion estable.', 110000, 'puma_velocity_nitro_3', 'Zapatilla Puma Velocity Nitro 3 blanca con detalle lateral multicolor.', 48, 2, 6),
(14, 'Old Skool', 'Clasico skate urbano con capellada resistente y suela waffle.', 160000, 'vans_old_skool_negras', 'Zapatilla Vans Old Skool negra con franja blanca y suela blanca.', 8, 4, 7),
(15, 'Floatride', 'Zapatilla de running liviana para entrenamientos regulares.', 150000, 'rbk_floatride_energy_6', 'Zapatilla Reebok Floatride Energy 6 turquesa con suela blanca.', 4, 2, 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_brand` (`id_brand`),
  ADD KEY `fk_product_category` (`id_category`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
