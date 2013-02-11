
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
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
