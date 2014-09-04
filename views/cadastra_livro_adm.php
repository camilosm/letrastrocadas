<?php
	
	if($_SESSION['nivel_acesso'] == 2)
	{
		// Include na classes de conexão com o banco de dados
		include("classes/class_banco.php");
		include ("classes/class_pesquisar.php");
		include ("classes/class_insert.php");
		include("class_editar_caracteres.php");
		$banco_dados = new Banco();

		// Realiza as pesquisas para a gente poder preencher os combobox da página de cadastro livro do adm
		$pesquisar_editora = new Pesquisar("tbl_editora","*","1=1");
		$resultado_editora = $pesquisar_editora->pesquisar();
		
		$pesquisar_autor = new Pesquisar("tbl_autor","*","1=1");
		$resultado_autor = $pesquisar_autor->pesquisar();
		
		$pesquisar_genero = new Pesquisar("tbl_categoria","*","1=1");
		$resultado_genero = $pesquisar_genero->pesquisar();
		
		if(isset($_POST['cadastrarLivro']))
		{
			
		}		
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
?>
<article id  = "body_cadastra_livro" style = "width:50%;position:relative;left:27%;">
	<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<legend>Cadastrar Livro</legend>
			<section class="form-group">
				<label for="inputID" class="col-lg-2 control-label">ID:</label>
				<section class="col-lg-9">
					<input type="text" class="form-control" name = "id_livro" value="<?php echo $id ;?>" placeholder = "ID" >
				</section>
				<label for="inputNome" class="col-lg-2 control-label">Nome:</label>
				<section class="col-lg-9">
					<input type="text" class="form-control" value="<?php echo $nome ;?>" name = "nome" required placeholder = "Nome do Livro" maxlength = "100">
				</section>
				<label for="inputEdicaolivro" class="col-lg-2 control-label">Edição:</label>				  
				<section class="col-lg-9">
					<input type="number" class="form-control" value="<?php echo $edicao ;?>" name = "edicao" id="inputEdicao" required placeholder = "Edição do livro" maxlength = "20" min = "0" max = "20000">
				</section>	 
				<label for="inputIsnblivro" class="col-lg-2 control-label">ISBN:</label>
				<section class="col-lg-9">
					<input type="number" class="form-control" value="<?php echo $isbn ;?>" name="isbn" id="inputISBN" required maxlength = "17" placeholder = "ISBN" min="0" max = "20000">				  
				</section>
				<label for="select" class="col-lg-2 control-label">Editora:</label>
				<section class="col-lg-9">
					<select class="form-control" value="<?php echo $editora ;?>" name = "cmbEditora" id="select">
						<?php
							while($dados_editora = mysql_fetch_row($resultado_editora))
							{
								echo "<option value = ".$dados_editora[0].">".$dados_editora[1]."</option>";
							}
						?>
					</select>
				</section> 
				<label for="select" class="col-lg-2 control-label">Autor:</label>
				<section class="col-lg-9">
					<select class="form-control" value="<?php echo $autor ;?>"name = "cmbAutor" id="select">
						<?php
							while($dados_autor = mysql_fetch_row($resultado_autor))
							{
								echo "<option value = ".$dados_autor[0].">".$dados_autor[1]."</option>";
							}
						?>
					</select>
				</section>
				<label for="select" class="col-lg-2 control-label">Gênero:</label>
				<section class="col-lg-9">
					<select class="form-control" value="<?php echo $genero ;?>"name = "cmbGenero" id="select">
						<?php
							while($dados_genero = mysql_fetch_row($resultado_genero))
							{
								echo "<option value = ".$dados_genero[0].">".$dados_genero[1]."</option>";
							}
						?>
					</select>
				</section>
				<label for="textArea" class="col-lg-2 control-label">Sinopse:</label>
				<section class="col-lg-9">
					<textarea class="form-control" rows="3" value="<?php echo $sinopse ;?>" name="sinopse" id="textArea"></textarea>
				</section>
				<label for="inputEdicaolivro" class="col-lg-2 control-label">Páginas:</label>				  
				<section class="col-lg-9">
					<input type="number" class="form-control" value="<?php echo $numero_paginas ;?>" name = "numero_paginas" id="inputNumeros" required placeholder = "Números de páginas" maxlength = "20" min = "0" max = "20000">
				</section>
				<label for="inputFotolivro" class="col-lg-2 control-label">Foto: </label>
				<section class="col-lg-9">
					<input type="file"  name="file" "position:relative; width:25%; height: 5%;left:20%;top:2%; "/>
				</section> 
				<section class="col-lg-9 col-lg-offset-2">                    
					<button style="margin-left: 5px; float:right;" type="submit" name = "cadastrarLivro" class="btn btn-primary">Cadastrar</button>
					<button style="margin-left: 5px; float:right;" type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					<button style="float:right;" type = "reset" class="btn btn-default">Cancelar</button>
				</section>
			</section>
		</fieldset>
	</form>
	</article>
	<section id="body_cadastrar_editora" style = "display:none">
		<form id = "cadastrar_editora" method="post" action = "">
			<input type = "text" name = "editora_nome" required placeholder = "Nome" maxlength = "100">
			<input type = "submit" name = "cadastrar_editora" value = "Cadastrar Editora">
		</form>	
	</section>
	<section id="body_cadastrar_autor" style = "display:none">
		<form id = "cadastrar_autor" method="post" action = "">
			<input type = "text" name = "autor_nome" required placeholder = "Nome" maxlength = "100">
			<input type = "submit" name = "cadastrar_autor" value = "Cadastrar Autor">
		</form>
	</section>
</article>
