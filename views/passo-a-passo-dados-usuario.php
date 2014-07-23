<?php
	if($_SESSION['nivel_acesso'] == 1)
	{
		include("class_editar_caracteres.php");
		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		
		$bd = new Banco();
		
		$id = $_GET['cod'];
		
		if(isset($_POST['cadastrarLivroUsuario']))
		{
			//Pasta onde vai ser salvo
			$pasta = 'content/imagens/livro_usuario/';
			
			//Tipo de imagens permitidos
			$permite = array('image/jpg','image/jpeg');//'image/pjpeg'
			
			//Pegando a imagem enviada pelo formulário
			$imagem_primeira = $_FILES['primeira_foto'];
			//Não entendi isso mas eu sei que precisa 
			$destino_primeira = $imagem_primeira['tmp_name'];
			//Nome do arquivo
			$nome_primeira = $imagem_primeira['name'];
			//Tipo do arquivo
			$tipo_primeira = $imagem_primeira['type'];
			
			$imagem_segunda = $_FILES['segunda_foto'];
			$destino_segunda = $imagem_segunda['tmp_name'];
			$nome_segunda = $imagem_segunda['name'];
			$tipo_segunda = $imagem_segunda['type'];
			
			$imagem_terceira = $_FILES['terceira_foto'];
			$destino_terceira = $imagem_terceira['tmp_name'];
			$nome_terceira = $imagem_terceira['name'];
			$tipo_terceira = $imagem_terceira['type'];
			
			//Chama a classe de upload
			include("classes/class_upload.php");
			
			if(!empty($nome_primeira) && in_array($tipo_primeira, $permite))
			{
				//Evetua o upload
				upload($destino_primeira, $nome_primeira, 120, $pasta);
				
				if(!empty($nome_segunda) && in_array($tipo_segunda, $permite))
				{
					upload($destino_segunda, $nome_segunda, 120, $pasta);
					
					if(!empty($nome_terceira) && in_array($tipo_terceira, $permite))
					{
						upload($destino_terceira, $nome_terceira, 120, $pasta);
						header("location: ?url=passo-a-passo-confirmar-dados&cod=$id");
						
						session_start();
						
						$_SESSION['estado'] = $_POST['estado'];
						$_SESSION['ano'] = $_POST['ano'];
						$_SESSION['livro'] = $_POST['nome'];
						$_SESSION['edicao'] = $_POST['edicao'];
						$_SESSION['isbn'] = $_POST['isbn'];
						$_SESSION['imagem1'] = $pasta."".$nome_primeira;
						$_SESSION['imagem2'] = $pasta."".$nome_segunda;
						$_SESSION['imagem3'] = $pasta."".$nome_terceira;
						
						
						
					}
					else
					{
						echo "Aceitamos apenas imagens no formato JPEG";
						unlink("content/imagens/livro_usuario/$nome_primeira");
						unlink("content/imagens/livro_usuario/$nome_segunda");
					}
				}
				else
				{
					echo "Aceitamos apenas imagens no formato JPEG";
					unlink("content/imagens/livro_usuario/$nome_primeira");
					
				}
			}
			else
			{
				echo "Aceitamos apenas imagens no formato JPEG";
			}
		}
		
		$editar_id = new EditarCaracteres($id);
		$id = $editar_id->sanitizeString($_GET['cod']);
		
		$pesquisar_livro = new Pesquisar("tbl_livro","nome,edicao,isbn"," id_livro = '$id' LIMIT 1");
		$resultado = $pesquisar_livro->pesquisar();
		
		while($resposta=mysql_fetch_assoc($resultado))
		{
			$nome = $resposta['nome'];
			$edicao = $resposta['edicao'];
			$isbn = $resposta['isbn'];
		}
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
	
?>

<article id  = "body_cadastra_livro_usu" style = "width:60%;height:60%;position:relative;left:30%;">
	<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data">
		<fieldset>
			<legend>Cadastrar livro</legend>
			<section class="form-group">
				<label for="Nome" class="col-lg-2 control-label">Nome:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" value="<?php echo utf8_encode($nome) ;?>" rows="3" name = "nome" required style = "width: 50%;"id="Nome" readonly ></input> 
				</section>
				
				<label for="Edicao" class="col-lg-2 control-label">Edição:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" value="<?php echo $edicao ;?>" rows="3" name = "edicao" required style = "width: 50%;"id="Edicao" readonly ></input> 
				</section>
				
				<label for="ISBN" class="col-lg-2 control-label">ISBN:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" rows="3" value="<?php echo $isbn ;?>" name = "isbn" required style = "width: 50%;"id="ISBN" readonly ></input> 
				</section>
			
				<label for="textArea" class="col-lg-2 control-label">Estado:</label>
				<section class="col-lg-10">
					<textarea class="form-control" name = "estado" rows="3" required style = "width: 50%;"id="textArea" placeholder = "Escreva aqui as condições do livro que deseja disponibilizar(danos, observações, adicionais)"></textarea> 
				</section>
				
				<label for="txtAno" class="col-lg-2 control-label">Ano:</label>
				<section class="col-lg-10">
					<input type="number" min = "1455" max="2014" class="form-control" required name = "ano" id = "txtAno" rows="3" style = "width: 50%;" placeholder = "Ano da fabricação"/>
				</section>
				<label for="inputFotolivro" class="col-lg-2 control-label">Fotos: </label>
				<section style = "position:relative; width:25%; height: 5%;left:20%;top:2%; ">		
					<section class="col-lg-10">
						<input type="file" id="inputFoto1" required name="primeira_foto" >
					</section><br>
					<section class="col-lg-10">
						<input type="file" id="inputFoto2" required name="segunda_foto">
					</section><br>
					<section class="col-lg-10">
						<input type="file" id="inputFoto3" required name="terceira_foto" >
					</section>
				</section>
				<br>
				<section class="col-lg-10 col-lg-offset-2">
					<br>
					<button type = "reset"class="btn btn-default">Limpar</button>
					<button type="submit" name = "cadastrarLivroUsuario" class="btn btn-primary">Cadastrar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>