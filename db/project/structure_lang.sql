CREATE TABLE IF NOT EXISTS `project_lang` (
`id` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`lang` varchar(2) NOT NULL,
`description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
`motivation` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
`about` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
`goal` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
`related` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
`keywords` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
`media` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci ,
`resource` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci ,
 UNIQUE KEY `id_lang` (`id`,`lang`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;