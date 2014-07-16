<?php
	//Verifica se o botão foi acionado
	
	if(isset($_POST['alterarDados']))
	{
		$id = $_SESSION['id'];
		
		include("class_editar_caracteres.php");
		include("classes/class_update.php");
				
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		$data_nasc = $_POST['data_nascimento'];
		$genero_fav = $_POST['genero'];
		$logradouro = $_POST['logradouro'];
		$numero = $_POST['numero'];
		$cep = $_POST['cep'];
		$uf = $_POST['uf'];
		$complemento = $_POST['complemento'];
		$cidade = $_POST['cidade'];
		$bairro = $_POST['bairro'];				
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
		//Instancia e passa os valores para a classe de Update 
		$valores_altera_dados_perfil = "nome = '" .utf8_decode($nome). "',
        data_nasc = '".$data_nasc."',
        genero_favorito = '".utf8_decode($genero_fav)."',
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
		echo $resposta;
		
		$idade = mysql_query("call calc_idade($id)");
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			ECHO "OK";
		}
		else
		{
			ECHO "Erro";
		}
	}

?>