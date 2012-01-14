CREATE TABLE IF NOT EXISTS `input_properties` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `inputName` varchar(100) CHARACTER SET latin1 NOT NULL,
          `outputName` varchar(100) CHARACTER SET latin1 NOT NULL,
          `weight` FLOAT,
	  `value` FLOAT,
          PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
