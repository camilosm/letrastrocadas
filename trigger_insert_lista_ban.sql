DELIMITER |
CREATE PROCEDURE sp_insert_lista_ban () 
		BEGIN
			SET @id := (SELECT id_usuario FROM tbl_usuario WHERE status = 3);
			INSERT INTO tbl_lista_banidos 
			VALUES (null, DATE(NOW()), );
		END;
|
DELIMITER ;

DELIMITER |
CREATE TRIGGER trg_insert_lista_ban AFTER UPDATE ON tbl_usuario 
	FOR EACH ROW
		BEGIN
				CALL sp_insert_lista_ban;
		END;
|
DELIMITER ;

SELECT id_usuario 
FROM tbl_usuario JOIN tbl_
WHERE status = 3;