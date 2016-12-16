SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `dimpe_rmmh` ;
CREATE SCHEMA IF NOT EXISTS `dimpe_rmmh` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
SHOW WARNINGS;
USE `dimpe_rmmh` ;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_periodos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_periodos` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_periodos` (
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  `nom_periodo` VARCHAR(50) NULL ,
  PRIMARY KEY (`ano_periodo`, `mes_periodo`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_deptos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_deptos` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_deptos` (
  `id_depto` INT NOT NULL ,
  `nom_depto` VARCHAR(50) NULL ,
  PRIMARY KEY (`id_depto`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_mpios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_mpios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_mpios` (
  `id_mpio` INT NOT NULL ,
  `nom_mpio` VARCHAR(50) NULL ,
  `fk_depto` INT NOT NULL ,
  PRIMARY KEY (`id_mpio`) ,
  INDEX `fk_mpios_deptos` (`fk_depto` ASC) ,
  CONSTRAINT `fk_mpios_deptos`
    FOREIGN KEY (`fk_depto` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_deptos` (`id_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_ciiu3`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_ciiu3` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_ciiu3` (
  `id_actividad` INT NOT NULL ,
  `nom_actividad` VARCHAR(50) NULL ,
  `num_digitos` TINYINT NULL ,
  PRIMARY KEY (`id_actividad`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_sedes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_sedes` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_sedes` (
  `id_sede` INT NOT NULL ,
  `nom_sede` VARCHAR(50) NULL ,
  PRIMARY KEY (`id_sede`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_admin_dirfuentes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_admin_dirfuentes` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_admin_dirfuentes` (
  `nro_orden` INT NOT NULL ,
  `idproraz` VARCHAR(80) NULL ,
  `idnomcom` VARCHAR(80) NULL ,
  `idsigla` CHAR(15) NULL ,
  `iddirecc` VARCHAR(80) NULL ,
  `idtelno` INT NULL ,
  `idfaxno` INT NULL ,
  `idaano` INT NULL ,
  `idcorreo` VARCHAR(80) NULL ,
  `finicial` DATE NULL ,
  `ffinal` DATE NULL ,
  `fk_depto` INT NOT NULL ,
  `fk_mpio` INT NOT NULL ,
  `fk_actividad` INT NOT NULL ,
  `fk_sede` INT NOT NULL ,
  PRIMARY KEY (`nro_orden`) ,
  INDEX `fk_dirfuentes_deptos` (`fk_depto` ASC) ,
  INDEX `fk_dirfuentes_mpios` (`fk_mpio` ASC) ,
  INDEX `fk_dirfuentes_actividades` (`fk_actividad` ASC) ,
  INDEX `fk_dirfuentes_sedes` (`fk_sede` ASC) ,
  CONSTRAINT `fk_dirfuentes_deptos`
    FOREIGN KEY (`fk_depto` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_deptos` (`id_depto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dirfuentes_mpios`
    FOREIGN KEY (`fk_mpio` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_mpios` (`id_mpio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dirfuentes_actividades`
    FOREIGN KEY (`fk_actividad` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_ciiu3` (`id_actividad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dirfuentes_sedes`
    FOREIGN KEY (`fk_sede` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_sedes` (`id_sede` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_admin_dirunilocales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_admin_dirunilocales` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_admin_dirunilocales` (
  `id_unilocal` INT NOT NULL ,
  `nom_unilocal` VARCHAR(50) NULL ,
  PRIMARY KEY (`id_unilocal`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_novedades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_novedades` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_novedades` (
  `id_novedad` INT NOT NULL ,
  `nom_novedad` VARCHAR(50) NULL ,
  PRIMARY KEY (`id_novedad`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_estados`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_estados` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_estados` (
  `id_estado` INT NOT NULL ,
  `nom_estado` VARCHAR(50) NULL ,
  PRIMARY KEY (`id_estado`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_subsedes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_subsedes` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_subsedes` (
  `id_subsede` INT NOT NULL ,
  `nom_subsede` VARCHAR(50) NULL ,
  `fk_sede` INT NOT NULL ,
  PRIMARY KEY (`id_subsede`) ,
  INDEX `fk_subsedes_sedes` (`fk_sede` ASC) ,
  CONSTRAINT `fk_subsedes_sedes`
    FOREIGN KEY (`fk_sede` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_sedes` (`id_sede` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_roles` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_roles` (
  `id_rol` INT NOT NULL ,
  `nom_rol` VARCHAR(50) NULL ,
  PRIMARY KEY (`id_rol`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_admin_control`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_admin_control` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_admin_control` (
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  `caratula_estado` CHAR(2) NULL ,
  `cap1_estado` CHAR(2) NULL ,
  `cap2_estado` CHAR(2) NULL ,
  `cap3_estado` CHAR(2) NULL ,
  `cap4_estado` CHAR(2) NULL ,
  `cap5_estado` CHAR(2) NULL ,
  `fk_novedad` INT NOT NULL ,
  `fk_estado` INT NOT NULL ,
  `fk_sede` INT NOT NULL ,
  `fk_subsede` INT NOT NULL ,
  `fk_rolacceso` INT NOT NULL ,
  `control` CHAR(2) NULL COMMENT 'A - Abierto\nC - Cerrado' ,
  INDEX `fk_control_periodos` (`ano_periodo` ASC, `mes_periodo` ASC) ,
  INDEX `fk_control_dirfuentes` (`nro_orden` ASC) ,
  INDEX `fk_control_dirunilocales` (`uni_local` ASC) ,
  PRIMARY KEY (`nro_orden`, `uni_local`, `ano_periodo`, `mes_periodo`) ,
  INDEX `fk_control_novedades` (`fk_novedad` ASC) ,
  INDEX `fk_control_estados` (`fk_estado` ASC) ,
  INDEX `fk_control_sedes` (`fk_sede` ASC) ,
  INDEX `fk_control_subsedes` (`fk_subsede` ASC) ,
  INDEX `fk_control_roles` (`fk_rolacceso` ASC) ,
  CONSTRAINT `fk_control_periodos`
    FOREIGN KEY (`ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_periodos` (`ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_dirfuentes`
    FOREIGN KEY (`nro_orden` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_dirfuentes` (`nro_orden` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_dirunilocales`
    FOREIGN KEY (`uni_local` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_dirunilocales` (`id_unilocal` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_novedades`
    FOREIGN KEY (`fk_novedad` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_novedades` (`id_novedad` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_estados`
    FOREIGN KEY (`fk_estado` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_estados` (`id_estado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_sedes`
    FOREIGN KEY (`fk_sede` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_sedes` (`id_sede` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_subsedes`
    FOREIGN KEY (`fk_subsede` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_subsedes` (`id_subsede` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_roles`
    FOREIGN KEY (`fk_rolacceso` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_roles` (`id_rol` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_form_movmensual`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_form_movmensual` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_form_movmensual` (
  `id_cap2` INT NOT NULL ,
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  `esini` TINYINT NULL ,
  `esape` TINYINT NULL ,
  `escie` TINYINT NULL ,
  `estot` TINYINT NULL ,
  PRIMARY KEY (`id_cap2`) ,
  INDEX `fk_cap2_control` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  CONSTRAINT `fk_cap2_control`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_form_ingoperacionales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_form_ingoperacionales` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_form_ingoperacionales` (
  `id_cap3` INT NOT NULL ,
  `inalo` TINYINT NULL ,
  `inali` TINYINT NULL ,
  `inba` TINYINT NULL ,
  `inoe` TINYINT NULL ,
  `inoio` TINYINT NULL ,
  `intio` TINYINT NULL ,
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  PRIMARY KEY (`id_cap3`) ,
  INDEX `fk_cap3_control` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  CONSTRAINT `fk_cap3_control`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_form_persalarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_form_persalarios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_form_persalarios` (
  `id_cap4` INT NOT NULL ,
  `potpsfr` TINYINT NULL ,
  `potperm` TINYINT NULL ,
  `gpper` DECIMAL(10,2) NULL ,
  `pottcde` TINYINT NULL ,
  `gpssde` DECIMAL(10,2) NULL ,
  `pottcag` TINYINT NULL ,
  `gpppta` DECIMAL(10,2) NULL ,
  `potpau` TINYINT NULL ,
  `gppgpa` DECIMAL(10,2) NULL ,
  `pottot` TINYINT NULL ,
  `gpsspot` DECIMAL(10,2) NULL ,
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  PRIMARY KEY (`id_cap4`) ,
  INDEX `fk_cap4_control` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  CONSTRAINT `fk_cap4_control`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_form_caracthoteles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_form_caracthoteles` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_form_caracthoteles` (
  `id_cap5` INT NOT NULL ,
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  `habdia` VARCHAR(45) NULL ,
  `ihdo` VARCHAR(45) NULL ,
  `ihoa` VARCHAR(45) NULL ,
  `camdia` VARCHAR(45) NULL ,
  `icda` VARCHAR(45) NULL ,
  `icva` VARCHAR(45) NULL ,
  `ihpn` VARCHAR(45) NULL ,
  `ihpnr` INT NULL ,
  `huetot` VARCHAR(45) NULL ,
  `mvnr` VARCHAR(45) NULL ,
  `mvor` INT NULL ,
  `mvotr` VARCHAR(45) NULL ,
  `mvott` VARCHAR(45) NULL ,
  `mvnnr` VARCHAR(45) NULL ,
  `mvonr` VARCHAR(45) NULL ,
  `mvotnr` VARCHAR(45) NULL ,
  `mvottnr` VARCHAR(45) NULL ,
  `thsen` VARCHAR(45) NULL ,
  `thdob` VARCHAR(45) NULL ,
  `thsui` VARCHAR(45) NULL ,
  `thmult` VARCHAR(45) NULL ,
  `thotr` VARCHAR(45) NULL ,
  `thtot` VARCHAR(45) NULL ,
  `ingsen` VARCHAR(45) NULL ,
  `ingdob` VARCHAR(45) NULL ,
  `ingsui` VARCHAR(45) NULL ,
  `ingmult` VARCHAR(45) NULL ,
  `ingotr` VARCHAR(45) NULL ,
  `tphto` VARCHAR(45) NULL ,
  `inalosen` VARCHAR(45) NULL ,
  `inalodob` VARCHAR(45) NULL ,
  `inalosui` VARCHAR(45) NULL ,
  `inalomul` VARCHAR(45) NULL ,
  `inalootr` VARCHAR(45) NULL ,
  `inalotot` VARCHAR(45) NULL ,
  PRIMARY KEY (`id_cap5`) ,
  INDEX `fk_cap5_control` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  CONSTRAINT `fk_cap5_control`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_param_tipodocs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_param_tipodocs` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_param_tipodocs` (
  `id_tipodoc` INT NOT NULL ,
  `nom_tipodoc` VARCHAR(50) NULL ,
  PRIMARY KEY (`id_tipodoc`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_admin_usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_admin_usuarios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_admin_usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT ,
  `num_identificacion` BIGINT NULL ,
  `nom_usuario` VARCHAR(50) NULL ,
  `pass_usuario` VARCHAR(40) NULL ,
  `mail_usuario` VARCHAR(50) NULL ,
  `fec_creacion` DATETIME NULL ,
  `fec_vencimiento` DATETIME NULL ,
  `nro_orden` INT NOT NULL ,
  `fk_rol` INT NOT NULL ,
  `fk_sede` INT NOT NULL ,
  `fk_subsede` INT NOT NULL ,
  `fk_tipodoc` INT NOT NULL ,
  PRIMARY KEY (`id_usuario`) ,
  INDEX `fk_usuarios_rol` (`fk_rol` ASC) ,
  INDEX `fk_usuarios_dirfuentes` (`nro_orden` ASC) ,
  INDEX `fk_usuarios_sedes` (`fk_sede` ASC) ,
  INDEX `fk_usuarios_subsedes` (`fk_subsede` ASC) ,
  INDEX `fk_usuarios_tipodocs` (`fk_tipodoc` ASC) ,
  CONSTRAINT `fk_usuarios_rol`
    FOREIGN KEY (`fk_rol` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_roles` (`id_rol` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_dirfuentes`
    FOREIGN KEY (`nro_orden` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_dirfuentes` (`nro_orden` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_sedes`
    FOREIGN KEY (`fk_sede` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_sedes` (`id_sede` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_subsedes`
    FOREIGN KEY (`fk_subsede` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_subsedes` (`id_subsede` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_tipodocs`
    FOREIGN KEY (`fk_tipodoc` )
    REFERENCES `dimpe_rmmh`.`rmmh_param_tipodocs` (`id_tipodoc` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_admin_observaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_admin_observaciones` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_admin_observaciones` (
  `id_observacion` INT NOT NULL AUTO_INCREMENT ,
  `capitulo` TINYINT NULL ,
  `nom_campo` VARCHAR(50) NULL ,
  `descripcion` VARCHAR(500) NULL ,
  `fecha` DATETIME NULL ,
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  `fk_usuario` INT NOT NULL ,
  PRIMARY KEY (`id_observacion`) ,
  INDEX `fk_observaciones_control` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  INDEX `fk_observaciones_usuarios` (`fk_usuario` ASC) ,
  CONSTRAINT `fk_observaciones_control`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_observaciones_usuarios`
    FOREIGN KEY (`fk_usuario` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_usuarios` (`id_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_admin_controlcambios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_admin_controlcambios` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_admin_controlcambios` (
  `id_controlcambio` INT NOT NULL AUTO_INCREMENT ,
  `fec_cambio` DATETIME NULL ,
  `val_anterior` VARCHAR(255) NULL ,
  `val_actual` VARCHAR(255) NULL ,
  `capitulo` TINYINT NULL ,
  `operacion` CHAR(2) NULL ,
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  PRIMARY KEY (`id_controlcambio`) ,
  INDEX `fk_controlcambios_control` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  CONSTRAINT `fk_controlcambios_control`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_form_respencuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_form_respencuesta` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_form_respencuesta` (
  `id_responsable` INT NOT NULL ,
  `ciudad` INT NULL ,
  `fedili` DATE NULL ,
  `repleg` VARCHAR(80) NULL ,
  `responde` VARCHAR(50) NULL ,
  `respoca` VARCHAR(30) NULL ,
  `teler` INT NULL ,
  `emailr` VARCHAR(50) NULL ,
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  PRIMARY KEY (`id_responsable`) ,
  INDEX `fk_respencuesta_control` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  CONSTRAINT `fk_respencuesta_control`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dimpe_rmmh`.`rmmh_admin_deudas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dimpe_rmmh`.`rmmh_admin_deudas` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `dimpe_rmmh`.`rmmh_admin_deudas` (
  `nro_orden` INT NOT NULL ,
  `uni_local` INT NOT NULL ,
  `ano_periodo` INT(4) NOT NULL ,
  `mes_periodo` INT(2) NOT NULL ,
  `fecha_rinde` DATETIME NOT NULL ,
  INDEX `fk_control_deudas` (`nro_orden` ASC, `uni_local` ASC, `ano_periodo` ASC, `mes_periodo` ASC) ,
  CONSTRAINT `fk_control_deudas`
    FOREIGN KEY (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    REFERENCES `dimpe_rmmh`.`rmmh_admin_control` (`nro_orden` , `uni_local` , `ano_periodo` , `mes_periodo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
