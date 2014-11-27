<?php
	session_start();
	if(isset($_GET['genero']) && isset($_GET['acao']))
	{
		$id = $_SESSION['id'];
			
		include("../views/classes/class_banco.php");	
		include("../views/classes/class_insert.php");
		include("../views/classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$genero = $_GET['genero'];
		
		if($_GET['acao'] == "Favoritos")
		{
			$cadastrar_gen = new Inserir('tbl_generos_favoritos',"NULL,$genero,$id");
			$resultado = $cadastrar_gen->inserir();
			
			$resposta = array('resposta' => 'Deu certo');
			echo json_encode($resposta);
		}
		else if($_GET['acao'] == "Chatos")
		{
			$cadastrar_gen = new Inserir('tbl_generos_desapreciados',"NULL,$genero,$id");
			$resultado = $cadastrar_gen->inserir();
			
			$resposta = array('resposta' => 'Deu certo');
			echo json_encode($resposta);
		}
		else
		{
		}
	}
?>