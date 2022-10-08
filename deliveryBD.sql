/*
 Navicat Premium Data Transfer

 Source Server         : Conexion Local
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : delivery

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 08/10/2022 10:42:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categoria_producto
-- ----------------------------
DROP TABLE IF EXISTS `categoria_producto`;
CREATE TABLE `categoria_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categoria_producto
-- ----------------------------
INSERT INTO `categoria_producto` VALUES (1, 'bebida', '2022-08-21 12:25:45', '2022-08-21 12:25:45');

-- ----------------------------
-- Table structure for categoria_tienda
-- ----------------------------
DROP TABLE IF EXISTS `categoria_tienda`;
CREATE TABLE `categoria_tienda`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categoria_tienda
-- ----------------------------
INSERT INTO `categoria_tienda` VALUES (1, 'restaurante', '2022-08-21 10:58:30', '2022-08-21 10:58:33');

-- ----------------------------
-- Table structure for departamento
-- ----------------------------
DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of departamento
-- ----------------------------
INSERT INTO `departamento` VALUES (1, 'Ahuachapán');
INSERT INTO `departamento` VALUES (2, 'Santa Ana');
INSERT INTO `departamento` VALUES (3, 'Sonsonate');
INSERT INTO `departamento` VALUES (4, 'Usulután');
INSERT INTO `departamento` VALUES (5, 'San Miguel');
INSERT INTO `departamento` VALUES (6, 'Morazán');
INSERT INTO `departamento` VALUES (7, 'La Unión');
INSERT INTO `departamento` VALUES (8, 'La Libertad');
INSERT INTO `departamento` VALUES (9, 'Chalatenango');
INSERT INTO `departamento` VALUES (10, 'Cuscatlán');
INSERT INTO `departamento` VALUES (11, 'San Salvador');
INSERT INTO `departamento` VALUES (12, 'La Paz');
INSERT INTO `departamento` VALUES (13, 'Cabañas');
INSERT INTO `departamento` VALUES (14, 'San Vicente');

-- ----------------------------
-- Table structure for detalle_pedido
-- ----------------------------
DROP TABLE IF EXISTS `detalle_pedido`;
CREATE TABLE `detalle_pedido`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NULL DEFAULT NULL,
  `id_producto` int(11) NULL DEFAULT NULL,
  `cantidad` int(11) NULL DEFAULT NULL,
  `subtotal` decimal(8, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_detallePedido_pedido`(`id_pedido`) USING BTREE,
  INDEX `fk_detallePedido_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `fk_detallePedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_detallePedido_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of detalle_pedido
-- ----------------------------

-- ----------------------------
-- Table structure for direccion
-- ----------------------------
DROP TABLE IF EXISTS `direccion`;
CREATE TABLE `direccion`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `id_municipio` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_direccion_usuario`(`id_usuario`) USING BTREE,
  INDEX `fk_direccion_municipio`(`id_municipio`) USING BTREE,
  CONSTRAINT `fk_direccion_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `municipio` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_direccion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of direccion
-- ----------------------------

-- ----------------------------
-- Table structure for estado
-- ----------------------------
DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of estado
-- ----------------------------
INSERT INTO `estado` VALUES (1, 'Activo');
INSERT INTO `estado` VALUES (2, 'Inactivo');

-- ----------------------------
-- Table structure for estado_pedido
-- ----------------------------
DROP TABLE IF EXISTS `estado_pedido`;
CREATE TABLE `estado_pedido`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of estado_pedido
-- ----------------------------

-- ----------------------------
-- Table structure for municipio
-- ----------------------------
DROP TABLE IF EXISTS `municipio`;
CREATE TABLE `municipio`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_departamento` int(11) NULL DEFAULT NULL,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_municipio_departamento`(`id_departamento`) USING BTREE,
  CONSTRAINT `fk_municipio_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 263 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of municipio
-- ----------------------------
INSERT INTO `municipio` VALUES (1, 1, 'Ahuachapán');
INSERT INTO `municipio` VALUES (2, 1, 'Apaneca');
INSERT INTO `municipio` VALUES (3, 1, 'Atiquizaya');
INSERT INTO `municipio` VALUES (4, 1, 'Concepción de Ataco');
INSERT INTO `municipio` VALUES (5, 1, 'El Refugio');
INSERT INTO `municipio` VALUES (6, 1, 'Guaymango');
INSERT INTO `municipio` VALUES (7, 1, 'Jujutla');
INSERT INTO `municipio` VALUES (8, 1, 'San Francisco Menéndez');
INSERT INTO `municipio` VALUES (9, 1, 'San Lorenzo');
INSERT INTO `municipio` VALUES (10, 1, 'San Pedro Puxtla');
INSERT INTO `municipio` VALUES (11, 1, 'Tacuba');
INSERT INTO `municipio` VALUES (12, 1, 'Turín');
INSERT INTO `municipio` VALUES (13, 2, 'Santa Ana');
INSERT INTO `municipio` VALUES (14, 2, 'Chalchuapa');
INSERT INTO `municipio` VALUES (15, 2, 'Coatepeque');
INSERT INTO `municipio` VALUES (16, 2, 'El Congo');
INSERT INTO `municipio` VALUES (17, 2, 'El Porvenir');
INSERT INTO `municipio` VALUES (18, 2, 'Masahuat');
INSERT INTO `municipio` VALUES (19, 2, 'Metapán');
INSERT INTO `municipio` VALUES (20, 2, 'San Antonio Pajonal');
INSERT INTO `municipio` VALUES (21, 2, 'San Sebastián Salitrillo');
INSERT INTO `municipio` VALUES (22, 2, 'Candelaria de la Frontera');
INSERT INTO `municipio` VALUES (23, 2, 'Santa Rosa Guachipilín');
INSERT INTO `municipio` VALUES (24, 2, 'Santiago de la Frontera');
INSERT INTO `municipio` VALUES (25, 2, 'Texistepeque');
INSERT INTO `municipio` VALUES (26, 3, 'Sonsonate');
INSERT INTO `municipio` VALUES (27, 3, 'Acajutla');
INSERT INTO `municipio` VALUES (28, 3, 'Armenia');
INSERT INTO `municipio` VALUES (29, 3, 'Caluco');
INSERT INTO `municipio` VALUES (30, 3, 'Cuisnahuat');
INSERT INTO `municipio` VALUES (31, 3, 'Izalco');
INSERT INTO `municipio` VALUES (32, 3, 'Juayúa');
INSERT INTO `municipio` VALUES (33, 3, 'Nahuizalco');
INSERT INTO `municipio` VALUES (34, 3, 'Nahulingo');
INSERT INTO `municipio` VALUES (35, 3, 'Salcoatitán');
INSERT INTO `municipio` VALUES (36, 3, 'San Antonio del Monte');
INSERT INTO `municipio` VALUES (37, 3, 'San Julián');
INSERT INTO `municipio` VALUES (38, 3, 'Santa Catarina Masahuat');
INSERT INTO `municipio` VALUES (39, 3, 'Santa Isabel Ishuatán');
INSERT INTO `municipio` VALUES (40, 3, 'Santo Domingo de Guzmán');
INSERT INTO `municipio` VALUES (41, 3, 'Sonzacate');
INSERT INTO `municipio` VALUES (42, 4, 'Usulután');
INSERT INTO `municipio` VALUES (43, 4, 'Alegría');
INSERT INTO `municipio` VALUES (44, 4, 'Berlín');
INSERT INTO `municipio` VALUES (45, 4, 'California');
INSERT INTO `municipio` VALUES (46, 4, 'Concepción Batres');
INSERT INTO `municipio` VALUES (47, 4, 'El Triunfo');
INSERT INTO `municipio` VALUES (48, 4, 'Ereguayquín');
INSERT INTO `municipio` VALUES (49, 4, 'Estanzuelas');
INSERT INTO `municipio` VALUES (50, 4, 'Jiquilisco');
INSERT INTO `municipio` VALUES (51, 4, 'Jucuapa');
INSERT INTO `municipio` VALUES (52, 4, 'Jucuarán');
INSERT INTO `municipio` VALUES (53, 4, 'Mercedes Umaña');
INSERT INTO `municipio` VALUES (54, 4, 'Nueva Granada');
INSERT INTO `municipio` VALUES (55, 4, 'Ozatlán');
INSERT INTO `municipio` VALUES (56, 4, 'Puerto El Triunfo');
INSERT INTO `municipio` VALUES (57, 4, 'San Agustín');
INSERT INTO `municipio` VALUES (58, 4, 'San Buenaventura');
INSERT INTO `municipio` VALUES (59, 4, 'San Dionisio');
INSERT INTO `municipio` VALUES (60, 4, 'San Francisco Javier');
INSERT INTO `municipio` VALUES (61, 4, 'Santa Elena');
INSERT INTO `municipio` VALUES (62, 4, 'Santa María');
INSERT INTO `municipio` VALUES (63, 4, 'Santiago de María');
INSERT INTO `municipio` VALUES (64, 4, 'Tecapán');
INSERT INTO `municipio` VALUES (65, 5, 'San Miguel');
INSERT INTO `municipio` VALUES (66, 5, 'Carolina');
INSERT INTO `municipio` VALUES (67, 5, 'Chapeltique');
INSERT INTO `municipio` VALUES (68, 5, 'Chinameca');
INSERT INTO `municipio` VALUES (69, 5, 'Chirilagua');
INSERT INTO `municipio` VALUES (70, 5, 'Ciudad Barrios');
INSERT INTO `municipio` VALUES (71, 5, 'Comacarán');
INSERT INTO `municipio` VALUES (72, 5, 'El Tránsito');
INSERT INTO `municipio` VALUES (73, 5, 'Lolotique');
INSERT INTO `municipio` VALUES (74, 5, 'Moncagua');
INSERT INTO `municipio` VALUES (75, 5, 'Nueva Guadalupe');
INSERT INTO `municipio` VALUES (76, 5, 'Nuevo Edén de San Juan');
INSERT INTO `municipio` VALUES (77, 5, 'Quelepa');
INSERT INTO `municipio` VALUES (78, 5, 'San Antonio');
INSERT INTO `municipio` VALUES (79, 5, 'San Gerardo');
INSERT INTO `municipio` VALUES (80, 5, 'San Jorge');
INSERT INTO `municipio` VALUES (81, 5, 'San Luis de la Reina');
INSERT INTO `municipio` VALUES (82, 5, 'San Rafael Oriente');
INSERT INTO `municipio` VALUES (83, 5, 'Sesori');
INSERT INTO `municipio` VALUES (84, 5, 'Uluazapa');
INSERT INTO `municipio` VALUES (85, 6, 'Arambala');
INSERT INTO `municipio` VALUES (86, 6, 'Cacaopera');
INSERT INTO `municipio` VALUES (87, 6, 'Chilanga');
INSERT INTO `municipio` VALUES (88, 6, 'Corinto');
INSERT INTO `municipio` VALUES (89, 6, 'Delicias de Concepción');
INSERT INTO `municipio` VALUES (90, 6, 'El Divisadero');
INSERT INTO `municipio` VALUES (91, 6, 'El Rosario');
INSERT INTO `municipio` VALUES (92, 6, 'Gualococti');
INSERT INTO `municipio` VALUES (93, 6, 'Guatajiagua');
INSERT INTO `municipio` VALUES (94, 6, 'Joateca');
INSERT INTO `municipio` VALUES (95, 6, 'Jocoaitique');
INSERT INTO `municipio` VALUES (96, 6, 'Jocoro');
INSERT INTO `municipio` VALUES (97, 6, 'Lolotiquillo');
INSERT INTO `municipio` VALUES (98, 6, 'Meanguera');
INSERT INTO `municipio` VALUES (99, 6, 'Osicala');
INSERT INTO `municipio` VALUES (100, 6, 'Perquín');
INSERT INTO `municipio` VALUES (101, 6, 'San Carlos');
INSERT INTO `municipio` VALUES (102, 6, 'San Fernando');
INSERT INTO `municipio` VALUES (103, 6, 'San Francisco Gotera');
INSERT INTO `municipio` VALUES (104, 6, 'San Isidro');
INSERT INTO `municipio` VALUES (105, 6, 'San Simón');
INSERT INTO `municipio` VALUES (106, 6, 'Sensembra');
INSERT INTO `municipio` VALUES (107, 6, 'Sociedad');
INSERT INTO `municipio` VALUES (108, 6, 'Torola');
INSERT INTO `municipio` VALUES (109, 6, 'Yamabal');
INSERT INTO `municipio` VALUES (110, 6, 'Yoloaiquín');
INSERT INTO `municipio` VALUES (111, 7, 'La Unión');
INSERT INTO `municipio` VALUES (112, 7, 'San Alejo');
INSERT INTO `municipio` VALUES (113, 7, 'Yucuaiquín');
INSERT INTO `municipio` VALUES (114, 7, 'Conchagua');
INSERT INTO `municipio` VALUES (115, 7, 'Intipucá');
INSERT INTO `municipio` VALUES (116, 7, 'San José');
INSERT INTO `municipio` VALUES (117, 7, 'El Carmen');
INSERT INTO `municipio` VALUES (118, 7, 'Yayantique');
INSERT INTO `municipio` VALUES (119, 7, 'Bolívar');
INSERT INTO `municipio` VALUES (120, 7, 'Meanguera del Golfo');
INSERT INTO `municipio` VALUES (121, 7, 'Santa Rosa de Lima');
INSERT INTO `municipio` VALUES (122, 7, 'Pasaquina');
INSERT INTO `municipio` VALUES (123, 7, 'Anamoros');
INSERT INTO `municipio` VALUES (124, 7, 'Nueva Esparta');
INSERT INTO `municipio` VALUES (125, 7, 'El Sauce');
INSERT INTO `municipio` VALUES (126, 7, 'Concepción de Oriente');
INSERT INTO `municipio` VALUES (127, 7, 'Polorós');
INSERT INTO `municipio` VALUES (128, 7, 'Lislique');
INSERT INTO `municipio` VALUES (129, 8, 'La Libertad');
INSERT INTO `municipio` VALUES (130, 8, 'Antiguo Cuscatlán');
INSERT INTO `municipio` VALUES (131, 8, 'Chiltiupán');
INSERT INTO `municipio` VALUES (132, 8, 'Ciudad Arce');
INSERT INTO `municipio` VALUES (133, 8, 'Colón');
INSERT INTO `municipio` VALUES (134, 8, 'Comasagua');
INSERT INTO `municipio` VALUES (135, 8, 'Huizúcar');
INSERT INTO `municipio` VALUES (136, 8, 'Jayaque');
INSERT INTO `municipio` VALUES (137, 8, 'Jicalapa');
INSERT INTO `municipio` VALUES (138, 8, 'Santa Tecla');
INSERT INTO `municipio` VALUES (139, 8, 'Nuevo Cuscatlán');
INSERT INTO `municipio` VALUES (140, 8, 'San Juan Opico');
INSERT INTO `municipio` VALUES (141, 8, 'Quezaltepeque');
INSERT INTO `municipio` VALUES (142, 8, 'Sacacoyo');
INSERT INTO `municipio` VALUES (143, 8, 'San José Villanueva');
INSERT INTO `municipio` VALUES (144, 8, 'San Matías');
INSERT INTO `municipio` VALUES (145, 8, 'San Pablo Tacachico');
INSERT INTO `municipio` VALUES (146, 8, 'Talnique');
INSERT INTO `municipio` VALUES (147, 8, 'Tamanique');
INSERT INTO `municipio` VALUES (148, 8, 'Teotepeque');
INSERT INTO `municipio` VALUES (149, 8, 'Tepecoyo');
INSERT INTO `municipio` VALUES (150, 8, 'Zaragoza');
INSERT INTO `municipio` VALUES (151, 9, 'Chalatenango');
INSERT INTO `municipio` VALUES (152, 9, 'Agua Caliente');
INSERT INTO `municipio` VALUES (153, 9, 'Arcatao');
INSERT INTO `municipio` VALUES (154, 9, 'Azacualpa');
INSERT INTO `municipio` VALUES (155, 9, 'Cancasque');
INSERT INTO `municipio` VALUES (156, 9, 'Citalá');
INSERT INTO `municipio` VALUES (157, 9, 'Comapala');
INSERT INTO `municipio` VALUES (158, 9, 'Concepción Quezaltepeque');
INSERT INTO `municipio` VALUES (159, 9, 'Dulce Nombre de María');
INSERT INTO `municipio` VALUES (160, 9, 'El Carrizal');
INSERT INTO `municipio` VALUES (161, 9, 'El Paraíso');
INSERT INTO `municipio` VALUES (162, 9, 'La Laguna');
INSERT INTO `municipio` VALUES (163, 9, 'La Palma');
INSERT INTO `municipio` VALUES (164, 9, 'La Reina');
INSERT INTO `municipio` VALUES (165, 9, 'Las Flores');
INSERT INTO `municipio` VALUES (166, 9, 'Las Vueltas');
INSERT INTO `municipio` VALUES (167, 9, 'Nombre de Jesús');
INSERT INTO `municipio` VALUES (168, 9, 'Nueva Concepción');
INSERT INTO `municipio` VALUES (169, 9, 'Nueva Trinidad');
INSERT INTO `municipio` VALUES (170, 9, 'Ojos de Agua');
INSERT INTO `municipio` VALUES (171, 9, 'Potonico');
INSERT INTO `municipio` VALUES (172, 9, 'San Antonio de la Cruz');
INSERT INTO `municipio` VALUES (173, 9, 'San Antonio Los Ranchos');
INSERT INTO `municipio` VALUES (174, 9, 'San Fernando');
INSERT INTO `municipio` VALUES (175, 9, 'San Francisco Lempa');
INSERT INTO `municipio` VALUES (176, 9, 'San Francisco Morazán');
INSERT INTO `municipio` VALUES (177, 9, 'San Ignacio');
INSERT INTO `municipio` VALUES (178, 9, 'San Isidro Labrador');
INSERT INTO `municipio` VALUES (179, 9, 'San Luis del Carmen');
INSERT INTO `municipio` VALUES (180, 9, 'San Miguel de Mercedes');
INSERT INTO `municipio` VALUES (181, 9, 'San Rafael');
INSERT INTO `municipio` VALUES (182, 9, 'Santa Rita');
INSERT INTO `municipio` VALUES (183, 9, 'Tejutla');
INSERT INTO `municipio` VALUES (184, 10, 'Cojutepeque');
INSERT INTO `municipio` VALUES (185, 10, 'Candelaria');
INSERT INTO `municipio` VALUES (186, 10, 'El Carmen');
INSERT INTO `municipio` VALUES (187, 10, 'El Rosario');
INSERT INTO `municipio` VALUES (188, 10, 'Monte San Juan');
INSERT INTO `municipio` VALUES (189, 10, 'Oratorio de Concepción');
INSERT INTO `municipio` VALUES (190, 10, 'San Bartolomé Perulapía');
INSERT INTO `municipio` VALUES (191, 10, 'San Cristóbal');
INSERT INTO `municipio` VALUES (192, 10, 'San José Guayabal');
INSERT INTO `municipio` VALUES (193, 10, 'San Pedro Perulapán');
INSERT INTO `municipio` VALUES (194, 10, 'San Rafael Cedros');
INSERT INTO `municipio` VALUES (195, 10, 'San Ramón');
INSERT INTO `municipio` VALUES (196, 10, 'Santa Cruz Analquito');
INSERT INTO `municipio` VALUES (197, 10, 'Santa Cruz Michapa');
INSERT INTO `municipio` VALUES (198, 10, 'Suchitoto');
INSERT INTO `municipio` VALUES (199, 10, 'Tenancingo');
INSERT INTO `municipio` VALUES (200, 11, 'Aguilares');
INSERT INTO `municipio` VALUES (201, 11, 'Apopa');
INSERT INTO `municipio` VALUES (202, 11, 'Ayutuxtepeque');
INSERT INTO `municipio` VALUES (203, 11, 'Cuscatancingo');
INSERT INTO `municipio` VALUES (204, 11, 'Delgado');
INSERT INTO `municipio` VALUES (205, 11, 'El Paisnal');
INSERT INTO `municipio` VALUES (206, 11, 'Guazapa');
INSERT INTO `municipio` VALUES (207, 11, 'Ilopango');
INSERT INTO `municipio` VALUES (208, 11, 'Ilopango');
INSERT INTO `municipio` VALUES (209, 11, 'Nejapa');
INSERT INTO `municipio` VALUES (210, 11, 'Panchimalco');
INSERT INTO `municipio` VALUES (211, 11, 'Rosario de Mora');
INSERT INTO `municipio` VALUES (212, 11, 'San Marcos');
INSERT INTO `municipio` VALUES (213, 11, 'San Martín');
INSERT INTO `municipio` VALUES (214, 11, 'San Salvador');
INSERT INTO `municipio` VALUES (215, 11, 'Santiago Texacuangos');
INSERT INTO `municipio` VALUES (216, 11, 'Santo Tomás');
INSERT INTO `municipio` VALUES (217, 11, 'Soyapango');
INSERT INTO `municipio` VALUES (218, 11, 'Tonacatepeque');
INSERT INTO `municipio` VALUES (219, 12, 'Zacatecoluca');
INSERT INTO `municipio` VALUES (220, 12, 'Cuyultitán');
INSERT INTO `municipio` VALUES (221, 12, 'El Rosario');
INSERT INTO `municipio` VALUES (222, 12, 'Jerusalén');
INSERT INTO `municipio` VALUES (223, 12, 'Mercedes La Ceiba');
INSERT INTO `municipio` VALUES (224, 12, 'Olocuilta');
INSERT INTO `municipio` VALUES (225, 12, 'Paraíso de Osorio');
INSERT INTO `municipio` VALUES (226, 12, 'San Antonio Masahuat');
INSERT INTO `municipio` VALUES (227, 12, 'San Emigdio');
INSERT INTO `municipio` VALUES (228, 12, 'San Francisco Chinameca');
INSERT INTO `municipio` VALUES (229, 12, 'San Pedro Masahuat');
INSERT INTO `municipio` VALUES (230, 12, 'San Juan Nonualco');
INSERT INTO `municipio` VALUES (231, 12, 'San Juan Talpa');
INSERT INTO `municipio` VALUES (232, 12, 'San Juan Tepezontes');
INSERT INTO `municipio` VALUES (233, 12, 'San Luis La Herradura');
INSERT INTO `municipio` VALUES (234, 12, 'San Luis Talpa');
INSERT INTO `municipio` VALUES (235, 12, 'San Miguel Tepezontes');
INSERT INTO `municipio` VALUES (236, 12, 'San Pedro Nonualco');
INSERT INTO `municipio` VALUES (237, 12, 'San Rafael Obrajuelo');
INSERT INTO `municipio` VALUES (238, 12, 'Santa María Ostuma');
INSERT INTO `municipio` VALUES (239, 12, 'Santiago Nonualco');
INSERT INTO `municipio` VALUES (240, 12, 'Tapalhuaca');
INSERT INTO `municipio` VALUES (241, 13, 'Cinquera');
INSERT INTO `municipio` VALUES (242, 13, 'Dolores');
INSERT INTO `municipio` VALUES (243, 13, 'Guacotecti');
INSERT INTO `municipio` VALUES (244, 13, 'Ilobasco');
INSERT INTO `municipio` VALUES (245, 13, 'Jutiapa');
INSERT INTO `municipio` VALUES (246, 13, 'San Isidro');
INSERT INTO `municipio` VALUES (247, 13, 'Sensuntepeque');
INSERT INTO `municipio` VALUES (248, 13, 'Tejutepeque');
INSERT INTO `municipio` VALUES (249, 13, 'Victoria');
INSERT INTO `municipio` VALUES (250, 14, 'San Vicente');
INSERT INTO `municipio` VALUES (251, 14, 'Apastepeque');
INSERT INTO `municipio` VALUES (252, 14, 'Guadalupe');
INSERT INTO `municipio` VALUES (253, 14, 'San Cayetano Istepeque');
INSERT INTO `municipio` VALUES (254, 14, 'San Esteban Catarina');
INSERT INTO `municipio` VALUES (255, 14, 'San Ildefonso');
INSERT INTO `municipio` VALUES (256, 14, 'San Lorenzo');
INSERT INTO `municipio` VALUES (257, 14, 'San Sebastián');
INSERT INTO `municipio` VALUES (258, 14, 'Santa Clara');
INSERT INTO `municipio` VALUES (259, 14, 'Santo Domingo');
INSERT INTO `municipio` VALUES (260, 14, 'Tecoluca');
INSERT INTO `municipio` VALUES (261, 14, 'Tepetitán');
INSERT INTO `municipio` VALUES (262, 14, 'Verapaz');

-- ----------------------------
-- Table structure for pedido
-- ----------------------------
DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `fecha_hora` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_repartidor` int(11) NULL DEFAULT NULL,
  `id_direccion` int(11) NULL DEFAULT NULL,
  `id_tienda` int(11) NULL DEFAULT NULL,
  `id_estado_pedido` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_pedido_usuario`(`id_usuario`) USING BTREE,
  INDEX `fk_pedido_repartidor`(`id_repartidor`) USING BTREE,
  INDEX `fk_pedido_direccion`(`id_direccion`) USING BTREE,
  INDEX `fk_pedido_tienda`(`id_tienda`) USING BTREE,
  INDEX `fk_pedido_estadoPedido`(`id_estado_pedido`) USING BTREE,
  CONSTRAINT `fk_pedido_direccion` FOREIGN KEY (`id_direccion`) REFERENCES `direccion` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_pedido_estadoPedido` FOREIGN KEY (`id_estado_pedido`) REFERENCES `estado_pedido` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_pedido_repartidor` FOREIGN KEY (`id_repartidor`) REFERENCES `repartidor` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_pedido_tienda` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pedido
-- ----------------------------

-- ----------------------------
-- Table structure for producto
-- ----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `descripcion` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `precio` decimal(8, 2) NULL DEFAULT NULL,
  `id_estado` int(11) NULL DEFAULT NULL,
  `id_tienda` int(11) NULL DEFAULT NULL,
  `id_categoria` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_producto_estado`(`id_estado`) USING BTREE,
  INDEX `fk_producto_tienda`(`id_tienda`) USING BTREE,
  INDEX `fk_producto_categoriaProducto`(`id_categoria`) USING BTREE,
  CONSTRAINT `fk_producto_categoriaProducto` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_producto` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_producto_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_producto_tienda` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of producto
-- ----------------------------

-- ----------------------------
-- Table structure for repartidor
-- ----------------------------
DROP TABLE IF EXISTS `repartidor`;
CREATE TABLE `repartidor`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apellido` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telefono` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `numTarjeta` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `usuario` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_estado` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_repartidor_estado`(`id_estado`) USING BTREE,
  CONSTRAINT `fk_repartidor_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of repartidor
-- ----------------------------
INSERT INTO `repartidor` VALUES (1, 'prueba', 'prueba', '6058-4166', 'prueba@gmail.com', '6058416-655', 'repartidor1', '$2y$10$RZnrEmAM093psOmxvLvltuFsD5CDjT/ES06g/ponABaResRwUlu4q', 1, '2022-08-21 12:16:19', '2022-08-21 12:16:19');

-- ----------------------------
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rol
-- ----------------------------
INSERT INTO `rol` VALUES (1, 'Administrador');
INSERT INTO `rol` VALUES (2, 'Cliente');

-- ----------------------------
-- Table structure for tienda
-- ----------------------------
DROP TABLE IF EXISTS `tienda`;
CREATE TABLE `tienda`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nit` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nrc` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `giro` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `banco` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `numCuenta` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `usuario` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_estado` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `id_categoria` int(11) NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telefono` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_municipio` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_tienda_estado`(`id_estado`) USING BTREE,
  INDEX `fk_tienda_categoriaTienda`(`id_categoria`) USING BTREE,
  INDEX `fk_tienda_municipio`(`id_municipio`) USING BTREE,
  CONSTRAINT `fk_tienda_categoriaTienda` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_tienda` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_tienda_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_tienda_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `municipio` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tienda
-- ----------------------------
INSERT INTO `tienda` VALUES (1, 'Pupuseria Genesis', '558745592-6558-55', '789654-8558', 'Alimentos', 'Promerica', '455878965-66558', 'genesis', '$2y$10$vquSZOhja/yYMAV5kIKc4O/66DSBnUS1AvTFTVBqz/DHm.szDpiHi', 1, '2022-08-21 09:46:14', '2022-08-21 11:32:51', 1, 'barrio', '7896-8541', 53);

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apellido` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telefono` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `usuario` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_estado` int(11) NULL DEFAULT NULL,
  `id_rol` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_usuario_rol`(`id_rol`) USING BTREE,
  INDEX `fk_usuario_estado`(`id_estado`) USING BTREE,
  CONSTRAINT `fk_usuario_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (6, 'ssss', 'ssss', '2568-9874', 'asdw@gmail.com', 'admin', '$2y$10$V8u4NOFHI97Lj9aDZdaXNOU0.sjNs2OK4pcy.y.xl7lfbbBrlFkQG', 1, 1, '2022-08-20 10:23:16', '2022-09-27 15:52:19');

SET FOREIGN_KEY_CHECKS = 1;
