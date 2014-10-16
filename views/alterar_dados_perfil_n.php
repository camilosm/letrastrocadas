<?php
	//Verifica se o botão foi acionado
	
	if(isset($_POST['alterarDados']))
	{
		$id = $_SESSION['id'];
		
		include("classes/class_editar_caracteres.php");
		include("classes/class_update.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		$data_nasc = $_POST['data_nascimento'];
		$logradouro = $_POST['logradouro'];
		$numero = $_POST['numero'];
		$cep = $_POST['cep'];
		$uf = $_POST['inputUF'];
		$complemento = $_POST['complemento'];
		$cidade = $_POST['cidade'];
		$bairro = $_POST['bairro'];	
		$nova_imagem = $_POST['caminho'];
		$explode = explode('.',$nova_imagem);
		$imagem = $nova_imagem;
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
		//Instancia e passa os valores para a classe de Update 
		$valores_altera_dados_perfil = "nome = '" .utf8_decode($nome). "',
		status = 4,
		foto = '".$imagem."',
        data_nasc = '".$data_nasc."',
		logradouro = '".utf8_decode($logradouro)."',
		numero = ".$numero.",
		cep = '".$cep."',
		cidade = '".utf8_decode($cidade)."',
		bairro = '".utf8_decode($bairro)."',
		uf = '".$uf."',
		complemento = '".utf8_decode($complemento)."'";
		
		$condicao = "id_usuario =".$id."";
		$alterar_dados = new Alterar("tbl_usuario",$valores_altera_dados_perfil, $condicao);
		$resposta = $alterar_dados->alterar();

		$genero = $_POST['genero'];
		$quantidade = count($genero);
		for ($i=0; $i<$quantidade; $i++) 
		{ 
			if($genero[$i] != "Escolha o seu gênero favorito ...")
			{
				$pes_genero_fav = new Pesquisar('tbl_generos_favoritos','*','categoria_id ='.$genero[$i].' AND usuario_id = '.$_SESSION['id']);
				$res_genero_fav = $pes_genero_fav->pesquisar();
				$qt_genero_fav = mysql_num_rows($res_genero_fav);
				if($qt_genero_fav == 0)
				{
					$ins_genero_fav = new Inserir('tbl_generos_favoritos','NULL,'.$genero[$i].','.$_SESSION['id']);
					$res_genero_fav = $ins_genero_fav->inserir();
				}
			}
		}

		$autor = $_POST['autor'];
		$quantidade = count($autor);
		for ($i=0; $i<$quantidade; $i++) 
		{ 
			if($autor[$i] != "Escolha o seu autor favorito ...")
			{
				$pes_autor_fav = new Pesquisar('tbl_autores_favoritos','*','autor_id ='.$autor[$i].' AND usuario_id = '.$_SESSION['id']);
				$res_autor_fav = $pes_autor_fav->pesquisar();
				$qt_autor_fav = mysql_num_rows($res_autor_fav);
				if($qt_autor_fav == 0)
				{
					$ins_autor_fav = new Inserir('tbl_autores_favoritos','NULL,'.$autor[$i].','.$_SESSION['id']);
					$res_autor_fav = $ins_autor_fav->inserir();
				}
			}
		}

		$generoD = $_POST['generoD'];
		$quantidade = count($generoD);
		for ($i=0; $i<$quantidade; $i++) 
		{ 
			if(($generoD[$i] != "Escolha um gênero que você não gosta...") AND ($generoD[$i] != "Nenhum"))
			{
				$pes_genero_des = new Pesquisar('tbl_generos_desapreciados','*','genero_id ='.$generoD[$i].' AND usuario_id = '.$_SESSION['id']);
				$res_genero_des = $pes_genero_des->pesquisar();
				$qt_genero_des = mysql_num_rows($res_genero_des);
				if($qt_genero_des == 0)
				{
					$ins_genero_des = new Inserir('tbl_generos_desapreciados','NULL,'.$generoD[$i].','.$_SESSION['id']);
					$res_genero_des = $ins_genero_des->inserir();
				}
			}
		}

		$autorC = $_POST['autorC'];
		$quantidade = count($autorC);
		for ($i=0; $i<$quantidade; $i++) 
		{ 
			if(($autorC[$i] != "Escolha um autor que você não gosta...") AND ($autorC[$i] != "Nenhum"))
			{
				$pes_autor_cha = new Pesquisar('tbl_autores_desapreciados','*','autor_id ='.$autorC[$i].' AND usuario_id = '.$_SESSION['id']);
				$res_autor_cha = $pes_autor_cha->pesquisar();
				$qt_autor_cha = mysql_num_rows($res_autor_cha);
				if($qt_autor_cha == 0)
				{
					$ins_autor_cha = new Inserir('tbl_autores_desapreciados','NULL,'.$autorC[$i].','.$_SESSION['id']);
					$res_autor_cha = $ins_autor_cha->inserir();
				}
			}
		}
		
		$idade = mysql_query("call calc_idade($id)");
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			ECHO "Alterado com sucesso";
		}
		else
		{
			ECHO "Erro ao alterar seu perfil";
		}
	}

?>