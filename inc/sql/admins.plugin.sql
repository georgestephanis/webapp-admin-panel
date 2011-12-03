CREATE TABLE IF NOT EXISTS `admins` (
	`id` 			INT 			NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`login` 		VARCHAR( 50 ) 	NOT NULL ,
	`password` 		VARCHAR( 50 ) 	NOT NULL ,
	`email` 		VARCHAR( 255 ) 	NOT NULL ,
	`first_name` 	VARCHAR( 255 ) 	NOT NULL ,
	`last_name` 	VARCHAR( 255 ) 	NOT NULL ,
	`last_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	INDEX ( `password` , `email` ) ,
	UNIQUE ( `login` )
) DEFAULT CHARSET=utf8;