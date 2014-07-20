<?php
	
	session_start();
	if($_SESSION['id'] == 1)
	{
		if((isset($_GET['id'])) && (isset($_GET['lista'])) && (isset($_GET['usuario'])))
		{
			include("../views/classes/class_banco.php");
			include("../views/classes/class_update.php");
			include("../views/classes/class_insert.php");
			
			$bd = new Banco();
			
			$id = $_GET['id'];
			$lista = $_GET['lista'];
			$usuario = $_GET['usuario'];
			
			$alterar = new Alterar('tbl_solicitacao_troca',"aceito = 'Sim', data_resposta = DATE(NOW())",'id_solicitacao = '.$id);
			$resultado = $alterar->alterar();
			
			$campos = "NULL,1,DATE(NOW()),1,NULL,1,1,'',NULL,".$lista.",".$_SESSION['id'].",".$usuario.",".$id;
			$inserir = new Inserir('tbl_cambio',$campos);
			$resultados = $inserir->inserir();
			
			$resposta = array('retorno' => $resultado);
			
			echo json_encode($resposta);
		}
	}
?>