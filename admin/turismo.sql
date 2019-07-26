/*
Navicat MySQL Data Transfer

Source Server         : cnx
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : turismo

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-10-10 13:39:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `inscripcion`
-- ----------------------------
DROP TABLE IF EXISTS `inscripcion`;
CREATE TABLE `inscripcion` (
`rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`nombre`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`apellido`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fecha_nacim`  date NULL DEFAULT NULL ,
`domicilio`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`ciudad`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`pais`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fono`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`email`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`contacto_emerg`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fono_emerg`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`deporte`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`grupo_sanguineo`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`enfermedad`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`alergia`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_fecha`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`rut`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of inscripcion
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `man_actividad`
-- ----------------------------
DROP TABLE IF EXISTS `man_actividad`;
CREATE TABLE `man_actividad` (
`id_activ`  int(6) NOT NULL ,
`nom_activ`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_fecha`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id_activ`),
FOREIGN KEY (`reg_rut`) REFERENCES `man_usuario` (`rut`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `reg_rut` (`reg_rut`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of man_actividad
-- ----------------------------
BEGIN;
INSERT INTO `man_actividad` VALUES ('1', 'Alojamiento', '12707369-4', '2018-09-23 12:00:00'), ('2', 'Alta MontaNa', '12707369-4', '2018-09-23 12:00:00'), ('3', 'Barranquismo, Exploracion De CaNones O Canyoning', '12707369-4', '2018-09-23 12:00:00'), ('4', 'Buceo En Apnea', '12707369-4', '2018-09-23 12:00:00'), ('5', 'Buceo Recreativo Autonomo', '12707369-4', '2018-09-23 12:00:00'), ('6', 'Cabalgatas', '12707369-4', '2018-09-23 12:00:00'), ('7', 'Canotaje', '12707369-4', '2018-09-23 12:00:00'), ('8', 'Cicloturismo', '12707369-4', '2018-09-23 12:00:00'), ('9', 'Descenso En Balsa O Rafting', '12707369-4', '2018-09-23 12:00:00'), ('10', 'Deslizamiento Sobre Arena O Sandboard', '12707369-4', '2018-09-23 12:00:00'), ('11', 'Deslizamientos Sobre Nieve En Areas No Delimitadas', '12707369-4', '2018-09-23 12:00:00'), ('12', 'Deslizamiento Sobre Olas (Surf, Bodyboard, Kneeboard Y Similares)', '12707369-4', '2018-09-23 12:00:00'), ('13', 'Desplazamiento En Cables: Canopy, Tirolesa Y Arborismo', '12707369-4', '2018-09-23 12:00:00'), ('14', 'Escalada En Roca', '12707369-4', '2018-09-23 12:00:00'), ('15', 'Excursionismo O Trekking', '12707369-4', '2018-09-23 12:00:00'), ('16', 'Hidrotrineo O Hidrospeed', '12707369-4', '2018-09-23 12:00:00'), ('17', 'MontaNa', '12707369-4', '2018-09-23 12:00:00'), ('18', 'Motos Acuaticas Y Jetsky', '12707369-4', '2018-09-23 12:00:00'), ('19', 'Observacion De Flora Y Fauna', '12707369-4', '2018-09-23 12:00:00'), ('20', 'Paseos En Banano', '12707369-4', '2018-09-23 12:00:00'), ('21', 'Paseos Nauticos', '12707369-4', '2018-09-23 12:00:00'), ('22', 'Pesca Recreativa', '12707369-4', '2018-09-23 12:00:00'), ('23', 'Recorrido En Vehiculos Todo Terreno U Off Road', '12707369-4', '2018-09-23 12:00:00'), ('24', 'Senderismo O Hiking', '12707369-4', '2018-09-23 12:00:00'), ('25', 'Vuelo Ultraliviano No Motorizado Biplaza O Parapente Biplaza', '12707369-4', '2018-09-23 12:00:00');
COMMIT;

-- ----------------------------
-- Table structure for `man_comuna`
-- ----------------------------
DROP TABLE IF EXISTS `man_comuna`;
CREATE TABLE `man_comuna` (
`id_comuna`  int(4) NOT NULL AUTO_INCREMENT ,
`nom_comuna`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`id_provincia`  int(4) NOT NULL ,
`activo`  int(1) NOT NULL DEFAULT 0 ,
PRIMARY KEY (`id_comuna`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=355

;

-- ----------------------------
-- Records of man_comuna
-- ----------------------------
BEGIN;
INSERT INTO `man_comuna` VALUES ('1', 'Arica', '1', '1'), ('2', 'Camarones', '1', '1'), ('3', 'Putre', '2', '1'), ('4', 'General Lagos', '2', '1'), ('5', 'Iquique', '3', '1'), ('6', 'Alto Hospicio', '3', '1'), ('7', 'Pozo Almonte', '4', '1'), ('8', 'CamiNa', '4', '1'), ('9', 'Colchane', '4', '1'), ('10', 'Huara', '4', '1'), ('11', 'Pica', '4', '1'), ('12', 'Antofagasta', '5', '1'), ('13', 'Mejillones', '5', '1'), ('14', 'Sierra Gorda', '5', '1'), ('15', 'Taltal', '5', '1'), ('16', 'Calama', '6', '1'), ('17', 'Ollague', '6', '1'), ('18', 'San Pedro de Atacama', '6', '1'), ('19', 'Tocopilla', '7', '1'), ('20', 'Maria Elena', '7', '1'), ('21', 'Copiapo', '8', '1'), ('22', 'Caldera', '8', '1'), ('23', 'Tierra Amarilla', '8', '1'), ('24', 'ChaNaral', '9', '1'), ('25', 'Diego de Almagro', '9', '1'), ('26', 'Vallenar', '10', '1'), ('27', 'Alto del Carmen', '10', '1'), ('28', 'Freirina', '10', '1'), ('29', 'Huasco', '10', '1'), ('30', 'La Serena', '11', '1'), ('31', 'Coquimbo', '11', '1'), ('32', 'Andacollo', '11', '1'), ('33', 'La Higuera', '11', '1'), ('34', 'Paiguano', '11', '1'), ('35', 'VicuNa', '11', '1'), ('36', 'Illapel', '12', '1'), ('37', 'Canela', '12', '1'), ('38', 'Los Vilos', '12', '1'), ('39', 'Salamanca', '12', '1'), ('40', 'Ovalle', '13', '1'), ('41', 'Combarbala', '13', '1'), ('42', 'Monte Patria', '13', '1'), ('43', 'Punitaqui', '13', '1'), ('44', 'Rio Hurtado', '13', '1'), ('45', 'Valparaiso', '14', '1'), ('46', 'Casablanca', '14', '1'), ('47', 'Concon', '14', '1'), ('48', 'Juan Fernandez', '14', '1'), ('49', 'Puchuncavi', '14', '1'), ('50', 'Quilpue', '14', '1'), ('51', 'Quintero', '14', '1'), ('52', 'Villa Alemana', '14', '1'), ('53', 'ViNa del Mar', '14', '1'), ('54', 'Isla de Pascua', '15', '1'), ('55', 'Los Andes', '16', '1'), ('56', 'Calle Larga', '16', '1'), ('57', 'Rinconada', '16', '1'), ('58', 'San Esteban', '16', '1'), ('59', 'La Ligua', '17', '1'), ('60', 'Cabildo', '17', '1'), ('61', 'Papudo', '17', '1'), ('62', 'Petorca', '17', '1'), ('63', 'Zapallar', '17', '1'), ('64', 'Quillota', '18', '1'), ('65', 'Calera', '18', '1'), ('66', 'Hijuelas', '18', '1'), ('67', 'La Cruz', '18', '1'), ('68', 'Limache', '18', '1'), ('69', 'Nogales', '18', '1'), ('70', 'Olmue', '18', '1'), ('71', 'San Antonio', '19', '1'), ('72', 'Algarrobo', '19', '1'), ('73', 'Cartagena', '19', '1'), ('74', 'El Quisco', '19', '1'), ('75', 'El Tabo', '19', '1'), ('76', 'Santo Domingo', '19', '1'), ('77', 'San Felipe', '20', '1'), ('78', 'Catemu', '20', '1'), ('79', 'Llaillay', '20', '1'), ('80', 'Panquehue', '20', '1'), ('81', 'Putaendo', '20', '1'), ('82', 'Santa Maria', '20', '1'), ('83', 'Rancagua', '21', '1'), ('84', 'Codegua', '21', '1'), ('85', 'Coinco', '21', '1'), ('86', 'Coltauco', '21', '1'), ('87', 'DoNihue', '21', '1'), ('88', 'Graneros', '21', '1'), ('89', 'Las Cabras', '21', '1'), ('90', 'Machali', '21', '1'), ('91', 'Malloa', '21', '1'), ('92', 'Mostazal', '21', '1'), ('93', 'Olivar', '21', '1'), ('94', 'Peumo', '21', '1'), ('95', 'Pichidegua', '21', '1'), ('96', 'Quinta de Tilcoco', '21', '1'), ('97', 'Rengo', '21', '1'), ('98', 'Requinoa', '21', '1'), ('99', 'San Vicente', '21', '1'), ('100', 'Pichilemu', '22', '1');
INSERT INTO `man_comuna` VALUES ('101', 'La Estrella', '22', '1'), ('102', 'Litueche', '22', '1'), ('103', 'Marchihue', '22', '1'), ('104', 'Navidad', '22', '1'), ('105', 'Paredones', '22', '1'), ('106', 'San Fernando', '23', '1'), ('107', 'Chepica', '23', '1'), ('108', 'Chimbarongo', '23', '1'), ('109', 'Lolol', '23', '1'), ('110', 'Nancagua', '23', '1'), ('111', 'Palmilla', '23', '1'), ('112', 'Peralillo', '23', '1'), ('113', 'Placilla', '23', '1'), ('114', 'Pumanque', '23', '1'), ('115', 'Santa Cruz', '23', '1'), ('116', 'Talca', '24', '1'), ('117', 'Constitucion', '24', '1'), ('118', 'Curepto', '24', '1'), ('119', 'Empedrado', '24', '1'), ('120', 'Maule', '24', '1'), ('121', 'Pelarco', '24', '1'), ('122', 'Pencahue', '24', '1'), ('123', 'Rio Claro', '24', '1'), ('124', 'San Clemente', '24', '1'), ('125', 'San Rafael', '24', '1'), ('126', 'Cauquenes', '25', '1'), ('127', 'Chanco', '25', '1'), ('128', 'Pelluhue', '25', '1'), ('129', 'Curico', '26', '1'), ('130', 'HualaNe', '26', '1'), ('131', 'Licanten', '26', '1'), ('132', 'Molina', '26', '1'), ('133', 'Rauco', '26', '1'), ('134', 'Romeral', '26', '1'), ('135', 'Sagrada Familia', '26', '1'), ('136', 'Teno', '26', '1'), ('137', 'Vichuquen', '26', '1'), ('138', 'Linares', '27', '1'), ('139', 'Colbun', '27', '1'), ('140', 'Longavi', '27', '1'), ('141', 'Parral', '27', '1'), ('142', 'Retiro', '27', '1'), ('143', 'San Javier', '27', '1'), ('144', 'Villa Alegre', '27', '1'), ('145', 'Yerbas Buenas', '27', '1'), ('146', 'Concepcion', '28', '1'), ('147', 'Coronel', '28', '1'), ('148', 'Chiguayante', '28', '1'), ('149', 'Florida', '28', '1'), ('150', 'Hualqui', '28', '1'), ('151', 'Lota', '28', '1'), ('152', 'Penco', '28', '1'), ('153', 'San Pedro de la Paz', '28', '1'), ('154', 'Santa Juana', '28', '1'), ('155', 'Talcahuano', '28', '1'), ('156', 'Tome', '28', '1'), ('157', 'Hualpen', '28', '1'), ('158', 'Lebu', '29', '1'), ('159', 'Arauco', '29', '1'), ('160', 'CaNete', '29', '1'), ('161', 'Contulmo', '29', '1'), ('162', 'Curanilahue', '29', '1'), ('163', 'Los Alamos', '29', '1'), ('164', 'Tirua', '29', '1'), ('165', 'Los Angeles', '30', '1'), ('166', 'Antuco', '30', '1'), ('167', 'Cabrero', '30', '1'), ('168', 'Laja', '30', '1'), ('169', 'Mulchen', '30', '1'), ('170', 'Nacimiento', '30', '1'), ('171', 'Negrete', '30', '1'), ('172', 'Quilaco', '30', '1'), ('173', 'Quilleco', '30', '1'), ('174', 'San Rosendo', '30', '1'), ('175', 'Santa Barbara', '30', '1'), ('176', 'Tucapel', '30', '1'), ('177', 'Yumbel', '30', '1'), ('178', 'Alto Biobio', '30', '1'), ('179', 'Chillan', '31', '1'), ('180', 'Bulnes', '31', '1'), ('181', 'Cobquecura', '31', '1'), ('182', 'Coelemu', '31', '1'), ('183', 'Coihueco', '31', '1'), ('184', 'Chillan Viejo', '31', '1'), ('185', 'El Carmen', '31', '1'), ('186', 'Ninhue', '31', '1'), ('187', 'Niquen', '31', '1'), ('188', 'Pemuco', '31', '1'), ('189', 'Pinto', '31', '1'), ('190', 'Portezuelo', '31', '1'), ('191', 'Quillon', '31', '1'), ('192', 'Quirihue', '31', '1'), ('193', 'Ranquil', '31', '1'), ('194', 'San Carlos', '31', '1'), ('195', 'San Fabian', '31', '1'), ('196', 'San Ignacio', '31', '1'), ('197', 'San Nicolas', '31', '1'), ('198', 'Treguaco', '31', '1'), ('199', 'Yungay', '31', '1'), ('200', 'Temuco', '32', '1');
INSERT INTO `man_comuna` VALUES ('201', 'Carahue', '32', '1'), ('202', 'Cunco', '32', '1'), ('203', 'Curarrehue', '32', '1'), ('204', 'Freire', '32', '1'), ('205', 'Galvarino', '32', '1'), ('206', 'Gorbea', '32', '1'), ('207', 'Lautaro', '32', '1'), ('208', 'Loncoche', '32', '1'), ('209', 'Melipeuco', '32', '1'), ('210', 'Nueva Imperial', '32', '1'), ('211', 'Padre Las Casas', '32', '1'), ('212', 'Perquenco', '32', '1'), ('213', 'Pitrufquen', '32', '1'), ('214', 'Pucon', '32', '1'), ('215', 'Puerto Saavedra', '32', '1'), ('216', 'Teodoro Schmidt', '32', '1'), ('217', 'Tolten', '32', '1'), ('218', 'Vilcun', '32', '1'), ('219', 'Villarrica', '32', '1'), ('220', 'Cholchol', '32', '1'), ('221', 'Angol', '33', '1'), ('222', 'Collipulli', '33', '1'), ('223', 'Curacautin', '33', '1'), ('224', 'Ercilla', '33', '1'), ('225', 'Lonquimay', '33', '1'), ('226', 'Los Sauces', '33', '1'), ('227', 'Lumaco', '33', '1'), ('228', 'Puren', '33', '1'), ('229', 'Renaico', '33', '1'), ('230', 'Traiguen', '33', '1'), ('231', 'Victoria', '33', '1'), ('232', 'Valdivia', '34', '1'), ('233', 'Corral', '34', '1'), ('234', 'Lanco', '34', '1'), ('235', 'Los Lagos', '34', '1'), ('236', 'Mafil', '34', '1'), ('237', 'San Jose de la Mariquina', '34', '1'), ('238', 'Paillaco', '34', '1'), ('239', 'Panguipulli', '34', '1'), ('240', 'La Union', '35', '1'), ('241', 'Futrono', '35', '1'), ('242', 'Lago Ranco', '35', '1'), ('243', 'Rio Bueno', '35', '1'), ('244', 'Puerto Montt', '36', '1'), ('245', 'Calbuco', '36', '1'), ('246', 'Cochamo', '36', '1'), ('247', 'Fresia', '36', '1'), ('248', 'Frutillar', '36', '1'), ('249', 'Los Muermos', '36', '1'), ('250', 'Llanquihue', '36', '1'), ('251', 'Maullin', '36', '1'), ('252', 'Puerto Varas', '36', '1'), ('253', 'Castro', '37', '1'), ('254', 'Ancud', '37', '1'), ('255', 'Chonchi', '37', '1'), ('256', 'Curaco de Velez', '37', '1'), ('257', 'Dalcahue', '37', '1'), ('258', 'Puqueldon', '37', '1'), ('259', 'Queilen', '37', '1'), ('260', 'Quellon', '37', '1'), ('261', 'Quemchi', '37', '1'), ('262', 'Quinchao', '37', '1'), ('263', 'Osorno', '38', '1'), ('264', 'Puerto Octay', '38', '1'), ('265', 'Purranque', '38', '1'), ('266', 'Puyehue', '38', '1'), ('267', 'Rio Negro', '38', '1'), ('268', 'San Juan de la Costa', '38', '1'), ('269', 'San Pablo', '38', '1'), ('270', 'Chaiten', '39', '1'), ('271', 'Futaleufu', '39', '1'), ('272', 'Hualaihue', '39', '1'), ('273', 'Palena', '39', '1'), ('274', 'Coyhaique', '40', '1'), ('275', 'Lago Verde', '40', '1'), ('276', 'Aysen', '41', '1'), ('277', 'Puerto Cisnes', '41', '1'), ('278', 'Guaitecas', '41', '1'), ('279', 'Cochrane', '42', '1'), ('280', 'O\'Higgins', '42', '1'), ('281', 'Tortel', '42', '1'), ('282', 'Chile Chico', '43', '1'), ('283', 'Rio IbaNez', '43', '1'), ('284', 'Punta Arenas', '44', '1'), ('285', 'Laguna Blanca', '44', '1'), ('286', 'Rio Verde', '44', '1'), ('287', 'San Gregorio', '44', '1'), ('288', 'Cabo de Hornos (Ex-Navarino)', '45', '1'), ('289', 'Antartica', '45', '1'), ('290', 'Porvenir', '46', '1'), ('291', 'Primavera', '46', '1'), ('292', 'Timaukel', '46', '1'), ('293', 'Natales', '47', '1'), ('294', 'Torres del Paine', '47', '1'), ('295', 'Santiago', '48', '1'), ('296', 'Cerrillos', '48', '1'), ('297', 'Cerro Navia', '48', '1'), ('298', 'Conchali', '48', '1'), ('299', 'El Bosque', '48', '1'), ('300', 'Estacion Central', '48', '1');
INSERT INTO `man_comuna` VALUES ('301', 'Huechuraba', '48', '1'), ('302', 'Independencia', '48', '1'), ('303', 'La Cisterna', '48', '1'), ('304', 'La Florida', '48', '1'), ('305', 'La Granja', '48', '1'), ('306', 'La Pintana', '48', '1'), ('307', 'La Reina', '48', '1'), ('308', 'Las Condes', '48', '1'), ('309', 'Lo Barnechea', '48', '1'), ('310', 'Lo Espejo', '48', '1'), ('311', 'Lo Prado', '48', '1'), ('312', 'Macul', '48', '1'), ('313', 'Maipu', '48', '1'), ('314', 'NuNoa', '48', '1'), ('315', 'Pedro Aguirre Cerda', '48', '1'), ('316', 'PeNalolen', '48', '1'), ('317', 'Providencia', '48', '1'), ('318', 'Pudahuel', '48', '1'), ('319', 'Quilicura', '48', '1'), ('320', 'Quinta Normal', '48', '1'), ('321', 'Recoleta', '48', '1'), ('322', 'Renca', '48', '1'), ('323', 'San Joaquin', '48', '1'), ('324', 'San Miguel', '48', '1'), ('325', 'San Ramon', '48', '1'), ('326', 'Vitacura', '48', '1'), ('327', 'Puente Alto', '49', '1'), ('328', 'Pirque', '49', '1'), ('329', 'San Jose de Maipu', '49', '1'), ('330', 'Colina', '50', '1'), ('331', 'Lampa', '50', '1'), ('332', 'Tiltil', '50', '1'), ('333', 'San Bernardo', '51', '1'), ('334', 'Buin', '51', '1'), ('335', 'Calera de Tango', '51', '1'), ('336', 'Paine', '51', '1'), ('337', 'Melipilla', '52', '1'), ('338', 'Alhue', '52', '1'), ('339', 'Curacavi', '52', '1'), ('340', 'Maria Pinto', '52', '1'), ('341', 'San Pedro', '52', '1'), ('342', 'Talagante', '53', '1'), ('343', 'El Monte', '53', '1'), ('344', 'Isla de Maipo', '53', '1'), ('345', 'Padre Hurtado', '53', '1'), ('346', 'PeNaflor', '53', '1'), ('347', 'Puerto Chacabuco (localidad)', '40', '1'), ('348', 'Achao', '37', '1'), ('349', 'Entre Lagos', '38', '1'), ('350', 'La Junta (localidad)', '39', '1'), ('351', 'Puerto Tranquilo', '43', '1'), ('352', 'Pargua', '36', '1'), ('353', 'Labranza (Localidad)', '32', '1'), ('354', 'Pillanlelbun (Localidad)', '32', '1');
COMMIT;

-- ----------------------------
-- Table structure for `man_comuna_provincia`
-- ----------------------------
DROP TABLE IF EXISTS `man_comuna_provincia`;
CREATE TABLE `man_comuna_provincia` (
`id_provincia`  int(4) NOT NULL ,
`nom_provincia`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`n_region`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`capital`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`prefijo_telefonico`  int(4) NULL DEFAULT NULL ,
PRIMARY KEY (`id_provincia`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of man_comuna_provincia
-- ----------------------------
BEGIN;
INSERT INTO `man_comuna_provincia` VALUES ('1', 'Provincia de Arica', '15', 'Arica', '58'), ('2', 'Provincia de Parinacota', '15', 'Putre', '58'), ('3', 'Provincia de Iquique', '1', 'Iquique', '57'), ('4', 'Provincia del Tamarugal', '1', 'Pozo Almonte', '57'), ('5', 'Provincia de Antofagasta', '2', 'Antofagasta', '55'), ('6', 'Provincia de El Loa', '2', 'Calama', '55'), ('7', 'Provincia de Tocopilla', '2', 'Tocopilla', '55'), ('8', 'Provincia de Copiapo', '3', 'Copiapo', '52'), ('9', 'Provincia de ChaNaral', '3', 'ChaNaral', '52'), ('10', 'Provincia de Huasco', '3', 'Vallenar', '51'), ('11', 'Provincia de Elqui', '4', 'Coquimbo', '51'), ('12', 'Provincia de Choapa', '4', 'Illapel', '53'), ('13', 'Provincia de Limari', '4', 'Ovalle', '53'), ('14', 'Provincia de Valparaiso', '5', 'Valparaiso', '32'), ('15', 'Provincia de Isla de Pascua', '5', 'Hanga Roa', '39'), ('16', 'Provincia de Los Andes', '5', 'Los Andes', '34'), ('17', 'Provincia de Petorca', '5', 'La Ligua', '33'), ('18', 'Provincia de Quillota', '5', 'Quillota', '33'), ('19', 'Provincia de San Antonio', '5', 'San Antonio', '35'), ('20', 'Provincia de San Felipe de Aconcagua', '5', 'San Felipe', '34'), ('21', 'Provincia de Cachapoal', '6', 'Rancagua', '72'), ('22', 'Provincia de Cardenal Caro', '6', 'Pichilemu', '72'), ('23', 'Provincia de Colchagua', '6', 'San Fernando', '72'), ('24', 'Provincia de Talca', '7', 'Talca', '71'), ('25', 'Provincia de Cauquenes', '7', 'Cauquenes', '73'), ('26', 'Provincia de Curico', '7', 'Curico', '75'), ('27', 'Provincia de Linares', '7', 'Linares', '73'), ('28', 'Provincia de Concepcion', '8', 'Concepcion', '41'), ('29', 'Provincia de Arauco', '8', 'Lebu', '41'), ('30', 'Provincia de Biobio', '8', 'Los Angeles', '43'), ('31', 'Provincia de Ãƒâ€˜uble', '8', 'Chillan', '42'), ('32', 'Provincia de Cautin', '9', 'Temuco', '45'), ('33', 'Provincia de Malleco', '9', 'Angol', '45'), ('34', 'Provincia de Valdivia', '14', 'Valdivia', '63'), ('35', 'Provincia del Ranco', '14', 'La Union', '63'), ('36', 'Provincia de Llanquihue', '10', 'Puerto Montt', '65'), ('37', 'Provincia de Chiloe', '10', 'Castro', '65'), ('38', 'Provincia de Osorno', '10', 'Osorno', '64'), ('39', 'Provincia de Palena', '10', 'Chaiten', '65'), ('40', 'Provincia de Coyhaique', '11', 'Coyhaique', '67'), ('41', 'Provincia de Aisen', '11', 'Puerto Aisen', '67'), ('42', 'Provincia de Capitan Prat', '11', 'Cochrane', '67'), ('43', 'Provincia de General Carrera', '11', 'Chile Chico', '67'), ('44', 'Provincia de Magallanes', '12', 'Punta Arenas', '61'), ('45', 'Provincia de la Antartica Chilena', '12', 'Puerto Williams', '61'), ('46', 'Provincia de Tierra del Fuego', '12', 'Porvenir', '61'), ('47', 'Provincia de Ultima Esperanza', '12', 'Puerto Natales', '61'), ('48', 'Provincia de Santiago', '13', 'Santiago', '2'), ('49', 'Provincia de Cordillera', '13', 'Puente Alto', '2'), ('50', 'Provincia de Chacabuco', '13', 'Colina', '2'), ('51', 'Provincia de Maipo', '13', 'San Bernardo', '2'), ('52', 'Provincia de Melipilla', '13', 'Melipilla', '2'), ('53', 'Provincia de Talagante', '13', 'Talagante', '2');
COMMIT;

-- ----------------------------
-- Table structure for `man_comuna_region`
-- ----------------------------
DROP TABLE IF EXISTS `man_comuna_region`;
CREATE TABLE `man_comuna_region` (
`n_region`  int(4) NOT NULL ,
`n_romano_region`  varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`nom_region`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`nom_capital`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`orden_geo`  int(2) NULL DEFAULT NULL ,
`zona`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`n_region`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of man_comuna_region
-- ----------------------------
BEGIN;
INSERT INTO `man_comuna_region` VALUES ('1', 'I', 'TARAPACA', 'Iquique', '2', null), ('2', 'II', 'ANTOFAGASTA', 'Antofagasta', '3', null), ('3', 'III', 'ATACAMA', 'Copiapo', '4', null), ('4', 'IV', 'COQUIMBO', 'La Serena', '5', null), ('5', 'V', 'VALPARAISO', 'Valparaiso', '6', null), ('6', 'VI', 'LIB. GRAL. BDO. OHIGGINS', 'Rancagua', '8', null), ('7', 'VII', 'MAULE', 'Talca', '9', null), ('8', 'VIII', 'BIO-BIO', 'Concepcion', '10', null), ('9', 'IX', 'ARAUCANIA', 'Temuco', '11', null), ('10', 'X', 'LOS LAGOS', 'Puerto Montt', '13', null), ('11', 'XI', 'GRAL. C. IBANEZ DEL CAMPO', 'Coyhaique', '14', null), ('12', 'XII', 'MAGALLANES Y ANTARTICA', 'Punta Arenas', '15', null), ('13', 'RM', 'METROPOLITANA', 'Santiago', '7', null), ('14', 'XIV', 'LOS RIOS', 'Valdivia', '12', null), ('15', 'XV', 'ARICA Y PARINACOTA', 'Arica', '1', null);
COMMIT;

-- ----------------------------
-- Table structure for `man_empresa`
-- ----------------------------
DROP TABLE IF EXISTS `man_empresa`;
CREATE TABLE `man_empresa` (
`rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`razon_social`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`contacto`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fono1`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fono2`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`email`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`domicilio`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`id_comuna`  int(4) NULL DEFAULT NULL ,
`estado`  int(1) NULL DEFAULT NULL ,
`reg_rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_fecha`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`rut`),
FOREIGN KEY (`reg_rut`) REFERENCES `man_usuario` (`rut`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `reg_rut` (`reg_rut`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of man_empresa
-- ----------------------------
BEGIN;
INSERT INTO `man_empresa` VALUES ('11111111-1', 'El Sol', 'Jose Gonzalez', '9 5461 9495', '9 7199 1965', 'finderg@gmail.com', 'Portales 115', '100', '1', null, null), ('22222222-2', 'La Bahia', 'Pedro Figueroa', '9 5631 5499', '9 7199 1965', 'finderg@gmail.com', '', '5', '1', '18885254-8', '2018-10-02 19:36:40'), ('33333333-3', 'Prueba', 'Ronald', '123456', '123456', 'ebcorreac1@gmail.com', '', '11', '1', '18885254-8', '2018-10-02 19:36:53'), ('44444444-4', 'Cabanas Villarrica', 'Jaime', '56 9 8888 8888', '.', 'finderg@gmail.com', 'Domicilio', '219', '1', '12707369-4', '2018-10-10 11:19:36');
COMMIT;

-- ----------------------------
-- Table structure for `man_usuario`
-- ----------------------------
DROP TABLE IF EXISTS `man_usuario`;
CREATE TABLE `man_usuario` (
`rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`nombre`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`apellido`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fono`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`email`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`domicilio`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`id_comuna`  int(4) NULL DEFAULT NULL ,
`tipo_usu`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`estado`  int(1) NULL DEFAULT NULL ,
`clave`  varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_fecha`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`rut`),
INDEX `reg_rut` (`reg_rut`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of man_usuario
-- ----------------------------
BEGIN;
INSERT INTO `man_usuario` VALUES ('11111111-1', 'El Sol', '.', '.', '.', '.', '100', 'Agencia', '1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '12707369-4', '2018-09-30 21:51:13'), ('11793385-7', 'Ronald', 'Bascunan', null, null, 'Quepe', '200', 'Admin', '1', '4f2b344c5268b61fb41f14c640aeaf89bb7ae6d7', null, null), ('12707369-4', 'Guillermo', 'Geissbuhler', '9 8451 3307', 'ggeissbuhler@hotmail.com', '8 Norte 01411', '1', 'Admin', '1', '9d92aff367f4cf7e91ff1cfd27e7165ad1f16ae6', '12707369-4', '2018-10-10 11:18:08'), ('18885254-8', 'Emmanuel', 'Correa', '9 7199 1074', 'Ebcorreac@gmail.com', 'Salesianos 480', '211', 'Admin', '1', '7c4a8d09ca3762af61e59520943dc26494f8941b', '18885254-8', '2018-10-02 12:43:30'), ('22222222-2', 'Nombre', 'Apellido', 'Fono', 'email', 'Domicilio', '3', 'Agencia', '1', '9d92aff367f4cf7e91ff1cfd27e7165ad1f16ae6', '18885254-8', '2018-10-01 18:49:32'), ('33333333-3', 'Cabanas Trancura', '.', '8 5698 4598', 'Jaime Fonseca', 'Los Lingues 0246', '214', 'Agencia', '1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '12707369-4', '2018-09-30 21:51:19');
COMMIT;

-- ----------------------------
-- Table structure for `producto`
-- ----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
`id_prod`  int(6) NOT NULL ,
`rut_empr`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`nom_prod`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`id_activ`  int(6) NULL DEFAULT NULL ,
`descripcion`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`sugerencia`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`requisito`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`dificultad`  int(1) NULL DEFAULT NULL ,
`edad_minima`  int(2) NULL DEFAULT NULL ,
`lugar_salida`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`id_comuna`  int(4) NULL DEFAULT NULL ,
`lun`  int(1) NULL DEFAULT NULL ,
`mar`  int(1) NULL DEFAULT NULL ,
`mie`  int(1) NULL DEFAULT NULL ,
`jue`  int(1) NULL DEFAULT NULL ,
`vie`  int(1) NULL DEFAULT NULL ,
`sab`  int(1) NULL DEFAULT NULL ,
`dom`  int(1) NULL DEFAULT NULL ,
`duracion_hr`  time NULL DEFAULT NULL ,
`hr_inicio`  time NULL DEFAULT NULL ,
`precio_normal`  int(8) NULL DEFAULT NULL ,
`precio_nino`  int(8) NULL DEFAULT NULL ,
`precio_adulto`  int(8) NULL DEFAULT NULL ,
`precio_grupo`  int(8) NULL DEFAULT NULL ,
`dscto_normal`  int(2) NULL DEFAULT NULL ,
`dscto_nino`  int(2) NULL DEFAULT NULL ,
`dscto_adulto`  int(2) NULL DEFAULT NULL ,
`dscto_grupo`  int(2) NULL DEFAULT NULL ,
`reg_rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_fecha`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id_prod`),
FOREIGN KEY (`rut_empr`) REFERENCES `man_empresa` (`rut`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`id_activ`) REFERENCES `man_actividad` (`id_activ`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`id_comuna`) REFERENCES `man_comuna` (`id_comuna`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`reg_rut`) REFERENCES `man_usuario` (`rut`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `rut_empr` (`rut_empr`) USING BTREE ,
INDEX `id_activ` (`id_activ`) USING BTREE ,
INDEX `id_comuna` (`id_comuna`) USING BTREE ,
INDEX `reg_rut` (`reg_rut`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of producto
-- ----------------------------
BEGIN;
INSERT INTO `producto` VALUES ('1', '11111111-1', 'Cabalgata', '6', 'Cabalgata Por Parque', 'Sugerencias', 'Requisitos', '2', '10', 'Lugar Salida', '100', '0', '0', '0', '0', '1', '1', '1', '08:18:00', '08:28:00', '25000', '20000', '20000', '18000', '10', '10', '10', '10', '12707369-4', '2018-10-07 00:09:36'), ('2', '33333333-3', 'Volcal Villarrica', '2', 'Tour Pucon Y Alta Montana Volcan Villarrica', 'Llevar Protector Solar, Agua', 'Cualquier Edad Y No Debe Tener Enfermedad Cardiaca', '3', '11', 'Frente Hotel Pucon', '214', '0', '0', '0', '1', '1', '0', '1', '07:17:00', '09:29:00', '50000', '45000', '45000', '45000', '9', '8', '8', '8', '12707369-4', '2018-10-07 00:48:59'), ('3', '11111111-1', 'Paseo Bicicleta', '8', 'Paseo En Bicileta De Montana Por La Ruta Ciclovia De Malalcahuello. Para Disfrutar Con Toda La Familia.', 'Llevar Ropa Adecuada A La Actividad. Ropa Deportiva.', 'Mayores De 14 Anos Y Tener Salud Compatible Para La Actividad Fisica', '1', '12', 'La Playa', '32', '0', '1', '1', '1', '1', '1', '1', '06:16:00', '10:30:00', '15000', '12000', '12000', '12000', '5', '4', '3', '2', '12707369-4', '2018-10-08 20:50:52'), ('4', '22222222-2', 'Paseo En Banano', '20', 'Esta Es La Descripcion', 'Llevar Bloqueador Solar', 'Saber Flotar', '2', '12', 'Lugar Salida', '214', '0', '0', '0', '0', '1', '1', '1', '00:30:00', '11:01:00', '10000', '9000', '8000', '7000', '10', '9', '8', '7', '12707369-4', '2018-10-07 00:09:18'), ('5', '44444444-4', 'Cabanas Y Habitaciones', '1', 'Se Ofrece Alojamiento', '.', '.', '1', '0', '.', '219', '1', '1', '1', '1', '1', '1', '1', '24:00:00', '11:00:00', '20000', '20000', '20000', '18000', '0', '0', '0', '0', '12707369-4', '2018-10-10 11:52:58');
COMMIT;

-- ----------------------------
-- Table structure for `producto_archivo`
-- ----------------------------
DROP TABLE IF EXISTS `producto_archivo`;
CREATE TABLE `producto_archivo` (
`id_prod`  int(6) NOT NULL ,
`nom_arch`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`tipo_arch`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`tam_arch`  int(13) NULL DEFAULT NULL ,
`reg_rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_fecha`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id_prod`, `nom_arch`),
FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`reg_rut`) REFERENCES `man_usuario` (`rut`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `reg_rut` (`reg_rut`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of producto_archivo
-- ----------------------------
BEGIN;
INSERT INTO `producto_archivo` VALUES ('1', '1_11111111-1_cabalgata.jpg', 'image/jpeg', '160481', '12707369-4', '2018-10-07 00:05:06'), ('2', '2_33333333-3_alta montana.jpg', 'image/jpeg', '3257779', '12707369-4', '2018-10-10 04:01:20'), ('3', '3_11111111-1_paseo_bicicleta.jpg', 'image/jpeg', '154677', '12707369-4', '2018-10-07 00:06:13'), ('4', '4_22222222-2_banano.JPG', 'image/jpeg', '43708', '12707369-4', '2018-10-07 00:01:27'), ('5', '5_44444444-4_44.jpg', 'image/jpeg', '78442', '12707369-4', '2018-10-10 16:53:41');
COMMIT;

-- ----------------------------
-- Table structure for `producto_horario`
-- ----------------------------
DROP TABLE IF EXISTS `producto_horario`;
CREATE TABLE `producto_horario` (
`id_hr`  int(6) NOT NULL ,
`id_prod`  int(6) NULL DEFAULT NULL ,
`detalle`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`hr_ini`  time NULL DEFAULT NULL ,
`hr_fin`  time NULL DEFAULT NULL ,
`reg_rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`reg_fecha`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id_hr`),
FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`) ON DELETE RESTRICT ON UPDATE RESTRICT,
FOREIGN KEY (`reg_rut`) REFERENCES `man_usuario` (`rut`) ON DELETE RESTRICT ON UPDATE RESTRICT,
INDEX `id_prod` (`id_prod`) USING BTREE ,
INDEX `reg_rut` (`reg_rut`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of producto_horario
-- ----------------------------
BEGIN;
INSERT INTO `producto_horario` VALUES ('1', '2', 'Dia1 Hasta Dia3 - Llegada Y Alojamiento A Hotel', '12:01:00', '10:59:00', '12707369-4', '2018-09-30 15:30:14'), ('2', '2', 'Dia3 - Inicio Subida Hasta Campamento Base', '08:30:00', '20:00:00', '12707369-4', '2018-09-30 20:45:16'), ('3', '2', 'Dia4 - Sendero De Cabernas Y Escalada', '08:30:00', '20:00:00', '12707369-4', '2018-09-24 14:26:02'), ('4', '2', 'Dia2 - Paseo Por Pucon', '08:30:00', '20:00:00', '12707369-4', '2018-09-24 14:28:05'), ('6', '4', '1er Horario', '09:00:00', '10:00:00', '12707369-4', '2018-09-30 15:20:48'), ('7', '4', '2do Horario', '11:00:00', '12:00:00', '12707369-4', '2018-09-30 15:21:06'), ('8', '4', '3er Horario', '13:00:00', '14:00:00', '12707369-4', '2018-09-30 15:23:04'), ('9', '2', 'Dia5 - Llegada A Cima', '10:00:00', '17:00:00', '12707369-4', '2018-10-03 10:27:17');
COMMIT;

-- ----------------------------
-- Table structure for `registro_login`
-- ----------------------------
DROP TABLE IF EXISTS `registro_login`;
CREATE TABLE `registro_login` (
`id`  int(6) NOT NULL AUTO_INCREMENT ,
`rut`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`nombre`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`ip`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`login`  varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fecha_reg`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=70

;

-- ----------------------------
-- Records of registro_login
-- ----------------------------
BEGIN;
INSERT INTO `registro_login` VALUES ('1', '12707369-4', 'Guillermo Geissbuhler', '186.104.255.53', 'In', '2018-09-30 20:41:42'), ('2', '11793385-7', 'Ronald Bascunan', '191.126.139.17', 'In', '2018-09-30 21:40:19'), ('3', '11111111-1', 'El Sol .', '191.126.139.17', 'Out', '2018-09-30 21:44:33'), ('4', '11111111-1', 'El Sol .', '191.126.139.17', 'Out', '2018-09-30 21:50:46'), ('5', '11111111-1', 'El Sol .', '186.104.255.53', 'Out', '2018-09-30 21:50:51'), ('6', '12707369-4', 'Guillermo Geissbuhler', '186.104.255.53', 'In', '2018-09-30 21:51:01'), ('7', '11111111-1', 'El Sol .', '186.104.255.53', 'Out', '2018-09-30 21:51:54'), ('8', '11111111-1', 'El Sol .', '186.104.255.53', 'Out', '2018-09-30 21:52:02'), ('9', '12707369-4', 'Guillermo Geissbuhler', '186.104.255.53', 'In', '2018-09-30 21:52:14'), ('10', '11111111-1', 'El Sol .', '186.104.255.53', 'Out', '2018-09-30 21:52:29'), ('11', '11111111-1', 'El Sol .', '191.126.139.17', 'Out', '2018-09-30 21:52:39'), ('12', '11111111-1', 'El Sol .', '186.104.255.53', 'In', '2018-09-30 21:52:41'), ('13', '11111111-1', 'El Sol .', '186.104.255.53', 'In', '2018-09-30 21:53:52'), ('14', '11111111-1', 'El Sol .', '191.126.139.17', 'In', '2018-09-30 21:54:38'), ('15', '12707369-4', 'Guillermo Geissbuhler', '186.104.255.53', 'In', '2018-09-30 23:15:34'), ('16', '11111111-1', 'El Sol .', '191.126.139.17', 'In', '2018-10-01 00:08:02'), ('17', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 09:41:12'), ('18', '11111111-1', 'El Sol .', '186.104.241.209', 'In', '2018-10-01 09:44:36'), ('19', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 11:32:59'), ('20', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 11:37:23'), ('21', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 11:59:28'), ('22', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 12:34:55'), ('23', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 12:37:54'), ('24', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 12:42:44'), ('25', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 12:44:11'), ('26', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 13:38:24'), ('27', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 13:48:55'), ('28', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 15:02:49'), ('29', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 16:04:36'), ('30', '18885254-8', 'Emanuel Correa', '186.107.178.177', 'In', '2018-10-01 18:37:11'), ('31', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 19:06:57'), ('32', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-01 20:07:04'), ('33', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 21:17:31'), ('34', '12707369-4', 'Guillermo Geissbuhler', '186.104.241.209', 'In', '2018-10-01 21:24:17'), ('35', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-01 21:31:21'), ('36', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-01 23:43:09'), ('37', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-02 10:50:00'), ('38', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'Out', '2018-10-02 11:13:23'), ('39', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-02 11:13:35'), ('40', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-02 11:52:19'), ('41', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-02 12:02:53'), ('42', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-02 12:17:24'), ('43', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-02 12:42:34'), ('44', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-02 12:43:19'), ('45', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-02 15:09:59'), ('46', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-02 15:14:40'), ('47', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-02 15:15:18'), ('48', '11793385-7', 'Ronald Bascunan', '191.126.20.120', 'In', '2018-10-02 15:22:07'), ('49', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-02 19:32:53'), ('50', '18885254-8', 'Emmanuel Correa', '186.107.178.177', 'In', '2018-10-02 19:36:29'), ('51', '11793385-7', 'Ronald Bascunan', '191.125.60.216', 'In', '2018-10-02 22:14:56'), ('52', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-02 22:27:06'), ('53', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-03 08:14:35'), ('54', '12707369-4', 'Guillermo Geissbuhler', '186.9.48.220', 'In', '2018-10-03 10:13:53'), ('55', '12707369-4', 'Guillermo Geissbuhler', '186.105.206.255', 'In', '2018-10-03 16:43:22'), ('56', '12707369-4', 'Guillermo Geissbuhler', '186.105.202.92', 'In', '2018-10-03 20:10:36'), ('57', '12707369-4', 'Guillermo Geissbuhler', '186.105.202.92', 'In', '2018-10-04 00:57:24'), ('58', '12707369-4', 'Guillermo Geissbuhler', '186.105.202.92', 'In', '2018-10-04 08:06:13'), ('59', '18885254-8', 'Emmanuel Correa', '186.107.223.167', 'In', '2018-10-04 22:39:06'), ('60', '11793385-7', 'Ronald Bascunan', '191.125.179.70', 'In', '2018-10-05 14:04:53'), ('61', '12707369-4', 'Guillermo Geissbuhler', '186.105.221.140', 'In', '2018-10-06 15:35:53'), ('62', '12707369-4', 'Guillermo Geissbuhler', '186.105.221.140', 'In', '2018-10-06 23:58:52'), ('63', '11793385-7', 'Ronald Bascunan', '191.125.42.66', 'In', '2018-10-07 02:17:30'), ('64', '12707369-4', 'Guillermo Geissbuhler', '186.104.232.108', 'In', '2018-10-08 11:30:19'), ('65', '12707369-4', 'Guillermo Geissbuhler', '186.104.227.226', 'In', '2018-10-08 20:50:14'), ('66', '12707369-4', 'Guillermo Geissbuhler', '::1', 'In', '2018-10-09 22:59:27'), ('67', '12707369-4', 'Guillermo Geissbuhler', '::1', 'In', '2018-10-10 10:42:59'), ('68', '77777777-7', '', '::1', 'Out', '2018-10-10 11:50:12'), ('69', '12707369-4', 'Guillermo Geissbuhler', '::1', 'In', '2018-10-10 11:50:25');
COMMIT;

-- ----------------------------
-- Auto increment value for `man_comuna`
-- ----------------------------
ALTER TABLE `man_comuna` AUTO_INCREMENT=355;

-- ----------------------------
-- Auto increment value for `registro_login`
-- ----------------------------
ALTER TABLE `registro_login` AUTO_INCREMENT=70;
