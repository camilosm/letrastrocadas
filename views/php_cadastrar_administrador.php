<?php
	
	// Verifica se o botão foi acionado
	if(isset($_POST['cadastrar']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$confirmarsenha = $_POST['confirmarsenha'];
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
		$editar_email = new EditarCaracteres($email);
		$email = $editar_email->sanitizeStringemail($_POST['email']);
		
		$editar_senha = new EditarCaracteres($senha);
		$senha = $editar_senha->sanitizeStringNome($_POST['senha']);
		
		$editar_confirmarsenha = new EditarCaracteres($confirmarsenha);
		$confirmarsenha = $editar_confirmarsenha->sanitizeStringNome($_POST['confirmarsenha']);		
		
		//Verifica se o email termina com o final letrastrocadas.com.br (Isso aqui ainda vai mudar)
		if(preg_match('/letrastrocadas.com.br$/', $email))
		{
			// Verifica se a senha e confirmar senha estão corretos
			if($confirmarsenha == $senha)
			{
				// Instancia e passa os valores para a classe responsável por cadastrar no banco de dados 
				$valores_administrador = "NULL,'".$nome."',2,'".$email."','".$senha."'";
				$cadastrar_administrador = new Inserir("tbl_administrador",$valores_administrador);
				$resposta = $cadastrar_administrador->inserir();
				// Verifica se ouve resposta e envia uma mensagem 
				if($resposta)
				{
					echo "Administrador cadastrado com sucesso";
				}
				else
				{
					echo "Erro ao cadastrar o administrador";
				}
			}
			else
			{
				echo "Senha e Confirmação de senha estão diferentes";
			}
		}
		// Se não terminar com o nosso letrastrocadas.com.br está errado.
		else
		{
			echo "Email em um formato incorreto para administradores";
		}
	}

?>