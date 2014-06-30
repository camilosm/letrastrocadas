<?php
	//Verifica se o botão foi acionado
	
	if(isset($_POST['alterar_dados_admin']))
	{
		$id = $_SESSION['id'];
		
		include("class_editar_caracteres.php");
		include("classes/class_update.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		$nivel_acesso = $_POST['nivel_acesso'];
		$email = $_POST['email'];
		
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);

		
		//Instancia e passa os valores para a classe de Update 
		$valores_altera_dados_admin = "nome = '" .utf8_decode($nome). "',
        nivel_acesso = '".$nivel_acesso."',
        email = '".$email."'";
		
		$condicao = "id_administrador =".$id."";
		$alterar_dados = new Alterar("tbl_administrador",$valores_altera_dados_admin, $condicao);
		$resposta = $alterar_dados->alterar();
		echo $resposta;
		//Confere se houve resposta e envia mensagem de erro ou sucesso.
		if($resposta)
		{
			echo "<div class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
					  <strong>Seus dados foram alterados com sucesso!</strong>
			</div>";
		}
		else
		{
			echo "<div class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
				  <strong>Erro ao alterar dados.</strong> Tente novamente!
			</div>";
			
		}
	}

?>