
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- character
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `character`;

CREATE TABLE `character`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(40),
    `power` VARCHAR(40),
    `power_one_per_game` VARCHAR(40),
    `drawback` VARCHAR(40),
    `cards` VARCHAR(40),
    `role` VARCHAR(40),
    `amiral_order` INTEGER,
    `president_order` INTEGER,
    `cag_order` INTEGER,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- game
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `game`;

CREATE TABLE `game`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(40),
    `fuel` INTEGER,
    `food` INTEGER,
    `morale` INTEGER,
    `population` INTEGER,
    `distance` INTEGER,
    `jump` INTEGER,
    `is_completed` TINYINT(1),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- game_player
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `game_player`;

CREATE TABLE `game_player`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `game_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `character_id` INTEGER,
    `is_amiral` TINYINT(1),
    `is_president` TINYINT(1),
    `is_cag` TINYINT(1),
    `is_alive` TINYINT(1),
    PRIMARY KEY (`id`),
    INDEX `game_player_FI_1` (`game_id`),
    INDEX `game_player_FI_2` (`user_id`),
    INDEX `game_player_FI_3` (`character_id`),
    CONSTRAINT `game_player_FK_1`
        FOREIGN KEY (`game_id`)
        REFERENCES `game` (`id`),
    CONSTRAINT `game_player_FK_2`
        FOREIGN KEY (`user_id`)
        REFERENCES `fos_user` (`id`),
    CONSTRAINT `game_player_FK_3`
        FOREIGN KEY (`character_id`)
        REFERENCES `character` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fos_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_user`;

CREATE TABLE `fos_user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255),
    `username_canonical` VARCHAR(255),
    `email` VARCHAR(255),
    `email_canonical` VARCHAR(255),
    `enabled` TINYINT(1) DEFAULT 0,
    `salt` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `last_login` DATETIME,
    `locked` TINYINT(1) DEFAULT 0,
    `expired` TINYINT(1) DEFAULT 0,
    `expires_at` DATETIME,
    `confirmation_token` VARCHAR(255),
    `password_requested_at` DATETIME,
    `credentials_expired` TINYINT(1) DEFAULT 0,
    `credentials_expire_at` DATETIME,
    `roles` TEXT,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fos_user_U_1` (`username_canonical`),
    UNIQUE INDEX `fos_user_U_2` (`email_canonical`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fos_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_group`;

CREATE TABLE `fos_group`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `roles` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fos_user_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fos_user_group`;

CREATE TABLE `fos_user_group`
(
    `fos_user_id` INTEGER NOT NULL,
    `fos_group_id` INTEGER NOT NULL,
    PRIMARY KEY (`fos_user_id`,`fos_group_id`),
    INDEX `fos_user_group_FI_2` (`fos_group_id`),
    CONSTRAINT `fos_user_group_FK_1`
        FOREIGN KEY (`fos_user_id`)
        REFERENCES `fos_user` (`id`),
    CONSTRAINT `fos_user_group_FK_2`
        FOREIGN KEY (`fos_group_id`)
        REFERENCES `fos_group` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
