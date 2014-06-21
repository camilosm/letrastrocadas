<?php
	//Verifica se o botão foi acionado
	if(isset($_POST['alterarDados']))
	{
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
		$valores_altera_dados_perfil = "nome = '" .$nome. "',
        data_nasc = '".$data_nasc."',
        genero_favorito = '".$genero_fav."',
		logradouro = '".$logradouro."',
		numero = ".$numero.",
		cep = '".$cep."',
		cidade = '".$cidade."',
		bairro = '".$bairro."',
		uf = '".$uf."',
		complemento = '".$complemento."'";
		
		$condicao = "id_usuario = 1";
		$alterar_dados = new Alterar("tbl_usuario",$valores_altera_dados_perfil, $condicao);
		$resposta = $alterar_dados->alterar();
		
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			echo "OK";
		}
		else
		{
			echo "Erro ao alterar os dados";
		}
	}

?>