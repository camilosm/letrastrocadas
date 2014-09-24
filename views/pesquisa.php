<script type="text/javascript" src="ajax/ajax.js"></script>
<?php

		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		include("class_editar_caracteres.php");

		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();

		$texto_pesquisa =  $_POST['pesquisa'];
		
		if(!$texto_pesquisa)
		{
			$texto_pesquisa = $_GET['nome'];
		}

		$editar = new EditarCaracteres($texto_pesquisa);
		$texto_pesquisa = utf8_decode($editar->Pesquisa($texto_pesquisa));

		$limite = 6;
		$pagina = $_GET['pag'];

		if(!$pagina)
		{
			$pagina = 1;
		}

		$inicio = ($pagina * $limite) - $limite;
		
		$pesquisa_dados = new Pesquisar("tbl_lista_livros lista
		  LEFT JOIN tbl_livro livro 
		  ON lista.livro_id = id_livro
		  lEFT JOIN tbl_fotos_livros
		  ON lista_livro_id = id_lista_livros
		  LEFT JOIN tbl_usuario usuario
		  ON usuario_id = id_usuario
		  LEFT JOIN tbl_editora editora 
		  ON editora_id = id_editora
		  LEFT JOIN tbl_autor autor 
		  ON autor_id = id_autor
		  LEFT JOIN tbl_categoria categoria
		  ON categoria_id = id_categoria",
		  "lista.id_lista_livros,
		  id_livro,
		  id_usuario,
		  imagem_livros,
		  livro.nome AS NomeLivro, 
		  autor.nome AS NomeAutor, 
		  editora.nome AS NomeEditora,
		  categoria.nome AS NomeCategoria,
		  primeira_foto,
		  segunda_foto,
		  terceira_foto,
		  usuario.nome AS NomeUsuario",
		"livro.nome LIKE '%".$texto_pesquisa."%'
		  OR autor.nome LIKE '%".$texto_pesquisa."%'
		  OR editora.nome LIKE '%".$texto_pesquisa."%'
		  OR usuario.nome LIKE '%".$texto_pesquisa."%'
		  ORDER BY livro.nome LIMIT $inicio,$limite");
		 
		$resultado_dados = $pesquisa_dados->pesquisar();
		
		$quantidade = new Pesquisar("tbl_lista_livros lista
		  LEFT JOIN tbl_livro livro 
		  ON lista.livro_id = id_livro
		  lEFT JOIN tbl_fotos_livros
		  ON lista_livro_id = id_lista_livros
		  LEFT JOIN tbl_usuario usuario
		  ON usuario_id = id_usuario
		  LEFT JOIN tbl_editora editora 
		  ON editora_id = id_editora
		  LEFT JOIN tbl_autor autor 
		  ON autor_id = id_autor
		  LEFT JOIN tbl_categoria categoria
		  ON categoria_id = id_categoria",
		  "lista.id_lista_livros",
		  "livro.nome LIKE '%".$texto_pesquisa."%'
		  OR autor.nome LIKE '%".$texto_pesquisa."%'
		  OR editora.nome LIKE '%".$texto_pesquisa."%'
		  OR usuario.nome LIKE '%".$texto_pesquisa."%'
		  ORDER BY livro.nome");
		  
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
?>

<article id = "body_pesquisa">
	<section class="panel panel-default" style="width: 80%; margin-left: 10%;">
		<section class="panel-heading">
			<h4>Resultados</h4>
		</section>
		<section class="panel panel-body">
			<?php
				$num_registros = mysql_num_rows($resultado_dados);
				if ($num_registros != 0)
				{
					$ct=0;
					while($dados_pesq = mysql_fetch_assoc($resultado_dados))
					{
						if(!empty($_SESSION['id']))
						{
							$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$dados_pesq['id_livro']." AND usuario_id=".$_SESSION['id']);
							$resultado_marcacao = $pesquisar_marcacões->pesquisar();
							$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
							
								if($array_marcacao['tipo'] == 1)
								{
									$botões = ' 
												<button id = "Resultado'.$ultimos['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-xs">Quero Ler</button>
												<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
												</ul>';
								}
								else if($array_marcacao['tipo'] == 2)
								{
									$botões = ' 
											<button id = "Resultado'.$ultimos['id_livro'].'" value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-xs">Já Li</button>
											<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul id = "acoes" class="dropdown-menu">
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Quero Ler</a></li>
											</ul>';
								}
								else if($array_marcacao['tipo'] == 3)
								{
									$botões = ' 
											<button id = "Resultado'.$ultimos['id_livro'].'" value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-xs">Estou lendo</button>
											<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul id = "acoes" class="dropdown-menu">
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
											</ul>';
								}
								else
								{
									$botões = '
												<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "Eu" type="button" class="btn btn-primary btn-xs">Eu...</button>
												<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
												</ul>';
								}
						}
						else
						{
							$botões = "";
						}
						$ct++;
						if(($ct == 1) OR ($ct == 3) OR ($ct == 5))
						{
							echo '<section class="row">';
						}
						echo '<section class="col-md-6">
								<section class = "col-md-4">	
									<section class = "bs-component" style = "margin-left: 10%; maxheight: 177px; width: 120px;"> 
										<a href="?url=livro&livro='.$dados_pesq["id_livro"].'" class = "thumbnail">
											<img src = "'.$dados_pesq['imagem_livros'].'" alt = ""/> 
										</a>	
									</section>
								</section>
								<section class="col-md-4">
									<section style="">
										<center>
											<a href="?url=livro&livro='.$dados_pesq["id_livro"].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($dados_pesq['NomeLivro']).'</h3></a>				  
											<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($dados_pesq['NomeAutor']).' </h4></a>
											<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($dados_pesq['NomeEditora']).' </h5></a>
											<a href="?url=perfil_usuario&cod='.$dados_pesq['id_usuario'].'"> <h4>'.utf8_encode($dados_pesq['NomeUsuario']).' </h4></a>
										</center>
									</section>
								</section>';
						if(!empty($_SESSION['nivel_acesso']))
						{
							echo '<section class="col-md-8">
									<section style="margin-top: 10%;margin-left: -30%;">
										<section class = "btn-group">
											<a href="?url=passo-a-passo-dados-usuario&cod='.$dados_pesq['id_livro'].'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>		
											&nbsp;&nbsp;											 
											<button type = "button" class="btn btn-primary btn-xs dropdown-toggle" id = "solicitar" onClick="SolicitarLivro('.$aspas.''.$dados_pesq["id_lista_livros"].''.$aspas.','.$aspas.''.$dados_pesq['id_usuario'].''.$aspas.')">Solicitar Livro</button>
											'.$botões.'
										</section>
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
								
			?>
			<br>
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
		</section>
	</section>
</article>