<style>
	.coments{
		cursor: pointer;
	}
</style>
<?php

	include("class_editar_caracteres.php");
	include("classes/class_banco.php");
	include("classes/class_pesquisar.php");
	include("classes/class_insert.php");

	if(!empty($_GET['livro']))
	{
		$id_livro = $_GET['livro'];

		$editar_id = new EditarCaracteres($id_livro);
		$id_livro = $editar_id->sanitizeNumber($_GET['livro']);

		if($id_livro != "")
		{
			$bd = new Banco(); 

			if(isset($_POST['Comentar']))
			{
				$coment = $_POST['comentario'];

				$editar_coment = new EditarCaracteres($coment);
				$coment = $editar_coment->sanitizeStringNome($_POST['comentario']);

				$cadastrar_comentario = new Inserir('tbl_comentarios','NULL,'.$_SESSION['id'].','.$id_livro.',"'.utf8_decode($coment).'",NULL');
				$resultado = $cadastrar_comentario->inserir();
				if($resultado != 1)
				{
					echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
								<strong>Alguma coisa deu errado! Por favor, tente mais tarde.</strong>
							</section>";
				}
			}

			$campos_lista = "COUNT(id_livro) as qt";
			$tabelas_lista = "tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
			$condição_lista = "id_livro = $id_livro LIMIT 1";

			$pesquisar_qt = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_qt = $pesquisar_qt->pesquisar();

			$array = mysql_fetch_assoc($resultado_qt);
			$quantidade = $array['qt'];

			if($quantidade >=1)
			{
				$campos_lista = "livro.*,autor.nome AS Autor,categoria.nome as Categoria,editora.nome As Editora";
				$tabelas_lista = "tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
				$condição_lista = "id_livro = $id_livro LIMIT 1";

				$pesquisar_livro = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
				$resultado = $pesquisar_livro->pesquisar();

				$pesquisar_comentario = new Pesquisar('tbl_comentarios JOIN tbl_usuario ON id_usuario = usuario_id','nome,tbl_comentarios.*','livro_id ='.$id_livro);
				$comentarios = $pesquisar_comentario->pesquisar();

?>
<section id = "body_livros_autores">
	<section class="panel panel-default" style = "width:70%; height:60%; position:relative; left:15%;">
		<section class="panel-body">
			<?php

				while($livro = mysql_fetch_assoc($resultado))
				{
					echo '
						<section class = "row">
							<section class = "col-lg-4" style = "width: auto;">	
								<section class = "bs-component"> 
									<a class = "thumbnail">
										<img src = "'.$livro['imagem_livros'].'" alt = "'.utf8_encode($livro['nome']).'" height = "177px" width = "120px">
									</a>
								</section>
							</section>
							<section class = "col-lg-4">
								<a><h3>'.utf8_encode($livro['nome']).'</h3></a>				  
								<a><h4>'.utf8_encode($livro['Autor']).'</h4></a>
								<a><h5>'.utf8_encode($livro['Editora']).'</h5></a>
							</section>
							<section class = "col-lg-4" style = "width:48%;">
								<textarea class="form-control" rows="9" disabled>
									'.$livro['sinopse'].'
								</textarea>
							</section> 
						</section>
						<br/>
						<section class = "row">
							<section class = "col-lg-4">
								<a><h4>Edição : '.$livro['edicao'].'</h4></a>
								<a><h4>ISBN 10 : '.utf8_encode($livro['isbn']).'</h4></a>				  
								<a><h4> ISBN 13 : '.utf8_encode($livro['isbn']).'</h4></a>
								<a><h4> Nº de páginas : '.utf8_encode($livro['numero_paginas']).'</h4></a>
								<a><h4> Querem Ler : '.utf8_encode($livro['querem_ler']).'</h4></a>
								<a><h4> Lendo : '.utf8_encode($livro['lendo']).'</h4></a>
								<a><h4> Lido : '.utf8_encode($livro['lido']).'</h4></a>
							</section>
						</section>
					';
				}

				echo '
					<section class = "row">
						<section class = "col-lg-10" style="margin-left:7%">
							<fieldset>									
								<legend>Comentários</legend>
								<section class="panel panel-default" style="height:300px;overflow:auto;">
					';
				while($comentario=mysql_fetch_assoc($comentarios))
				{
					echo '
									<section style="min-height:13%;">
										<p><a class = "coments">'.utf8_encode($comentario['nome']).'</a> '.utf8_encode($comentario['comentario']).'<p>
									</section>
					';
				}
				if(!empty($_SESSION['id']))
				{
					if($_SESSION['status'] == 4)
					{
						echo '
											</section>
											<form class="form-horizontal" action = "" method = "post">
												<input type="text" class="form-control" name = "comentario" id="comentario" placeholder="O que você achou desse livro?">
												<button type="submit" name = "Comentar" class="btn btn-primary">Enviar</button>
											<form>
										</fieldset>
									</section>
								</section>
						';
					}
					else
					{
						echo '</section>
									<section class="alert alert-dismissable alert-info" style="width:40%;margin-left:30%";>
										<strong>Você precisa completar seu <a href="?url=alterar_dados_perfil">perfil</a> para conversar sobre este livro!</strong>
									</section>
								</fieldset>
							</section>
						</section>';
					}
				}
				else
					{
						echo '</section>
									<section class="alert alert-dismissable alert-info" style="width:40%;margin-left:30%";>
										<strong>Você precisa se <a href="?url=cadastro_usuario">cadastrar</a> no nosso site para poder conversar sobre este livro!</strong>
									</section>
								</fieldset>
							</section>
						</section>';
					}

			?>
		</section>
	</section>
</section>
<?php
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Livro não encontrado =/ Tente outro código!</strong>
				</section>";
			}
		}
		else
		{	
			echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
					<strong>Livro não encontrado =/ Tente outro código!</strong>
			</section>";	
		}
	}
	else
	{
		echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
				<strong>Livro não encontrado =/ Tente outro código!</strong>
		</section>";
	}

?>