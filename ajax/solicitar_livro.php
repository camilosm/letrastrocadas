<?php

	if((isset($_GET['acao'])) && (isset($_GET['id']))  && (isset($_GET['usuario'])))
	{
		session_start();
		if($_SESSION['id'] =! $_GET['usuario'])
		{
			
			include("../views/classes/class_banco.php");
			include("../views/classes/class_update.php");
			include("../views/classes/class_insert.php");
			include("../views/classes/class_delete.php");
			
			$bd = new Banco();
			
			$id_lista = $_GET['id'];
			$usuario = $_GET['usuario'];
			
			$cadastrar_solicitacao = new Inserir("tbl_solicitacao_troca","NULL,$id_lista,".$_SESSION['id'].",$usuario,'',DATE(NOW()),NULL");
			$resultado = $cadastrar_solicitacao->inserir();
			if($resultado != 0)
			{
				echo "Sua solicitação foi enviada. Aguarde a confirmação.";
			}
			else
			{
				echo "Erro, entre em contato com nossos administradores";
			}
		}
		else
		{
			echo "Você não pode solicitar seu próprio livro.";
		}
	}

?>