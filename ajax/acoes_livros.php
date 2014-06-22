<?php

	if((isset($_GET['acao'])) && (isset($_GET['id'])))
	{
		session_start();
		
		include("../views/classes/class_banco.php");
		include("../views/classes/class_update.php");
		include("../views/classes/class_insert.php");
		
		$banco = new Banco();
		
		$acao = $_GET['acao'];
		$id = $_GET['id'];
		
		switch ($acao) 
		{
			case "JaLi":
				$cadastrar_quero_ler = new Inserir("tbl_leu","NULL,".$_SESSION['id'].",$id");
				$resultado = $cadastrar_quero_ler->inserir();
				if($resultado != 0)
				{
					$alterar_quantidade_livros = new Alterar("tbl_livro","lido = (lido - 1)")
				}
				break;
			case "Lendo":
				echo "Lendo";
				break;
			case "QueroLer":
				echo "QueroLer";
				break;
		}
	}
	

?>