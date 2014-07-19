<?php
	//Verifica se o botão foi acionado
	if(isset($_POST['cadastrar_editora']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
		//Instancia e passa os valores para a classe de Insert que cadastrará o autor
		$valores_editora = "NULL,'".$nome."'";
		$cadastrar_editora = new Inserir("tbl_editora",$valores_editora);
		$resposta = $cadastrar_editora->inserir();
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Editora cadastrada com sucesso!</strong>
						</section>";
		}
		else
		{
			echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao cadastrar editora.</strong> Tente novamente!
				</section>";	
				
		}
	}

?>