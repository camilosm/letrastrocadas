<?php
	
	include("class_editar_caracteres.php");
	include("classes/class_pesquisar.php");
	include("classes/class_banco.php");
	
	$bd = new Banco();
	if(isset($_POST['confirmaLivroUsuario']))
	{
		
		include("classes/class_insert.php");
		
		$id = $_GET['cod'];
		$ano = $_POST['ano'];
		$estado = $_POST['estado'];
		$imagem1 = $_SESSION['imagem1'];
		$imagem2 = $_SESSION['imagem2'];
		$imagem3 = $_SESSION['imagem3'];
		
		//Desfazer a minha gambiarra érr quer dizer meu recurso técnico
		unset ($_POST['livro']);
		unset ($_POST['edicao']);
		unset ($_POST['isbn']);
		unset ($_POST['ano']);
		unset ($_POST['estado']);
		unset ($_POST['imagem1']);
		unset ($_POST['imagem2']);
		unset ($_POST['imagem3']);
		
		$editar_id = new EditarCaracteres($id);
		$id = $editar_id->sanitizeString($id);
		
		$editar_estado = new EditarCaracteres($estado);
		$estado = $editar_estado->sanitizeStringNome($estado);
		
		$editar_ano = new EditarCaracteres($ano);
		$ano = $editar_ano->sanitizeString($ano);
		
		$campos = "NULL,$id,".$_SESSION['id'].",DATE(NOW()),'$ano','$estado'";	
		$cadastrar_livros = new Inserir("tbl_lista_livros",$campos);	
		$resposta = $cadastrar_livros->inserir();
		if($resposta == 1)
		{
			echo "Deu certo";
			$campos = "NULL,'$imagem1','$imagem2','$imagem3',(SELECT id_lista_livros FROM tbl_lista_livros WHERE livro_id = $id AND usuario_id = ".$_SESSION['id']." LIMIT 1)";	
			$cadastrar_fotos = new Inserir("tbl_fotos_livros",$campos);	
			$resposta_fotos = $cadastrar_fotos->inserir();
			if($resposta_fotos == 1)
			{
				header("location: ?url=livros_disponibilizados");
			}
			else
			{
				echo "Erro ao cadastrar fotos";
			}
		}
		else
		{
			echo "Erro ao cadastrar o seu livro!";
		}
	}
	
	$id = $_GET['cod'];
	$nome = $_SESSION['livro'];
	$edicao = $_SESSION['edicao'];
	$isbn = $_SESSION['isbn'];
	$estado = $_SESSION['estado'];
	$ano = $_SESSION['ano'];
	$imagem1 = $_SESSION['imagem1'];
	$imagem2 = $_SESSION['imagem2'];
	$imagem3 = $_SESSION['imagem3'];
	
	$editar_id = new EditarCaracteres($id);
	$id = $editar_id->sanitizeString($_GET['cod']);
	
	$editar_nome = new EditarCaracteres($nome);
	$nome = $editar_nome->sanitizeStringNome($_SESSION['livro']);
	
	$editar_edicao = new EditarCaracteres($edicao);
	$edicao = $editar_edicao->sanitizeString($_SESSION['edicao']);
	
	$editar_isbn = new EditarCaracteres($isbn);
	$isbn = $editar_isbn->sanitizeString($_SESSION['isbn']);
	
	$editar_estado = new EditarCaracteres($estado);
	$estado = $editar_estado->sanitizeStringNome($_SESSION['estado']);
	
	$editar_ano = new EditarCaracteres($ano);
	$ano = $editar_ano->sanitizeString($_SESSION['ano']);
	
	$tabelas = "tbl_livro livro JOIN tbl_editora editora JOIN tbl_autor autor JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id ";
	$campos=" imagem_livros,numero_paginas,autor.nome As autor,editora.nome As editora,categoria.nome As categoria";
	
	$pesquisar_livro = new Pesquisar($tabelas,$campos,"id_livro = $id LIMIT 1");
	$resultado = $pesquisar_livro->pesquisar();
	
	$dados=mysql_fetch_array($resultado);
	
	$imagem = $dados['imagem_livros'];
	$num_paginas = $dados['numero_paginas'];
	$autor = $dados['autor'];
	$editora = $dados['editora'];
	$categoria = $dados['categoria'];	

?>
<article id  = "body_cadastra_livro_usu" style = "width:60%;height:60%;position:relative;left:30%;">
	<form class="form-horizontal" method="post" action="?url=passo-a-passo-confirmar-dados&cod=<?php echo $id?>"  enctype="multipart/form-data">
		<fieldset>
			<legend>Confirme os dados</legend>
			
			<section class="form-group" style="position:relative;left:9%;">
				<section class="col-lg-6">
					<section class="thumbnail">
							<img src="<?php echo $imagem;?>" alt="" width="35%">
							<p align="center"></p> 
					</section>
				</section>
			</section>
			<section class="form-group">
				<label for="Nome" class="col-lg-2 control-label">Nome:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" value="<?php echo $nome ;?>" rows="3" name = "nome" required style = "width: 50%;"id="Nome" readonly ></input> 
				</section>
				
				<label for="Edicao" class="col-lg-2 control-label">Edição:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" value="<?php echo $edicao ;?>" rows="3" name = "edicao" required style = "width: 50%;"id="Edicao" readonly ></input> 
				</section>
				
				<label for="Numero" class="col-lg-2 control-label">Nº Páginas:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" value="<?php echo $num_paginas ;?>" rows="3" name = "num_paginas" required style = "width: 50%;"id="Edicao" readonly ></input> 
				</section>
				
				<label for="ISBN" class="col-lg-2 control-label">ISBN:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" rows="3" value="<?php echo $isbn ;?>" name = "isbn" required style = "width: 50%;"id="ISBN" readonly ></input> 
				</section>
				
				<label for="Autor" class="col-lg-2 control-label">Autor:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" rows="3" value="<?php echo $autor ;?>" name = "autor" required style = "width: 50%;"id="ISBN" readonly ></input> 
				</section>
				
				<label for="Editora" class="col-lg-2 control-label">Editora:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" rows="3" value="<?php echo $editora ;?>" name = "editora" required style = "width: 50%;"id="ISBN" readonly ></input> 
				</section>
				
				<label for="Categoria" class="col-lg-2 control-label">Categoria:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" rows="3" value="<?php echo $categoria ;?>" name = "categoria" required style = "width: 50%;"id="ISBN" readonly ></input> 
				</section>
			
				<label for="textArea" class="col-lg-2 control-label">Estado:</label>
				<section class="col-lg-10">
					<textarea class="form-control" name = "estado" rows="3" required style = "width: 50%;"id="textArea" placeholder = "Escreva aqui as condições do livro que deseja disponibilizar(danos, observações, adicionais)"><?php echo $estado;?></textarea> 
				</section>
				
				<label for="txtAno" class="col-lg-2 control-label">Ano:</label>
				<section class="col-lg-10">
					<input type="number" min = "1455" max="2014" value="<?php echo $ano;?>" class="form-control" required name = "ano" id = "txtAno" rows="3" style = "width: 50%;" placeholder = "Ano da fabricação"/>
				</section>
				<br>
				<section class="form-group" style="position:relative;left:9%;">
					<section class="col-lg-6">
						<section class="thumbnail" width="100%">
								<img src="<?php 
												if(file_exists("$imagem1"))
												echo $imagem1;
											?>" alt="" width="35%">							
								<img src="<?php 
												if(file_exists("$imagem2"))
												echo $imagem2;
											?>" alt="" width="35%">									
								<img src="<?php 
												if(file_exists("$imagem3"))
												echo $imagem3;
											?>" alt="" width="35%">	
						</section>
						
					</section>
				</section>
				<section class="col-lg-10 col-lg-offset-2">
					<br>
					<button type = "reset"class="btn btn-default">Limpar</button>
					<button type="submit" name = "confirmaLivroUsuario" value ="Cadastrar" class="btn btn-primary">Cadastrar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>