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
				$tabela = "tbl_tbl_leu";
				$campo = "lido";
				break;
			case "Lendo":
				$tabela = "tbl_lendo";
				$campo = "lendo";
				break;
			case "QueroLer":
				$tabela = "tbl_lista_desejo";
				$campo = "querem_ler";
				break;
		}
		
		switch ($acao) 
		{
			case "JaLi":
				$cadastrar_ja_li = new Inserir("tbl_leu","NULL,".$_SESSION['id'].",$id");
				$resultado = $cadastrar_ja_li->inserir();
				if($resultado != 0)
				{	
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("$tabela","livro_id=$id AND usuario_id =".$_SESSION['id']);
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
				$cadastrar_lendo = new Inserir("tbl_lendo","NULL,".$_SESSION['id'].",$id");
				$resultado = $cadastrar_lendo->inserir();
				if($resultado != 0)
				{
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("$tabela","livro_id=$id AND usuario_id =".$_SESSION['id']);
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
				$cadastrar_quero_ler = new Inserir("tbl_lendo","NULL,".$_SESSION['id'].",$id");
				$resultado = $cadastrar_quero_ler->inserir();
				if($resultado != 0)
				{
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("$tabela","livro_id=$id AND usuario_id =".$_SESSION['id']);
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
					$deletar_antigo = new Deletar("$tabela","livro_id=$id AND usuario_id =".$_SESSION['id']);
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