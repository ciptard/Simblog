CREATE TABLE IF NOT EXISTS `{prefix}post` (
	`id` MEDIUMINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	`rating` INT(10) NOT NULL DEFAULT '0',
	`title` TINYTEXT NOT NULL,
	`pinned` TINYINT(1) NOT NULL DEFAULT '0',
	`category` TINYTEXT NOT NULL,
	`content` TEXT NOT NULL,
	`date_posted` TINYTEXT NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT
AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `{prefix}comment` (
	`id` MEDIUMINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	`post_id` MEDIUMINT(6) UNSIGNED NOT NULL,
	`rating` INT(10) NOT NULL DEFAULT '0',
	`name` TINYTEXT NOT NULL,
	`ip` TINYTEXT NOT NULL,
	`text` TEXT NOT NULL,
	`date` TINYTEXT NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT
AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `{prefix}category` (
	`id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` TINYTEXT NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `{prefix}category_map` (
	`post_id` INT(10) UNSIGNED NOT NULL,
	`category_id` SMALLINT(5) UNSIGNED NOT NULL
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=1;