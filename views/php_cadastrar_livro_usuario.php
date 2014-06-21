<?php
	// Nem vou comentar isso aqui por que vai ser mais fácil exlcuir tudo e começar do zero do que tentar concertar
	if(isset($_POST['cadastrarLivroUsuario']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		session_start();
		include ("classes/upload.class.php");		    // inclusão da classe
		
		//Primeira Foto
		$up = new upload();			    // instância do objeto
		$up->pasta     = "content/imagens/livros_usuario"; 	            // pasta de destino 
		$up->nome      = $_FILES['primeira_foto']['name'];   // nome da imagem enviada do form
		$up->tmp_name  = $_FILES['primeira_foto']['tmp_name'];// arquivo temporário
		$up->img_marca = "teste.png";		     // caminho da imagem que será marca d'agua (.png)
		$up->largura   = "120";			     // máxima largura para a nova foto
		$up->altura    = "177";			     // máxima altura para a nova foto
		$destino_primeira = $up->uploadArquivo();			     // execução do método
		
		//Primeira Foto
		$up = new upload();			    // instância do objeto
		$up->pasta     = "content/imagens/livros_usuario"; 	            // pasta de destino 
		$up->nome      = $_FILES['segunda_foto']['name'];   // nome da imagem enviada do form
		$up->tmp_name  = $_FILES['segunda_foto']['tmp_name'];// arquivo temporário
		$up->img_marca = "teste.png";		     // caminho da imagem que será marca d'agua (.png)
		$up->largura   = "120";			     // máxima largura para a nova foto
		$up->altura    = "177";			     // máxima altura para a nova foto
		$destino_segunda = $up->uploadArquivo();			     // execução do método
		
		//Primeira Foto
		$up = new upload();			    // instância do objeto
		$up->pasta     = "content/imagens/livros_usuario"; 	            // pasta de destino 
		$up->nome      = $_FILES['terceira_foto']['name'];   // nome da imagem enviada do form
		$up->tmp_name  = $_FILES['terceira_foto']['tmp_name'];// arquivo temporário
		$up->img_marca = "teste.png";		     // caminho da imagem que será marca d'agua (.png)
		$up->largura   = "120";			     // máxima largura para a nova foto
		$up->altura    = "177";			     // máxima altura para a nova foto
		$destino_terceira = $up->uploadArquivo();			     // execução do 
		//Verifica os retornos para saber se as imagens foram baixadas
		if($destino_primeira == "Tamanho ou formato da imagem não suportado(Aceitamos somente JPG)")
		{
			echo "Erro na primeira foto!<BR>";
		}
		else
		{
			if($destino_segunda == "Tamanho ou formato da imagem não suportado(Aceitamos somente JPG)")
			{
				echo "Erro na segunda foto!<BR>";
			}
			else
			{
				if($destino_terceira == "Tamanho ou formato da imagem não suportado(Aceitamos somente JPG)")
				{
					echo "Erro na terceira foto!<BR>";
				}
				else
				{
					$estado = $_POST['estado'];
					$ano = $_POST['ano'];
					
					//Evitar MySql Inject
					$editar_estado = new EditarCaracteres($estado);
					$estado = $editar_estado->sanitizeStringNome($_POST['estado']);
					
					$editar_ano = new EditarCaracteres($ano);
					$ano = $editar_ano->sanitizeString($_POST['ano']);
					
					// Caddastrar os dados que o usuário passou pelo formulário
					$valores = "NULL,".$livro_id.",".$_SESSION["id"].",'".$ano."','"$estado"'";
					$cadastrar_livro = new Inserir("tbl_lista_livros",$valores);
					$res = $cadastrar_livro->inserir();
					//Verifica se deu certo
					if($res)
					{
						//Cadastra o caminho das imagens no banco de dados
						$valores_imanges = "NULL,'content/imagens/livros_usuario/".$destino_primeira."','content/imagens/livros_usuario/".$destino_segunda."','content/imagens/livros_usuario/".$destino_terceira."',1";// O ultimo aqui é o id do livro só que eu ainda to pensando em um jeito de pegar ele 
						$cadastrar_imagem_livro = new Inserir("tbl_lista_livros",$valores_imanges);
						$res_imagem_livro = $cadastrar_imagem_livro->inserir();
						if($res_imagem_livro)
						{
							echo "Livro cadastrado com sucesso";
						}
						else
						{
							echo "Erro ao cadastrar as imagens";
						}
					}
					else
					{
						echo "Erro ao cadastrar os livros";
					}
				}
			}
		}
	}
	else
	{
		echo "Nós precisamos de 3 fotos do seu livro para efetuar o cadastro!";
	}

?>