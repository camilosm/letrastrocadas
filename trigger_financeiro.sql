DELIMITER |
CREATE TRIGGER trg_descresimo AFTER INSERT ON tbl_cambio
	FOR EACH ROW
	BEGIN
		
		UPDATE tbl_usuario SET creditos = (creditos - 1) WHERE id_usuario = NEW.usuario_id;
		
	END;
|
DELIMITER ;

/* DROP TRIGGER trg_notificacoes_status_cambio; */