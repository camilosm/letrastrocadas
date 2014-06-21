<?php
	
	// Por motivos de segurança verifica de novo se o botão foi acionado
	if(isset($_POST['entrar']))
	{
		// Inclui classes com nomes auto-explicativos
		include("classes/class_cadastrar_usuario.php");
		include("classes/class_banco.php");
		include("class_editar_caracteres.php");
		include ("classes/class_pesquisar.php");
		
		//Para que o sistema de Sessions funcione é preciso, primeiro, que nós a iniciemos 
		session_start();
		
		//Instancia o Classe de Banco de dados que já realiza a conexão.
		$banco_dados = new Banco();
		
		//Coloca em variáveis os valores passados pelo formulário
		$login = $_POST['email'];
		$senha = $_POST['senha'];
		$confirmar = $_POST['confirmar'];
		
		// Aqui tentamos evitar MySql Inject
		$editar_login = new EditarCaracteres($login);
		$login = $editar_login->sanitizeStringemail($login);
	
		$editar_senha = new EditarCaracteres($senha);
		$senha = $editar_senha->sanitizeString($_POST['senha']);
		
		$editar_confirmar = new EditarCaracteres($senha);
		$confirmar = $editar_confirmar->sanitizeString($_POST['confirmar']);
		
		// Verifica se o email terminar com letrastrocadas.com.br
		if(preg_match('/letrastrocadas.com.br$/', $login))
		{
			// Só o adm pode cadastrar outro adm e isso acontece em outra página, então isso aqui não deixa que o usuário cadastre com esse final
			echo "Usuário já está sendo utilizado";
		}
		else
		{		
			if($senha === $confirmar)
			{
				//Instancia a classe responsável por cadastrar o usuário e já passa os valores
				$cadastrar = new CadastrarUsu($login,$senha);
				// Manda a classe inserir o usuário no banco de dados
				$res = $cadastrar->inserir();
				// Verifica se tem resposta
				if($res == 1)
				{
					//Instancia a classe de pesquisa e verifica se o usuário realmente foi inserido
					$pesquisar_usuario = new Pesquisar("tbl_usuario","*","email = '".$login."' AND senha = '".$senha."' LIMIT 1");
					// Realiza a pesquisa
					$resultado_pesquisa = $pesquisar_usuario->pesquisar();
					// Confere se foi retornado alguma coisa pela pesquisa
					if(mysql_num_rows($resultado_pesquisa) == 1)
					{	
							$dadosusu = mysql_fetch_assoc($resultado_pesquisa);
							//Preenche a session com dados do usuário
							$_SESSION["nivel_acesso"]=$dadosusu["nivel_acesso"];
							$_SESSION["id"]=$dadosusu["id_usuario"];
							$_SESSION["nome"]=$dadosusu["nome"];
							$_SESSION["email"]=$dadosusu["email"];
							// Redireciona para o menu do usuário
							header("Location: ?url=index_usuario");
						
					}
				}
				else
				{
					// Aconteceu algum erro e o usuário não foi cadastrado
					echo "Não foi possivel efetuar o cadastro";
				}
			}
			else
			{
				echo "As senhas não conferem";
			}
		}
	}
?>