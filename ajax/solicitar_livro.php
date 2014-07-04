<?php

	if(isset($_GET['livro']) && isset($_GET['usuario']))
	{
		session_start();
		$id_usuario = $_SESSION['id'];
		
		if($id_usuario != $_GET['usuario'])
		{
			
			include("../views/classes/class_banco.php");
			include("../views/classes/class_update.php");
			include("../views/classes/class_insert.php");
			include("../views/classes/class_delete.php");
			
			$bd = new Banco();
			
			$id_lista = $_GET['livro'];
			$usuario = $_GET['usuario'];
			
			$cadastrar_solicitacao = new Inserir("tbl_solicitacao_troca","NULL,$id_lista,".$_SESSION['id'].",$usuario,'',DATE(NOW()),NULL");
			$resultado = $cadastrar_solicitacao->inserir();
			if($resultado != 0)
			{
				$resposta = "Sua solicitação foi enviada. Aguarde a confirmação.";
			}
			else
			{
				$resposta = "Erro, entre em contato com nossos administradores";
			}
		}
		else
		{
			$resposta = "Você não pode solicitar seu próprio livro.";
		}
		
		$retorno = array('resposta' => $resposta);
				
		echo json_encode($retorno);
	}

?>