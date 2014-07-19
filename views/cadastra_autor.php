<?php
	
	//Verifica se o botão foi acionado
	if(isset($_POST['cadastrar_autor']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
		//Instancia e passa os valores para a classe de Insert que cadastrará o autor
		$valores_autor = "NULL,'".$nome."'";
		$cadastrar_autor = new Inserir("tbl_autor",$valores_autor);
		$resposta = $cadastrar_autor->inserir();
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Autor cadastrado com sucesso!</strong>
						</section>";
		}
		else
		{
			echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao cadastrar autor.</strong> Tente novamente!
				</section>";	
		}
	}

?>