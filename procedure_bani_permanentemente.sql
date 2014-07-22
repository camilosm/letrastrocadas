DELIMITER |
	CREATE PROCEDURE sp_atualiza_status_usu_banido_permanente (in id INT)
		BEGIN
			UPDATE tbl_usuario SET status = 3 WHERE id_usuario = id;
		END ;		
|
DELIMITER ;