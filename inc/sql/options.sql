CREATE TABLE IF NOT EXISTS `options` (
 `option_id` 	bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `option_name` 	varchar(64) 		NOT NULL DEFAULT '',
 `option_value` longtext 			NOT NULL,
 PRIMARY KEY (`option_id`),
 UNIQUE KEY `option_name` (`option_name`)
) DEFAULT CHARSET=utf8;