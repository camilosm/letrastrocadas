DELIMITER |
CREATE TRIGGER trg_notificacoes_trocas AFTER UPDATE ON tbl_solicitacao_troca
	FOR EACH ROW
	BEGIN
	
		SET @situacao := (SELECT aceito FROM tbl_solicitacao_troca WHERE id_solicitacao = NEW.id_solicitacao);
		IF @situacao = "Sim" THEN 
			INSERT INTO tbl_notificacoes VALUES(NULL,1,'Sua solicitação de troca foi aceita!',NEW.usuario_solicitador,NOW(),'false');
		ELSE
			INSERT INTO tbl_notificacoes VALUES(NULL,2,'Sua solicitação de troca foi recusada!',NEW.usuario_solicitador,NOW(),'false');
		END IF;

	END;
|
DELIMITER ;

/* DROP TRIGGER trg_notificacoes_trocas; */

DELIMITER |
CREATE TRIGGER trg_notificacoes_solicitacoes_recebidas AFTER INSERT ON tbl_solicitacao_troca
	FOR EACH ROW
	BEGIN
	
		INSERT INTO tbl_notificacoes VALUES(NULL,3,'Você recebeu uma nova solicitação de troca! Confira!',NEW.usuario_dono_lista,NOW(),'false');
		
	END;
|
DELIMITER ;

/* DROP TRIGGER trg_notificacoes_solicitacoes_recebidas; */

DELIMITER |
CREATE TRIGGER trg_update_cambio AFTER UPDATE ON tbl_cambio
	FOR EACH ROW
	BEGIN
	
		SET @entregue := (SELECT entregue FROM tbl_cambio WHERE id_cambio = NEW.id_cambio);
		SET @status := (SELECT status FROM tbl_cambio WHERE id_cambio = NEW.id_cambio);
		SET @data_entrega := (SELECT data_entrega FROM tbl_cambio WHERE id_cambio = NEW.id_cambio);
		
		IF @entregue = "Sim" THEN 
			UPDATE tbl_notificacoes SET creditos = (creditos + 1) WHERE usuario_disponibilizador = NEW.usuario_disponibilizador;
			IF @status = 3 THEN
				INSERT INTO tbl_notificacoes VALUES(NULL,4,'O livro enviado por você já chegou',NEW.usuario_disponibilizador,NOW(),'false');
			END IF;
		END IF;
		
		IF @data_entrega = NULL THEN
			IF @status = 2 THEN 
				INSERT INTO tbl_notificacoes VALUES(NULL,5,'O livro solicitado por você já está em transporte!',NEW.usuario_resgate,NOW(),'false');
			END IF;
		END IF;
		
	END;
|
DELIMITER ;

/* DROP TRIGGER trg_notificacoes_status_cambio; */