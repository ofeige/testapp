SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `email`      VARCHAR(255) NULL DEFAULT NULL,
  `password`   VARCHAR(255) NULL DEFAULT NULL,
  `is_doi`     TINYINT(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;

CREATE UNIQUE INDEX `email_UNIQUE` ON `user` (`email` ASC);


-- -----------------------------------------------------
-- Table `role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `role` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_has_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_has_role` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `role_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_has_role_user1`
  FOREIGN KEY (`user_id`)
  REFERENCES `user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_role_role1`
  FOREIGN KEY (`role_id`)
  REFERENCES `role` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
  ENGINE = InnoDB;

CREATE INDEX `fk_user_has_role_user1_idx` ON `user_has_role` (`user_id` ASC);

CREATE INDEX `fk_user_has_role_role1_idx` ON `user_has_role` (`user_id` ASC);


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `role`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `user` (`id`, `email`, `password`, `is_doi`)
VALUES (1, 'admin', '$2y$10$nwV8BO7xwYOJs172uY3AvOsW7AOOiNUOaSef.fDeHNVkNhyVukCda', 0);

INSERT INTO `role` (`id`, `name`) VALUES (1, 'admin');

INSERT INTO user_has_role (user_id, role_id) VALUES (1, 1);


COMMIT;

