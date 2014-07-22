DELIMITER |
	CREATE PROCEDURE sp_atualiza_status_den (in id INT)
		BEGIN
			IF status = 1 THEN 
			UPDATE tbl_denuncias SET status = 2 WHERE id_denuncias = id;
			ELSE 
				IF status = 2 THEN 
					UPDATE tbl_denuncias SET status = 1 WHERE id_denuncias = id;
				END IF;
			END IF;
		END ;		
|
DELIMITER ;

