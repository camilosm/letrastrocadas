<script type="text/javascript" src="ajax/ajax.js"></script>
<?php

		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		
		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();
		
		$conteudo_text =  $_POST['conteudo_text']; 	
		
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
		  imagem_livros,
		  livro.nome AS NomeLivro, 
		  autor.nome AS NomeAutor, 
		  editora.nome AS NomeEditora,
		  categoria.nome AS NomeCategoria,
		  primeira_foto,
		  segunda_foto,
		  terceira_foto,
		  usuario.nome AS NomeUsuario",
		"livro.nome LIKE '%".$conteudo_text."%'
		  OR autor.nome LIKE '%".$conteudo_text."%'
		  OR editora.nome LIKE '%".$conteudo_text."%'
		  OR usuario.nome LIKE '%".$conteudo_text."%'
		  GROUP BY livro.nome
		  ORDER BY livro.nome");
		 
		$resultado_dados = $pesquisa_dados->pesquisar();
	
		$aspas = "'";
?>

<section id = "body_pesquisa">
	<section class="panel panel-default" style="width: 70%; margin-left: 5%;">
		<section class="panel-heading">
			<h4>Resultados</h4>
		</section>
		<section class="panel panel-body">
			<section class="row">
				<?php 
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
								echo  '<section class="col-md-6">
											<section class = "col-lg-4">	
												<section class = "bs-component" style = "height: 177px; width: 120px;"> 
													<a href="?url=livro" class = "thumbnail">
														<img src = "'.$dados_pesq['imagem_livros'].'" alt = ""/> 
													</a>	
												</section>
												<section style="margin-left:10%;">
													<a href="?url=pesquisa&cod='.$dados_pesq['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
													<a href="?url=passo-a-passo-dados-usuario&cod='.$dados_pesq['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>													 
													<section class = "btn-group">
														<button id = "Resultado'.$dados_pesq['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
														<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
														<ul id = "acoes" class="dropdown-menu">
															<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$dados_pesq['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
															<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$dados_pesq['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
															<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$dados_pesq['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
														</ul>
													</section>
												</section>
											</section>
											<section class="col-lg-4">								
												<a href="?url=livro" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($dados_pesq['NomeLivro']).'</h3></a>				  
												<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($dados_pesq['NomeAutor']).' </h4></a>
												<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($dados_pesq['NomeEditora']).' </h5></a>
											</section>
										</section><BR>';
								if(($ct == 2) OR ($ct == 4) OR ($ct == 6))
								{
									echo '</section>';
								}
							}
						}
						else 
						{
							echo 'Nenhum resultado foi encontrado';
						}
									
				?>
			<br>
                      <ul class="pager">
                        <li class="previous disabled"><a href="#">← Antigo</a></li>
                        <li class="next"><a href="#">Nova →</a></li>
                      </ul>
		</section>
	</section>
</section>