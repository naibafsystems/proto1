DELIMITER $$

DROP PROCEDURE IF EXISTS `dimpe_rmmh`.`sp_borradoDatos` $$
CREATE PROCEDURE `dimpe_rmmh`.`sp_borradoDatos` ()
BEGIN

  -- Deshabilitar constraints
  SET FOREIGN_KEY_CHECKS = 0;

  -- Borrar los datos de la tabla de usuarios
  TRUNCATE TABLE rmmh_admin_usuarios;

  -- Borrar los datos de la tabla del directorio
  TRUNCATE TABLE rmmh_admin_dirfuentes;

  -- Borrar los datos de la tabla de control
  TRUNCATE TABLE rmmh_admin_control;

  -- Borrar los datos de las tablas de los capitulos
  TRUNCATE TABLE rmmh_form_movmensual;
  TRUNCATE TABLE rmmh_form_ingoperacionales;
  TRUNCATE TABLE rmmh_form_persalarios;
  TRUNCATE TABLE rmmh_form_caracthoteles;
  TRUNCATE TABLE rmmh_form_envioform;

  -- Borrar los datos de las observaciones
  TRUNCATE TABLE rmmh_admin_observaciones;


  -- Crear registros de datos para el primer Usuario (ADMINISTRADOR)
  INSERT INTO rmmh_admin_usuarios VALUES (0,0,'ADMINISTRADOR','admin','TCYL0PXU_uT_zp13gXfD4F3V9L9RlPPA1e03xWqW_sY','admin@localhost.com',CURDATE(),CURDATE(),0,4,11,1,'A');
  INSERT INTO rmmh_admin_dirfuentes (nro_orden, uni_local, idproraz, fk_depto, fk_mpio, fk_ciiu, fk_sede) VALUES (0,0,'Sin Asignar',11,3,5511,11);

  -- Habilitar constraints
  SET FOREIGN_KEY_CHECKS = 1;


END $$

DELIMITER ;