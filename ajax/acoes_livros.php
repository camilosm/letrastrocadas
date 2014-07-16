<?php

	if((isset($_GET['acao'])) && (isset($_GET['id'])))
	{
		session_start();
		
		include("../views/classes/class_banco.php");
		include("../views/classes/class_update.php");
		include("../views/classes/class_insert.php");
		include("../views/classes/class_delete.php");
		
		$banco = new Banco();
		
		$acao = $_GET['acao'];
		$id = $_GET['id'];
		$tabela = $_GET['tabela'];
		
		
		switch ($tabela) 
		{
			case "JaLi":
				$tipo = 2;
				$campo = "lido";
				break;
			case "Lendo":	
				$tipo = 3;
				$campo = "lendo";
				break;
			case "QueroLer":
				$tipo = 1;
				$campo = "querem_ler";
				break;
		}
		
		switch ($acao) 
		{
			case "JaLi":
				$cadastrar_ja_li = new Inserir("tbl_marcacao","NULL,".$_SESSION['id'].",$id,2");
				$resultado = $cadastrar_ja_li->inserir();
				if($resultado != 0)
				{	
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
						$resposta_deletar = $deletar_antigo->deletar();
						if($resposta_deletar != 0)
						{
							$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1), lido = (lido + 1)","id_livro=$id");
							$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
							if($resultado_quantidade_livros != 0)
							{
								echo "Já Li";
							}
						}
					}
					else
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","lido = (lido + 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo "Já Li";
						}
					}
				}
				break;
			case "Lendo":
				$cadastrar_lendo = new Inserir("tbl_marcacao","NULL,".$_SESSION['id'].",$id,3");
				$resultado = $cadastrar_lendo->inserir();
				if($resultado != 0)
				{
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
						$resposta_deletar = $deletar_antigo->deletar();
						if($resposta_deletar != 0)
						{
							$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1), lendo = (lendo + 1)","id_livro=$id");
							$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
							if($resultado_quantidade_livros != 0)
							{
								echo "Lendo";
							}
						}
					}
					else
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","lendo = (lendo + 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo "Lendo";
						}
					}
				}
				break;
			case "QueroLer":
				$cadastrar_quero_ler = new Inserir("tbl_marcacao","NULL,".$_SESSION['id'].",$id,1");
				$resultado = $cadastrar_quero_ler->inserir();
				if($resultado != 0)
				{
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
						$resposta_deletar = $deletar_antigo->deletar();
						if($resposta_deletar != 0)
						{
							$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1), querem_ler = (querem_ler + 1)","id_livro=$id");
							$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
							if($resultado_quantidade_livros != 0)
							{
								echo "Quero Ler";
							}
						}
					}
					else
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","querem_ler = (querem_ler + 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo "Quero Ler";
						}
					}
				}
				break;
			case "Desmarcar":
					if(!empty($tabela))
					$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
					$resposta_deletar = $deletar_antigo->deletar();
					if($resposta_deletar != 0)
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo "Eu...";
						}
					}
				
				break;
		}
	}
	

?>