CREATE TABLE `rooms` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(50) NOT NULL,
	`description` TEXT NULL,
	`seats_cout` INT(11) NULL DEFAULT '0',
	`isActive` TINYINT(1) NULL DEFAULT '0',
	`orderBy` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
ENGINE=InnoDB
;
