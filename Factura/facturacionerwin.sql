/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50711
Source Host           : 127.0.0.1:3306
Source Database       : facturacionerwin

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2017-03-17 15:30:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tab_anticipo
-- ----------------------------
DROP TABLE IF EXISTS `tab_anticipo`;
CREATE TABLE `tab_anticipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_anticipo` char(10) DEFAULT NULL,
  `descripcion_anticipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_anticipo
-- ----------------------------
INSERT INTO `tab_anticipo` VALUES ('1', '01', 'Factura – emitida para corregir error en el RUC');
INSERT INTO `tab_anticipo` VALUES ('2', '02', 'Factura – emitida por anticipos');
INSERT INTO `tab_anticipo` VALUES ('3', '03', 'Boleta de Venta – emitida por anticipos');
INSERT INTO `tab_anticipo` VALUES ('4', '04', 'Ticket de Salida - ENAPU');
INSERT INTO `tab_anticipo` VALUES ('5', '05', 'Código SCOP');
INSERT INTO `tab_anticipo` VALUES ('6', '99', 'Otros');

-- ----------------------------
-- Table structure for tab_detalle_invoice
-- ----------------------------
DROP TABLE IF EXISTS `tab_detalle_invoice`;
CREATE TABLE `tab_detalle_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_doc` varchar(20) DEFAULT NULL,
  `cod_prod` char(10) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `cantidad` char(10) DEFAULT NULL,
  `uni_medida` char(10) DEFAULT NULL,
  `pre_unitario` decimal(10,2) DEFAULT NULL,
  `pre_referencial` decimal(10,2) DEFAULT NULL,
  `tipo_precio` char(10) DEFAULT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL,
  `tipo_inpuesto` char(10) DEFAULT NULL,
  `isc` decimal(10,2) DEFAULT NULL,
  `otro_impuesto` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_detalle_invoice
-- ----------------------------
INSERT INTO `tab_detalle_invoice` VALUES ('1', 'FF11-00000444', null, 's', '1', 'NIU', '160.00', '0.00', '01', '24.41', '10', '0.00', '0.00', '135.59', '160.00');
INSERT INTO `tab_detalle_invoice` VALUES ('2', 'FF11-00000446', '1', 'producto prueba', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('3', 'FF11-00000447', '1', 'producto prueba', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('4', 'FF11-00000449', '1', 'producto prueba', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('5', 'FF11-00000450', '1', 'producto prueba', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('6', 'FF11-00000452', '1', 'producto prueba', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('7', 'FF11-00000453', '1', 'producto prueba', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('8', 'FF11-00000033', '1', 'sss', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('9', 'FF11-00000034', '1', 'sss', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('10', 'FF11-00000035', '1', 'sss', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('11', 'FF11-00000036', '1', 'sss', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('12', 'FF11-00000037', '1', 'sss', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('13', 'FF11-00000038', '1', 'sss', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('14', 'FF11-00000039', '1', 'sss', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('15', 'FF11-00000456', '1', '150\n1', '2', 'NIU', '150.00', '0.00', '01', '45.76', '10', '0.00', '0.00', '254.24', '300.00');
INSERT INTO `tab_detalle_invoice` VALUES ('16', 'FF11-00000457', '1', '150\n1', '2', 'NIU', '150.00', '0.00', '01', '45.76', '10', '0.00', '0.00', '254.24', '300.00');
INSERT INTO `tab_detalle_invoice` VALUES ('17', 'FF11-00000458', '1', '150\n1', '2', 'NIU', '150.00', '0.00', '01', '45.76', '10', '0.00', '0.00', '254.24', '300.00');
INSERT INTO `tab_detalle_invoice` VALUES ('18', 'FF11-00000459', '1', '150\n1', '2', 'NIU', '150.00', '0.00', '01', '45.76', '10', '0.00', '0.00', '254.24', '300.00');
INSERT INTO `tab_detalle_invoice` VALUES ('19', 'FF11-00000460', '1', '150\n1', '2', 'NIU', '150.00', '0.00', '01', '45.76', '10', '0.00', '0.00', '254.24', '300.00');
INSERT INTO `tab_detalle_invoice` VALUES ('20', 'FF11-00000461', '1', 'prueba', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('21', 'FF11-00000462', 'a', 'a', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('22', 'FF11-00000463', 'a', 'a', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('23', 'FF11-00000464', 'a', 'a', '1', 'NIU', '200.00', '0.00', '01', '30.51', '10', '0.00', '0.00', '169.49', '200.00');
INSERT INTO `tab_detalle_invoice` VALUES ('24', 'FF11-00000465', 'd', '1', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');
INSERT INTO `tab_detalle_invoice` VALUES ('25', 'FF11-00000466', 'd', '1', '1', 'NIU', '150.00', '0.00', '01', '22.88', '10', '0.00', '0.00', '127.12', '150.00');

-- ----------------------------
-- Table structure for tab_documentoidentidad
-- ----------------------------
DROP TABLE IF EXISTS `tab_documentoidentidad`;
CREATE TABLE `tab_documentoidentidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_docuident` char(10) DEFAULT NULL,
  `descripcion_docuident` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_documentoidentidad
-- ----------------------------
INSERT INTO `tab_documentoidentidad` VALUES ('1', '0', 'DOC.TRIB.NO.DOM.SIN.RUC');
INSERT INTO `tab_documentoidentidad` VALUES ('2', '1', 'DOC. NACIONAL DE IDENTIDAD');
INSERT INTO `tab_documentoidentidad` VALUES ('3', '4', 'CARNET DE EXTRANJERIA');
INSERT INTO `tab_documentoidentidad` VALUES ('4', '6', 'REG. UNICO DE CONTRIBUYENTES');
INSERT INTO `tab_documentoidentidad` VALUES ('5', '7', 'PASAPORTE');
INSERT INTO `tab_documentoidentidad` VALUES ('6', 'A', 'CED. DIPLOMATICA DE IDENTIDAD');

-- ----------------------------
-- Table structure for tab_documentorelacionado
-- ----------------------------
DROP TABLE IF EXISTS `tab_documentorelacionado`;
CREATE TABLE `tab_documentorelacionado` (
  `id_relacionado` int(11) NOT NULL AUTO_INCREMENT,
  `cod_relacionado` char(2) DEFAULT NULL,
  `des_relacionado` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_relacionado`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_documentorelacionado
-- ----------------------------
INSERT INTO `tab_documentorelacionado` VALUES ('1', '01', 'FACTURA');
INSERT INTO `tab_documentorelacionado` VALUES ('2', '03', 'BOLETA DE VENTA');
INSERT INTO `tab_documentorelacionado` VALUES ('3', '07', 'NOTA DE CREDITO');
INSERT INTO `tab_documentorelacionado` VALUES ('4', '08', 'NOTA DE DEBITO');
INSERT INTO `tab_documentorelacionado` VALUES ('5', '09', 'GUIA DE REMISIÓN REMITENTE');
INSERT INTO `tab_documentorelacionado` VALUES ('6', '13', 'DOCUMENTO EMITIDO POR BANCOS II.FF. CREDITICIAS Y DE SEGUROS');
INSERT INTO `tab_documentorelacionado` VALUES ('7', '18', 'DOCUMENTOS EMITIDOS POR LAS AFP');
INSERT INTO `tab_documentorelacionado` VALUES ('8', '31', 'GUIA DE REMISIÓN TRANSPORTISTA');
INSERT INTO `tab_documentorelacionado` VALUES ('9', '56', 'COMPROBANTE DE PAGO SEAE');

-- ----------------------------
-- Table structure for tab_invoice
-- ----------------------------
DROP TABLE IF EXISTS `tab_invoice`;
CREATE TABLE `tab_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_doc` varchar(5) DEFAULT NULL,
  `num_doc` varchar(20) DEFAULT NULL,
  `num_doc_cli` char(11) DEFAULT NULL,
  `nom_cli` varchar(50) DEFAULT NULL,
  `dir_cli` varchar(100) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `gravadas` decimal(10,2) DEFAULT NULL,
  `exoneradas` decimal(10,2) DEFAULT NULL,
  `inafectas` decimal(10,2) DEFAULT NULL,
  `gratuitas` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `igv` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `respuesta` varchar(150) DEFAULT NULL,
  `nomarchivo` varchar(50) DEFAULT NULL,
  `nompdf` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_invoice
-- ----------------------------
INSERT INTO `tab_invoice` VALUES ('1', '01', null, '10479617967', 'ERWIN', '', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', '', '', null, null);
INSERT INTO `tab_invoice` VALUES ('2', '01', 'FF11-00000436', '10479617967', 'ERWIN', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', '', '', null, null);
INSERT INTO `tab_invoice` VALUES ('3', '01', 'FF11-00000437', '10479617967', 'ERWIN', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', '0', 'La Factura numero FF11-00000437, ha sido aceptada', null, null);
INSERT INTO `tab_invoice` VALUES ('4', '01', 'FF11-00000439', '10479617967', 'sa', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', null, null, null, null);
INSERT INTO `tab_invoice` VALUES ('5', '01', 'FF11-00000440', '10479617967', 'sa', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', null, null, null, null);
INSERT INTO `tab_invoice` VALUES ('6', '01', 'FF11-00000441', '10479617967', 'sa', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', null, null, null, null);
INSERT INTO `tab_invoice` VALUES ('7', '01', 'FF11-00000442', '10479617967', 'sa', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', 'soap-env:C', 'RegistrationName -  El dato ingresado no cumple con el estandar\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489517716975 error: Error', null, null);
INSERT INTO `tab_invoice` VALUES ('8', '01', 'FF11-00000443', '10479617967', 'sa', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', 'soap-env:Client.2022', 'RegistrationName -  El dato ingresado no cumple con el estandar\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489517741740 error: Error', null, null);
INSERT INTO `tab_invoice` VALUES ('9', '01', 'FF11-00000444', '10479617967', 'sa', '', '2017-03-14', '135.59', '0.00', '0.00', '0.00', '135.59', '24.41', '160.00', 'soap-env:Client.2022', 'RegistrationName -  El dato ingresado no cumple con el estandar\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489524724883 error: Error', null, null);
INSERT INTO `tab_invoice` VALUES ('10', '01', 'FF11-00000446', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-14', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', '0', 'La Factura numero FF11-00000446, ha sido aceptada', null, null);
INSERT INTO `tab_invoice` VALUES ('11', '01', 'FF11-00000447', '10479617967', 'h', '', '2017-03-14', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', 'soap-env:Client.2022', 'RegistrationName -  El dato ingresado no cumple con el estandar\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489525133389 error: Error', null, null);
INSERT INTO `tab_invoice` VALUES ('12', '01', 'FF11-00000449', '10479617967', 'h', '', '2017-03-14', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', ' 2022', 'RegistrationName -  El dato ingresado no cumple con el estandar\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489525349054 error: Error', null, null);
INSERT INTO `tab_invoice` VALUES ('13', '01', 'FF11-00000450', '12365478965', 'v', '', '2017-03-14', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', ' 2022', 'RegistrationName -  El dato ingresado no cumple con el estandar\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489525377971 error: Error', null, null);
INSERT INTO `tab_invoice` VALUES ('14', '01', 'FF11-00000452', '10479617967', 'ERWIN', '', '2017-03-14', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', '0', 'La Factura numero FF11-00000452, ha sido aceptada', null, null);
INSERT INTO `tab_invoice` VALUES ('15', '01', 'FF11-00000453', '10479617967', 'ERWIN', '', '2017-03-14', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', '0', 'La Factura numero FF11-00000453, ha sido aceptada', null, null);
INSERT INTO `tab_invoice` VALUES ('16', '07', 'FF11-00000033', '10479617967', 'TORRES LEON ERWIN STALIN', 'MZA. J3 LOTE. 10 URB. COSSIO DEL POMAR (AL FRENTE DE FERRETERIA HENRY) PIURA - PIURA - CASTILLA', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', ' 2414', 'No se ha consignado en la nota el tag cac:DiscrepancyResponse\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489528937396 error: Error E', null, null);
INSERT INTO `tab_invoice` VALUES ('17', '07', 'FF11-00000034', '10479617967', 'TORRES LEON ERWIN STALIN', 'MZA. J3 LOTE. 10 URB. COSSIO DEL POMAR (AL FRENTE DE FERRETERIA HENRY) PIURA - PIURA - CASTILLA', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', ' 2414', 'No se ha consignado en la nota el tag cac:DiscrepancyResponse\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489528952479 error: Error E', null, null);
INSERT INTO `tab_invoice` VALUES ('18', '07', 'FF11-00000035', '10479617967', 'TORRES LEON ERWIN STALIN', 'MZA. J3 LOTE. 10 URB. COSSIO DEL POMAR (AL FRENTE DE FERRETERIA HENRY) PIURA - PIURA - CASTILLA', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', ' 2016', 'AdditionalAccountID -  El dato ingresado  en el tipo de documento de identidad del receptor no cumple con el estandar o no esta permitido.\n           ', null, null);
INSERT INTO `tab_invoice` VALUES ('19', '07', 'FF11-00000036', '10479617967', 'TORRES LEON ERWIN STALIN', 'MZA. J3 LOTE. 10 URB. COSSIO DEL POMAR (AL FRENTE DE FERRETERIA HENRY) PIURA - PIURA - CASTILLA', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', ' 2365', 'El comprobante contiene un tipo y número de Documento Relacionado repetido\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489528988344 e', null, null);
INSERT INTO `tab_invoice` VALUES ('20', '07', 'FF11-00000037', '10479617967', 'TORRES LEON ERWIN STALIN', 'MZA. J3 LOTE. 10 URB. COSSIO DEL POMAR (AL FRENTE DE FERRETERIA HENRY) PIURA - PIURA - CASTILLA', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', ' 2136', 'El XML no contiene el tag o no existe informacion de cac:DiscrepancyResponse/cbc:Description\n            Detalle:\n            xxx.xxx.xxx value=\'ticke', null, null);
INSERT INTO `tab_invoice` VALUES ('21', '07', 'FF11-00000038', '10479617967', 'TORRES LEON ERWIN STALIN', 'MZA. J3 LOTE. 10 URB. COSSIO DEL POMAR (AL FRENTE DE FERRETERIA HENRY) PIURA - PIURA - CASTILLA', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', ' 2365', 'El comprobante contiene un tipo y número de Documento Relacionado repetido\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489529031889 e', null, null);
INSERT INTO `tab_invoice` VALUES ('22', '07', 'FF11-00000039', '10479617967', 'TORRES LEON ERWIN STALIN', 'MZA. J3 LOTE. 10 URB. COSSIO DEL POMAR (AL FRENTE DE FERRETERIA HENRY) PIURA - PIURA - CASTILLA', '2017-03-14', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', '0', 'La Nota de Credito numero FF11-00000039, ha sido aceptada', null, null);
INSERT INTO `tab_invoice` VALUES ('23', '01', 'FF11-00000456', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '254.24', '0.00', '0.00', '0.00', '254.24', '45.76', '300.00', '0', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000456.zip', '20102501293-2017-03-16-FF11-00000456');
INSERT INTO `tab_invoice` VALUES ('24', '01', 'FF11-00000457', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '254.24', '0.00', '0.00', '0.00', '254.24', '45.76', '300.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000457.zip', '20102501293-2017-03-16-FF11-00000457');
INSERT INTO `tab_invoice` VALUES ('25', '01', 'FF11-00000458', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '254.24', '0.00', '0.00', '0.00', '254.24', '45.76', '300.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000458.zip', '20102501293-2017-03-16-FF11-00000458');
INSERT INTO `tab_invoice` VALUES ('26', '01', 'FF11-00000459', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '254.24', '0.00', '0.00', '0.00', '254.24', '45.76', '300.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000459', '20102501293-2017-03-16-FF11-00000459');
INSERT INTO `tab_invoice` VALUES ('27', '01', 'FF11-00000460', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '254.24', '0.00', '0.00', '0.00', '254.24', '45.76', '300.00', null, null, '20102501293-01-FF11-00000460', '20102501293-2017-03-16-FF11-00000460');
INSERT INTO `tab_invoice` VALUES ('28', '01', 'FF11-00000461', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000461', '20102501293-2017-03-16-FF11-00000461');
INSERT INTO `tab_invoice` VALUES ('29', '01', 'FF11-00000462', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000462', '20102501293-2017-03-16-FF11-00000462');
INSERT INTO `tab_invoice` VALUES ('30', '01', 'FF11-00000463', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000463', '20102501293-2017-03-16-FF11-00000463');
INSERT INTO `tab_invoice` VALUES ('31', '01', 'FF11-00000464', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-16', '169.49', '0.00', '0.00', '0.00', '169.49', '30.51', '200.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000464', '20102501293-2017-03-16-FF11-00000464');
INSERT INTO `tab_invoice` VALUES ('32', '01', 'FF11-00000465', '10479617967', 'TORRES LEON ERWIN STALIN', '', '2017-03-17', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', 'WSDL', 'SOAP-ERROR: Parsing WSDL: Couldn\'t load from \'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl\' : failed to load external entity \"htt', '20102501293-01-FF11-00000465', '20102501293-2017-03-17-FF11-00000465');
INSERT INTO `tab_invoice` VALUES ('33', '01', 'FF11-00000466', '10479617967', 's', '', '2017-03-17', '127.12', '0.00', '0.00', '0.00', '127.12', '22.88', '150.00', ' 2022', 'RegistrationName -  El dato ingresado no cumple con el estandar\n            Detalle:\n            xxx.xxx.xxx value=\'ticket: 1489775655002 error: Error', '20102501293-01-FF11-00000466', '20102501293-2017-03-17-FF11-00000466');

-- ----------------------------
-- Table structure for tab_numeracion
-- ----------------------------
DROP TABLE IF EXISTS `tab_numeracion`;
CREATE TABLE `tab_numeracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_documento` varchar(5) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nom_documento` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `serie` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `numeracion` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- ----------------------------
-- Records of tab_numeracion
-- ----------------------------
INSERT INTO `tab_numeracion` VALUES ('1', '01', 'Factura', 'FF11', '467');
INSERT INTO `tab_numeracion` VALUES ('2', '03', 'Boleta', 'BB11', '7');
INSERT INTO `tab_numeracion` VALUES ('3', '07', 'Nota de Crédito', 'FF11', '40');
INSERT INTO `tab_numeracion` VALUES ('4', '08', 'Nota de Débito', 'FF11', '9');
INSERT INTO `tab_numeracion` VALUES ('5', 'RA', 'Comunicación de Baja', 'R001', '1');

-- ----------------------------
-- Table structure for tab_parametros
-- ----------------------------
DROP TABLE IF EXISTS `tab_parametros`;
CREATE TABLE `tab_parametros` (
  `param_id` int(11) NOT NULL AUTO_INCREMENT,
  `param_codparam` varchar(15) NOT NULL,
  `param_descripcion` varchar(100) NOT NULL,
  `param_valor` char(10) DEFAULT NULL,
  `param_estado` char(2) DEFAULT NULL,
  `tipparam_id` int(11) NOT NULL,
  PRIMARY KEY (`param_id`),
  KEY `tipparam_id` (`tipparam_id`),
  CONSTRAINT `tab_parametros_ibfk_1` FOREIGN KEY (`tipparam_id`) REFERENCES `tab_tipparam` (`tipparam_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_parametros
-- ----------------------------
INSERT INTO `tab_parametros` VALUES ('1', '01', 'Precio unitario (incluye el IGV)', null, 'AC', '1');
INSERT INTO `tab_parametros` VALUES ('2', '02', 'Valor refencial unitario en operaciones no onerosas', null, 'AC', '1');
INSERT INTO `tab_parametros` VALUES ('3', '10', 'Gravado - Operación Onerosa', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('4', '11', 'Gravado – Retiro por premio', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('5', '12', 'Gravado – Retiro por donación', '', 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('6', '13', 'Gravado – Retiro', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('7', '14', 'Gravado – Retiro por publicidad', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('8', '15', 'Gravado – Bonificaciones', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('9', '16', 'Gravado – Retiro por entrega a trabajadores', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('10', '17', 'Gravado – IVAP', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('11', '20', 'Exonerado - Operación Onerosa', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('12', '21', 'Exonerado – Transferencia Gratuita', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('13', '30', 'Inafecto - Operación Onerosa', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('14', '31', 'Inafecto – Retiro por Bonificación', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('15', '32', 'Inafecto – Retiro', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('16', '33', 'Inafecto – Retiro por Muestras Médicas', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('17', '34', 'Inafecto - Retiro por Convenio Colectivo', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('18', '35', 'Inafecto – Retiro por premio', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('19', '36', 'Inafecto - Retiro por publicidad', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('20', '40', 'Exportación', null, 'AC', '2');
INSERT INTO `tab_parametros` VALUES ('21', 'NIU', 'Unidad', null, 'AC', '3');
INSERT INTO `tab_parametros` VALUES ('22', 'KG', 'Kilogramos', null, 'AC', '3');
INSERT INTO `tab_parametros` VALUES ('23', 'LRB', 'Libras', null, 'AC', '3');
INSERT INTO `tab_parametros` VALUES ('24', 'ONZ', 'Onza', null, 'AC', '3');
INSERT INTO `tab_parametros` VALUES ('25', 'LTR', 'Litro', null, 'AC', '3');

-- ----------------------------
-- Table structure for tab_tipodatoadicional
-- ----------------------------
DROP TABLE IF EXISTS `tab_tipodatoadicional`;
CREATE TABLE `tab_tipodatoadicional` (
  `id_adicional` int(11) NOT NULL AUTO_INCREMENT,
  `cod_adicional` char(11) DEFAULT NULL,
  `descripcion_adicional` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_adicional`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_tipodatoadicional
-- ----------------------------
INSERT INTO `tab_tipodatoadicional` VALUES ('1', '3000', 'Detracciones: CODIGO DE BB Y SS SUJETOS A DETRACCION');
INSERT INTO `tab_tipodatoadicional` VALUES ('2', '3001', 'Detracciones: NUMERO DE CTA EN EL BN');
INSERT INTO `tab_tipodatoadicional` VALUES ('3', '3002', 'Detracciones: Recursos Hidrobiológicos - Nombre y matrícula de la embarcación');
INSERT INTO `tab_tipodatoadicional` VALUES ('4', '3003', 'Detracciones: Recursos Hidrobiológicos - Tipo y cantidad de especie vendida');
INSERT INTO `tab_tipodatoadicional` VALUES ('5', '3004', 'Detracciones: Recursos Hidrobiológicos - Lugar de descarga');
INSERT INTO `tab_tipodatoadicional` VALUES ('6', '3005', 'Detracciones: Recursos Hidrobiológicos - Fecha de descarga');
INSERT INTO `tab_tipodatoadicional` VALUES ('7', '3006', 'Detracciones: Transporte Bienes vía terrestre – Numero Registro MTC');
INSERT INTO `tab_tipodatoadicional` VALUES ('8', '3007', 'Detracciones: Transporte Bienes vía terrestre – configuración vehicular');
INSERT INTO `tab_tipodatoadicional` VALUES ('9', '3008', 'Detracciones: Transporte Bienes vía terrestre – punto de origen');
INSERT INTO `tab_tipodatoadicional` VALUES ('10', '3009', 'Detracciones: Transporte Bienes vía terrestre – punto destino');
INSERT INTO `tab_tipodatoadicional` VALUES ('11', '3010', 'Detracciones: Transporte Bienes vía terrestre – valor referencial preliminar');
INSERT INTO `tab_tipodatoadicional` VALUES ('12', '4000', 'Beneficio hospedajes: Código País de emisión del pasaporte');
INSERT INTO `tab_tipodatoadicional` VALUES ('13', '4001', 'Beneficio hospedajes: Código País de residencia del sujeto no domiciliado');
INSERT INTO `tab_tipodatoadicional` VALUES ('14', '4002', 'Beneficio Hospedajes: Fecha de ingreso al país');
INSERT INTO `tab_tipodatoadicional` VALUES ('15', '4003', 'Beneficio Hospedajes: Fecha de ingreso al establecimiento');
INSERT INTO `tab_tipodatoadicional` VALUES ('16', '4004', 'Beneficio Hospedajes: Fecha de salida del establecimiento');
INSERT INTO `tab_tipodatoadicional` VALUES ('17', '4005', 'Beneficio Hospedajes: Número de días de permanencia');
INSERT INTO `tab_tipodatoadicional` VALUES ('18', '4006', 'Beneficio Hospedajes: Fecha de consumo');
INSERT INTO `tab_tipodatoadicional` VALUES ('19', '4007', 'Beneficio Hospedajes: Paquete turístico - Nombres y Apellidos del Huésped');
INSERT INTO `tab_tipodatoadicional` VALUES ('20', '4008', 'Beneficio Hospedajes: Paquete turístico – Tipo documento identidad del huésped');
INSERT INTO `tab_tipodatoadicional` VALUES ('21', '4009', 'Beneficio Hospedajes: Paquete turístico – Numero de documento identidad de huésped');
INSERT INTO `tab_tipodatoadicional` VALUES ('22', '5000', 'Proveedores Estado: Número de Expediente');
INSERT INTO `tab_tipodatoadicional` VALUES ('23', '5001', 'Proveedores Estado: Código de unidad ejecutora');
INSERT INTO `tab_tipodatoadicional` VALUES ('24', '5002', 'Proveedores Estado: N° de proceso de selección');
INSERT INTO `tab_tipodatoadicional` VALUES ('25', '5003', 'Proveedores Estado: N° de contrato');
INSERT INTO `tab_tipodatoadicional` VALUES ('26', '6000', 'Comercialización de Oro: Código Único Concesión Minera');
INSERT INTO `tab_tipodatoadicional` VALUES ('27', '6001', 'Comercialización de Oro: N° declaración compromiso');
INSERT INTO `tab_tipodatoadicional` VALUES ('28', '6002', 'Comercialización de Oro: N° Reg. Especial .Comerci. Oro');
INSERT INTO `tab_tipodatoadicional` VALUES ('29', '6003', 'Comercialización de Oro: N° Resolución que autoriza Planta de Beneficio');
INSERT INTO `tab_tipodatoadicional` VALUES ('30', '6004', 'Comercialización de Oro: Ley Mineral (% concent. oro)');

-- ----------------------------
-- Table structure for tab_tipodiscrepancias
-- ----------------------------
DROP TABLE IF EXISTS `tab_tipodiscrepancias`;
CREATE TABLE `tab_tipodiscrepancias` (
  `id_discre` int(11) NOT NULL AUTO_INCREMENT,
  `docaplica_discre` char(2) DEFAULT NULL,
  `codigo_discre` char(2) DEFAULT NULL,
  `descripcion_discre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_discre`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_tipodiscrepancias
-- ----------------------------
INSERT INTO `tab_tipodiscrepancias` VALUES ('1', '07', '01', 'Anulación de la operación');
INSERT INTO `tab_tipodiscrepancias` VALUES ('2', '07', '02', 'Anulación por error en el RUC');
INSERT INTO `tab_tipodiscrepancias` VALUES ('3', '07', '03', 'Corrección por error en la descripción');
INSERT INTO `tab_tipodiscrepancias` VALUES ('4', '07', '04', 'Descuento global');
INSERT INTO `tab_tipodiscrepancias` VALUES ('5', '07', '05', 'Descuento por ítem');
INSERT INTO `tab_tipodiscrepancias` VALUES ('6', '07', '06', 'Devolución total');
INSERT INTO `tab_tipodiscrepancias` VALUES ('7', '07', '07', 'Devolución por ítem');
INSERT INTO `tab_tipodiscrepancias` VALUES ('8', '07', '08', 'Bonificación');
INSERT INTO `tab_tipodiscrepancias` VALUES ('9', '07', '09', 'Disminución en el valor');
INSERT INTO `tab_tipodiscrepancias` VALUES ('10', '07', '10', 'Otros Conceptos');
INSERT INTO `tab_tipodiscrepancias` VALUES ('11', '08', '01', 'Intereses por mora');
INSERT INTO `tab_tipodiscrepancias` VALUES ('12', '08', '02', 'Aumento en el valor');
INSERT INTO `tab_tipodiscrepancias` VALUES ('13', '08', '03', 'Penalidades/otros conceptos');

-- ----------------------------
-- Table structure for tab_tipodocumento
-- ----------------------------
DROP TABLE IF EXISTS `tab_tipodocumento`;
CREATE TABLE `tab_tipodocumento` (
  `id_docu` int(11) NOT NULL AUTO_INCREMENT,
  `num_docu` char(10) DEFAULT NULL,
  `nombre_docu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_docu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_tipodocumento
-- ----------------------------
INSERT INTO `tab_tipodocumento` VALUES ('1', '01', 'Factura');
INSERT INTO `tab_tipodocumento` VALUES ('2', '03', 'Boleta');
INSERT INTO `tab_tipodocumento` VALUES ('3', '07', 'Nota de Crédito');
INSERT INTO `tab_tipodocumento` VALUES ('4', '08', 'Nota de Débito');

-- ----------------------------
-- Table structure for tab_tipoperacion
-- ----------------------------
DROP TABLE IF EXISTS `tab_tipoperacion`;
CREATE TABLE `tab_tipoperacion` (
  `id_tipope` int(11) NOT NULL AUTO_INCREMENT,
  `num_tipope` char(10) DEFAULT NULL,
  `nombre_tipope` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_tipope`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_tipoperacion
-- ----------------------------
INSERT INTO `tab_tipoperacion` VALUES ('1', '01', 'Venta lnterna');
INSERT INTO `tab_tipoperacion` VALUES ('2', '02', 'Exportación');
INSERT INTO `tab_tipoperacion` VALUES ('3', '03', 'No Domiciliados');
INSERT INTO `tab_tipoperacion` VALUES ('4', '04', 'Venta Interna – Anticipos');
INSERT INTO `tab_tipoperacion` VALUES ('5', '05', 'Venta Itinerante');
INSERT INTO `tab_tipoperacion` VALUES ('6', '06', 'Factura Guía');
INSERT INTO `tab_tipoperacion` VALUES ('7', '07', 'Venta Arroz Pilado');
INSERT INTO `tab_tipoperacion` VALUES ('8', '08', 'Factura - Comprobante de Percepción');

-- ----------------------------
-- Table structure for tab_tipparam
-- ----------------------------
DROP TABLE IF EXISTS `tab_tipparam`;
CREATE TABLE `tab_tipparam` (
  `tipparam_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipparam_tipo` varchar(15) NOT NULL,
  `tipparam_des` varchar(45) NOT NULL,
  `tipparam_estado` varchar(45) NOT NULL,
  PRIMARY KEY (`tipparam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tab_tipparam
-- ----------------------------
INSERT INTO `tab_tipparam` VALUES ('1', 'TipPrecio', 'Tipo Precio', 'AC');
INSERT INTO `tab_tipparam` VALUES ('2', 'TipImpuesto', 'Tipo Impuesto', 'AC');
INSERT INTO `tab_tipparam` VALUES ('3', 'UniMed', 'Unidad de Medida', 'AC');
