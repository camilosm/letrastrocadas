<?php
	//Verifica se o botão foi acionado
	if(isset($_POST['cadastrar_editora']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['editora_nome'];
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['editora_nome']);
		
		//Instancia e passa os valores para a classe de Insert que cadastrará o autor
		$valores_editora = "NULL,'".$nome."'";
		$cadastrar_editora = new Inserir("tbl_editora",$valores_editora);
		$resposta = $cadastrar_editora->inserir();
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			echo "Editora cadastrado com sucesso";
		}
		else
		{
			echo "Erro ao cadastrar a editora";
		}
	}

?>