<?php
	if($_SESSION['nivel_acesso'] == 1)
	{ 
		if($_SESSION['status'] == 4)
		{
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");
			include("class_editar_caracteres.php");

			if(isset($_POST['pesquisar_livro']))
			{
				//Instancia e faz conexão com o banco de dados
				$banco = new Banco();

				$nome = $_POST['pesquisa'];
					
				$editar_nome = new EditarCaracteres($nome);
				$nome = $editar_nome->sanitizeStringNome($_POST['pesquisa']);

				$limite = 6;
				$pagina = $_GET['pag'];

				if(!$pagina)
				{
					$pagina = 1;
				}

				$inicio = ($pagina * $limite) - $limite;
				
				$campos = "id_livro,imagem_livros,livro.nome AS NomeLivro,edicao,autor.nome AS NomeAutor,editora.nome As NomeEditora, categoria.nome As NomeCategoria ";
				$tabelas = "tbl_livro livro JOIN tbl_editora editora JOIN tbl_autor autor JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
				$condicao = "livro.nome like '%$nome%'";

				$pesquisa_dados = new Pesquisar($tabelas,$campos,$condicao);
				 
				$resultado_dados = $pesquisa_dados->pesquisar();
				
				$quantidade = new Pesquisar($tabelas,'id_livro',$condicao);
				  
				$resultado_quantidade = $quantidade->pesquisar();
				$total_registros = mysql_num_rows($resultado_quantidade);
				$total_paginas = Ceil($total_registros / $limite);
				
				//paginação
				$total = 6;// total de páginas

				$max_links = 4;// número máximo de links da paginação: na verdade o total será cinco 4+1=5

				//$pagina = 3; // página corrente

				// calcula quantos links haverá à esquerda e à direita da página corrente
				// usa-se ceil() para assegurar que o número será inteirolinks_laterais
				  
				
				$aspas = "'";
			}
?>

<article id  = "body_cadastra_livro_usu" style="width: 80%; margin-left: 10%;">
	<fieldset>
		<form  method="post" action=""  role="search "enctype="multipart/form-data">
			<legend>Pesquise o livro e clique em disponibilizar livro</legend>
			<section class="row">
				<section class="col-xs-9">
					<section class="form-group">
						<input type="text" name = "pesquisa" class="form-control" placeholder="Procurar">
					</section>
				</section>
				<section class="col-md-offset-11">
					<button type="submit" name = "pesquisar_livro" class="btn btn-default">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</section>
			</section>
		</form>
		<section class="panel panel-body">
			<?php
				if(isset($_POST['pesquisar_livro']))
				{
					$num_registros = mysql_num_rows($resultado_dados);
					if ($num_registros != 0)
					{
						$ct=0;
						while($dados_pesq = mysql_fetch_assoc($resultado_dados))
						{
							$ct++;
							if(($ct == 1) OR ($ct == 3) OR ($ct == 5))
							{
								echo '<section class="row">';
							}
							echo '<section class="col-md-6">
									<section class = "col-md-4">	
										<section class = "bs-component" style = "margin-left: 10%; maxheight: 177px; width: 120px;"> 
											<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" class = "thumbnail">
												<img src = "'.$dados_pesq['imagem_livros'].'" alt = ""/> 
											</a>	
										</section>
									</section>
									<section class="col-md-6">
										<section style="">
											<center>
												<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($dados_pesq['NomeLivro']).'</h3></a>				  
												<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"><h4>'.utf8_encode($dados_pesq['NomeAutor']).' </h4></a>
												<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"><h5>'.utf8_encode($dados_pesq['NomeEditora']).'</h5></a>
												<a href="?url=perfil_categoria title = "Clique para ver mais livros desta editora"><h5>'.utf8_encode($dados_pesq['NomeCategoria']).'</h5></a>
											</center>
										</section>
									</section>';
							if(!empty($_SESSION['nivel_acesso']))
							{
								echo '<section class="col-md-10">
											<section class = "btn-group" style="left:45%;">
												<a href="?url=passo-a-passo-dados-usuario&cod='.$dados_pesq['id_livro'].'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>
											</section>
									</section>
								</section>';
							}
							else
							{
								echo '</section>';
							}

							if(($ct == 2) OR ($ct == 4) OR ($ct == 6))
							{
								echo '</section><br>';
							}
						}
					}
					else 
					{
						echo 'Nenhum resultado foi encontrado';
					}
				}
								
			?>
		</section>
		<?php
			echo '<ul class="pagination" style = "margin-left:40%;">
					<li class="disabled"><a>«</a></li>';

			for($i=1; $i <= $total_paginas; $i++)
			{
				if($pagina == $i)
				{
					echo '<li class="active"><a>'.$i.'</a></li>';
				}
				else
				{
					if ($i >= 1 && $i <= $total)
					{
						echo '						
							  <li><a href="?url=pesquisa&pag='.$i.'&nome='.$conteudo_text.'">'.$i.'</a></li>
						';
					}
				}
				
			}

			echo ' <li class="disabled"><a>»</a></li>
				</ul>';
		?>
	</fieldset>
</article>
<?php

		}
		else
		{
			echo '<section class="alert alert-dismissable alert-info" style="width:40%;margin-left:30%";>
				<strong>Você precisa completar seu <a href="?url=alterar_dados_perfil">perfil</a> para disponibilizar um livo!</strong>
			</section>';
		}
	}
	else
	{	
		//Redireciona pra página principal
		if($_SESSION['nivel_acesso'] == 2)
		{
			header("location: ?url=home_admin");
		}
		else
		{
			header("location: ?url=home_visitante");
		}
	}

?>