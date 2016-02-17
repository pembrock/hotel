CREATE TABLE `additional_service` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(50) NOT NULL,
	`description` TEXT NULL,
	`logo` VARCHAR(100) NULL DEFAULT NULL,
	`isActive` TINYINT(1) NOT NULL DEFAULT '0',
	`orderBy` SMALLINT(6) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=3
;
