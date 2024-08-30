-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-08-2024 a las 17:32:08
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba`
--
CREATE DATABASE IF NOT EXISTS `prueba` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `prueba`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alu_nombres` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `alu_apellidos` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `alu_tipo_documento` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `alu_numero_documento` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `alu_email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `alu_telefono` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `alu_direccion` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `alu_fecha_nacimiento` date NOT NULL,
  `alu_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `alu_nombres`, `alu_apellidos`, `alu_tipo_documento`, `alu_numero_documento`, `alu_email`, `alu_telefono`, `alu_direccion`, `alu_fecha_nacimiento`, `alu_estado`, `created_at`, `updated_at`) VALUES
(1, 'Oscar Ricardo', 'Gonzalez Singo', 'Cedula', '1750271023', 'oscar@correo.com', '0988416710', 'Norte', '2024-08-12', 'I', '2024-08-25 06:06:09', '2024-08-27 03:44:42'),
(2, 'Daniel', 'Sanchez', 'Cedula', '1750271023', 'daniel@gmail.com', '1234567890', 'Sur', '2024-07-29', 'A', '2024-08-29 04:14:43', '2024-08-29 04:14:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_resultados`
--

DROP TABLE IF EXISTS `alumnos_resultados`;
CREATE TABLE IF NOT EXISTS `alumnos_resultados` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `evaluacion_id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `evr_nota` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumnos_resultados_evaluacion_id_foreign` (`evaluacion_id`),
  KEY `alumnos_resultados_alumno_id_foreign` (`alumno_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `alumnos_resultados`
--

INSERT INTO `alumnos_resultados` (`id`, `evaluacion_id`, `alumno_id`, `evr_nota`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '8.50', '2024-08-28 04:04:16', '2024-08-28 04:04:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_cursos`
--

DROP TABLE IF EXISTS `alumno_cursos`;
CREATE TABLE IF NOT EXISTS `alumno_cursos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `alc_fecha_asignacion` datetime NOT NULL,
  `alc_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_cursos_alumno_id_foreign` (`alumno_id`),
  KEY `alumno_cursos_curso_id_foreign` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `alumno_cursos`
--

INSERT INTO `alumno_cursos` (`id`, `alumno_id`, `curso_id`, `alc_fecha_asignacion`, `alc_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-08-08 17:28:51', 'A', '2024-08-28 03:28:55', '2024-08-28 03:28:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_evaluacion_preguntas`
--

DROP TABLE IF EXISTS `alumno_evaluacion_preguntas`;
CREATE TABLE IF NOT EXISTS `alumno_evaluacion_preguntas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `evaluacion_id` bigint(20) UNSIGNED NOT NULL,
  `pregunta_id` bigint(20) UNSIGNED NOT NULL,
  `ale_respuesta` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ale_es_correcto` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_evaluacion_preguntas_alumno_id_foreign` (`alumno_id`),
  KEY `alumno_evaluacion_preguntas_evaluacion_id_foreign` (`evaluacion_id`),
  KEY `alumno_evaluacion_preguntas_pregunta_id_foreign` (`pregunta_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `alumno_evaluacion_preguntas`
--

INSERT INTO `alumno_evaluacion_preguntas` (`id`, `alumno_id`, `evaluacion_id`, `pregunta_id`, `ale_respuesta`, `ale_es_correcto`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 11, 'no se', 1, '2024-08-28 03:59:33', '2024-08-29 04:00:41'),
(2, 1, 1, 8, 'alvv', 1, '2024-08-29 03:53:34', '2024-08-29 04:50:27'),
(3, 2, 1, 5, 'cc', 1, '2024-08-29 04:50:58', '2024-08-29 04:51:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1724885045;', 1724885045),
('a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1724885045);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cur_nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cur_descripcion` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `cur_duracion` int(11) NOT NULL,
  `cur_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `cur_nombre`, `cur_descripcion`, `cur_duracion`, `cur_estado`, `created_at`, `updated_at`) VALUES
(1, 'Matematicas', 'Curso xd', 12, 'A', '2024-08-27 05:09:39', '2024-08-27 05:09:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dep_nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `dep_descripcion` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `dep_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `dep_nombre`, `dep_descripcion`, `dep_estado`, `created_at`, `updated_at`) VALUES
(1, 'Tecnologia', 'Innovacion tecnologica', 'A', '2024-08-27 03:49:41', '2024-08-27 03:49:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE IF NOT EXISTS `docentes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `departamento_id` bigint(20) UNSIGNED NOT NULL,
  `dce_nombres` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `dce_apellidos` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `dce_tipo_documento` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `dce_numero_documento` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dce_email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `dce_direccion` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `dce_telefono` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `dce_fecha_nacimiento` date NOT NULL,
  `dce_salario` decimal(10,2) NOT NULL,
  `dce_fecha_contratacion` datetime NOT NULL,
  `dce_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `docentes_departamento_id_foreign` (`departamento_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `departamento_id`, `dce_nombres`, `dce_apellidos`, `dce_tipo_documento`, `dce_numero_documento`, `dce_email`, `dce_direccion`, `dce_telefono`, `dce_fecha_nacimiento`, `dce_salario`, `dce_fecha_contratacion`, `dce_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Juan Pedro', 'Perez Apellido2', 'Cedula', '1234567890', 'oscar@gmail', 'Quito', '0988416710', '2024-08-18', '657.82', '2024-08-16 21:07:25', 'A', '2024-08-27 04:09:11', '2024-08-27 04:13:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_curso`
--

DROP TABLE IF EXISTS `docente_curso`;
CREATE TABLE IF NOT EXISTS `docente_curso` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `docente_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `dcc_fecha_asignacion` datetime NOT NULL,
  `dcc_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `docente_curso_docente_id_foreign` (`docente_id`),
  KEY `docente_curso_curso_id_foreign` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `docente_curso`
--

INSERT INTO `docente_curso` (`id`, `docente_id`, `curso_id`, `dcc_fecha_asignacion`, `dcc_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-08-21 10:27:58', 'A', '2024-08-27 20:28:03', '2024-08-27 20:28:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

DROP TABLE IF EXISTS `evaluaciones`;
CREATE TABLE IF NOT EXISTS `evaluaciones` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `eva_descripcion` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `eva_duracion` int(11) NOT NULL,
  `eva_cantidad_preguntas` int(11) NOT NULL,
  `eva_intentos` int(11) NOT NULL,
  `eva_peso` decimal(10,2) NOT NULL,
  `eva_fecha_inicio` datetime NOT NULL,
  `eva_fecha_fin` datetime NOT NULL,
  `eva_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluaciones_curso_id_foreign` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`id`, `curso_id`, `eva_descripcion`, `eva_duracion`, `eva_cantidad_preguntas`, `eva_intentos`, `eva_peso`, `eva_fecha_inicio`, `eva_fecha_fin`, `eva_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Primera evaluacion 2023', 30, 20, 3, '0.35', '2024-08-28 10:55:21', '2024-08-30 10:55:25', 'A', '2024-08-27 20:55:45', '2024-08-28 04:06:26'),
(2, 1, 'Segunda Evaluacion 2023', 20, 10, 2, '0.20', '2024-08-30 18:02:36', '2024-08-31 18:02:39', 'A', '2024-08-29 04:02:52', '2024-08-29 04:02:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_22_182931_create_curso_table', 1),
(5, '2024_08_23_182933_create_evaluacion_table', 1),
(6, '2024_08_23_182934_create_pregunta_table', 1),
(7, '2024_08_24_182929_create_alumno_table', 1),
(8, '2024_08_24_182930_create_alumno_curso_table', 1),
(9, '2024_08_24_182930_create_alumno_evaluacion_pregunta_table', 1),
(10, '2024_08_24_182932_create_departamento_table', 1),
(11, '2024_08_24_182932_create_docente_table', 1),
(12, '2024_08_24_182933_create_docente_curso_table', 1),
(13, '2024_08_24_182934_create_respuesta_table', 1),
(14, '2024_08_27_182929_create_alumnos_resultados_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `pre_tipo` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pre_descripcion` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `pre_puntuacion` int(11) NOT NULL,
  `pre_estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preguntas_curso_id_foreign` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `curso_id`, `pre_tipo`, `pre_descripcion`, `pre_puntuacion`, `pre_estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Opción múltiple', 'xd', 2, 'A', '2024-08-28 03:54:00', '2024-08-28 03:56:30'),
(2, 1, 'Verdadero/Falso', '¿Cuánto es 2 + 2?', 5, 'A', '2024-08-28 03:57:00', '2024-08-29 04:23:09'),
(3, 1, 'Opción múltiple', '¿Cuál es la raíz cuadrada de 16?', 5, 'A', '2024-08-28 04:00:00', '2024-08-28 04:02:30'),
(4, 1, 'Opción múltiple', '¿Qué es un número primo?', 5, 'A', '2024-08-28 04:03:00', '2024-08-28 04:05:30'),
(5, 1, 'Respuesta corta', '¿Cuánto es 10 x 10?', 5, 'A', '2024-08-28 04:06:00', '2024-08-29 04:23:28'),
(6, 1, 'Opción múltiple', '¿Cuál es el valor de la constante de Euler?', 5, 'A', '2024-08-28 04:09:00', '2024-08-28 04:11:30'),
(7, 1, 'Opción múltiple', '¿Qué es el teorema de Pitágoras?', 5, 'A', '2024-08-28 04:12:00', '2024-08-28 04:14:30'),
(8, 1, 'Opción múltiple', '¿Cuánto es 3^2?', 5, 'A', '2024-08-28 04:15:00', '2024-08-28 04:17:30'),
(9, 1, 'Opción múltiple', '¿Qué es una derivada en cálculo?', 5, 'A', '2024-08-28 04:18:00', '2024-08-28 04:20:30'),
(10, 1, 'Opción múltiple', '¿Qué es una integral?', 5, 'A', '2024-08-28 04:21:00', '2024-08-28 04:23:30'),
(11, 1, 'Opción múltiple', '¿Cuánto es 7 x 8?', 5, 'A', '2024-08-28 04:24:00', '2024-08-28 04:26:30'),
(12, 1, 'Opción múltiple', '¿Qué es el logaritmo natural?', 5, 'A', '2024-08-28 04:27:00', '2024-08-28 04:29:30'),
(13, 1, 'Opción múltiple', '¿Cuánto es 100 / 4?', 5, 'A', '2024-08-28 04:30:00', '2024-08-28 04:32:30'),
(14, 1, 'Opción múltiple', '¿Qué es una función cuadrática?', 5, 'A', '2024-08-28 04:33:00', '2024-08-28 04:35:30'),
(15, 1, 'Opción múltiple', '¿Qué es una matriz en álgebra lineal?', 5, 'A', '2024-08-28 04:36:00', '2024-08-28 04:38:30'),
(16, 1, 'Opción múltiple', '¿Cuánto es 9 / 3?', 5, 'A', '2024-08-28 04:39:00', '2024-08-28 04:41:30'),
(17, 1, 'Opción múltiple', '¿Qué es la media aritmética?', 5, 'A', '2024-08-28 04:42:00', '2024-08-28 04:44:30'),
(18, 1, 'Opción múltiple', '¿Cuál es el área de un círculo?', 5, 'A', '2024-08-28 04:45:00', '2024-08-28 04:47:30'),
(19, 1, 'Opción múltiple', '¿Qué es un vector en matemáticas?', 5, 'A', '2024-08-28 04:48:00', '2024-08-28 04:50:30'),
(20, 1, 'Opción múltiple', '¿Cuánto es 12 x 12?', 5, 'A', '2024-08-28 04:51:00', '2024-08-28 04:53:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
CREATE TABLE IF NOT EXISTS `respuestas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta_id` bigint(20) UNSIGNED NOT NULL,
  `res_descripcion_esperada` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `respuestas_pregunta_id_foreign` (`pregunta_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `pregunta_id`, `res_descripcion_esperada`, `created_at`, `updated_at`) VALUES
(1, 1, 'Buena respuestaa', '2024-08-28 04:08:51', '2024-08-28 04:12:12'),
(2, 1, 'tres', '2024-08-28 04:16:02', '2024-08-28 04:16:40'),
(3, 1, 'dos', '2024-08-28 04:16:50', '2024-08-28 04:16:50'),
(5, 13, 'nose', '2024-08-28 19:12:12', '2024-08-28 19:12:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('sVr6hKbd5H8nN5degrkd7iuy6XcFXABLE4uM6i92', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiSHNYS1ZJNm5zZHFzaXQwQ1VZVDlQMGkxSW5yVnZFNkxOZmpuWk9iRiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vYWx1bW5vLXJlc3VsdGFkb3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkWVZEMHZWQUY2TVJ2ajRjRXlITEhKLk9pRmd1Yi82SllabEw5M0dmTEtFTkVrZ0hDV1ljU3kiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fXM6NjoidGFibGVzIjthOjE6e3M6MjI6Ikxpc3RQcmVndW50YXNfcGVyX3BhZ2UiO3M6MjoiMjUiO319', 1724889758);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@correo.com', NULL, '$2y$12$YVD0vVAF6MRvj4cEyHLHJ.OiFgub/6JYZlL93GfLKENEkgHCWYcSy', NULL, '2024-08-25 05:54:51', '2024-08-25 05:54:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
