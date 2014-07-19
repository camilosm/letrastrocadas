<?php
	
	// Por motivos de segurança verifica de novo se o botão foi acionado
	if(isset($_POST['cadastrar_genero']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeString($_POST['nome']);
		
		//Instancia e passa os valores para a classe de Insert que cadastrará o autor
		$valores_categoria = "NULL,'".$nome."'";
		$cadastrar_categoria = new Inserir("tbl_categoria",$valores_categoria);
		$resposta = $cadastrar_categoria->inserir();
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			echo "Genero cadastrado com sucesso";
		}
		else
		{
			echo "Erro ao cadastrar o genero";
		}
	}

?>