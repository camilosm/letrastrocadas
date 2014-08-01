<script type="text/javascript" src="ajax/ajax.js"></script>

<?php
	
	//Inicia a sessão
	session_start();
	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{ 

			include("classes/class_banco.php");
			include("class_editar_caracteres.php");
			include("classes/class_pesquisar.php");
			
			$bd = new Banco();			
			
			$pesquisa_generos_ruins = new Pesquisar("tbl_generos_desapreciados","genero_id","usuario_id = ".$_SESSION['id']);
			$resultado = $pesquisa_generos_ruins->pesquisar();
			
			$pesquisa_generos_ruins_quantidade = new Pesquisar("tbl_generos_desapreciados","COUNT(genero_id)As quantidade","usuario_id = ".$_SESSION['id']);
			$resultado_quantidade = $pesquisa_generos_ruins_quantidade->pesquisar();
			$array = mysql_fetch_assoc($resultado_quantidade);
			$qt_genero = $array['quantidade'];
			
			$string_condicao_genero = "";
			$contador_genero = 0;
			while($generos_ruins=mysql_fetch_assoc($resultado))
			{	
				$contador_genero++;
				if(($qt_genero != 1) AND ($qt_genero == $contador_genero))
				{
					$string_condicao_genero.= "categoria_id <> ".$generos_ruins['genero_id'];
				}
				else if($qt_genero == 1)
				{
					$string_condicao_genero.= "categoria_id <> ".$generos_ruins['genero_id'];
				}
				else
				{
					$string_condicao_genero.= "categoria_id <> ".$generos_ruins['genero_id']." AND ";
				}
		
			}
			if($contador_genero == 0)
			{
				$string_condicao_genero = "1=1";
			}
			
			
			$pesquisa_autores_ruins = new Pesquisar("tbl_autores_desapreciados","autor_id","usuario_id = ".$_SESSION['id']);
			$resultado_autores = $pesquisa_autores_ruins->pesquisar();
			
			$pesquisa_autores_ruins_quantidade = new Pesquisar("tbl_autores_desapreciados","COUNT(autor_id)As quantidade","usuario_id = ".$_SESSION['id']);
			$resultado_quantidade = $pesquisa_autores_ruins_quantidade->pesquisar();
			$array_autor = mysql_fetch_assoc($resultado_quantidade);
			$qt_autor = $array_autor['quantidade'];
			
			$string_condicao_autor = "";
			$contador_autor = 0;
			while($autores_ruins=mysql_fetch_assoc($resultado_autores))
			{	
				$contador_autor++;
				if(($qt_autor != 1) AND ($qt_autor == $contador_autor))
				{
					$string_condicao_autor.= "autor_id <> ".$autores_ruins['autor_id'];
				}
				else if($qt_autor == 1)
				{
					$string_condicao_autor.= "autor_id <> ".$autores_ruins['autor_id'];
				}
				else
				{
					$string_condicao_autor.= "autor_id <> ".$autores_ruins['autor_id']." AND ";
				}
		
			}
			if($contador_autor == 0)
			{
				$string_condicao_autor = "1=1";
			}
			
			
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "DISTINCT id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "tbl_lista_livros.status = 1 AND $string_condicao_genero AND $string_condicao_autor ORDER BY data_cadastro DESC LIMIT 6";
			$pesquisar_ultimos = new Pesquisar($tabelas,$campos,$condição);
			$resultado_ultimos = $pesquisar_ultimos->pesquisar();
			
			//Pesquisa a quantidade de livros no banco de dados
			$pesquisar_quantidade_ultimos = new Pesquisar("tbl_lista_livros INNER JOIN tbl_livro ON id_livro = livro_id ","COUNT(id_lista_livros) As Quantidade","tbl_lista_livros.status = 1  AND $string_condicao_genero AND $string_condicao_autor");
			$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
			$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_ultimos = $array_quantidade_ultimos['Quantidade'];
						
			//Pesquisa da lista de desejo do site
			$campos_lista = "marcacao.id_marcacao As id_lista,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
			$tabelas_lista = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
			$condição_lista = "usuario_id = ".$_SESSION['id']." AND tipo = 1 ORDER BY marcacao.id_marcacao LIMIT 6";
			
			$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
			
			//Pesquisa a quantidade de livros na lista de desejo no banco de dados
			$pesquisar_quantidade_lista_desejo = new Pesquisar("tbl_marcacao ","COUNT(id_marcacao) As Quantidade","tipo = 1 AND usuario_id = ".$_SESSION['id']);
			$resultado_quantidade_lista_desejo = $pesquisar_quantidade_lista_desejo->pesquisar();			
			$array_quantidade_lista_desejo = mysql_fetch_assoc($resultado_quantidade_lista_desejo);
			$quantidade_lista_desejo = $array_quantidade_lista_desejo['Quantidade'];		
			
			//Só pra uma futura concatenação
			$aspas = "'";
			
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
<article style="width: 84%; margin-left: 8%;">

	<section class="row">
		<section class="col-md-6">
			<section class="panel panel-default">
				<section class="panel-heading"><h4>Livros que você deseja:</h4></section>
				<section class="panel-body" id="pag_inicial_livros_desejados">
						<?php
							
							$id_ultima = array();
							while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
							{
								$id_ultima[] = $lista_desejo['id_lista'];
								echo'	<section class="panel panel-default">
											<section class="panel panel-body">
												<section class="row">
													<section class = "col-md-5">	  
														<center>
															<section class = "bs-component" style = "maxheight: 177px; width:120px;">
																<a href="?url=livro" class = "thumbnail">
																	<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
																</a>	
															</section>
														</center>
													</section>
													<section class="col-md-7">
														<a href="?url=livro" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
														<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
														<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
													</section>
												</section>
											
												<section class="row">
													<center>
														<section>
															<a href="?url=pesquisa&cod='.$lista_desejo['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
															<a href="?url=passo-a-passo-dados-usuario&cod='.$lista_desejo['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>													 
															<section class = "btn-group">
																<button id = "Resultado'.$lista_desejo['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
																<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
																<ul id = "acoes" class="dropdown-menu">
																	<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$lista_desejo['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
																	<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$lista_desejo['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
																	<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$lista_desejo['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
																</ul>
															</section>
														</section>
													</center>
												</section>
											</section>
										</section>';
							}
						?>
						<br>
					
				</section>
				<ul class="pager">
						<li id = "li_antigo" class="previous disabled"><a id = "a_antigo" onClick = "" >← Antigo</a></li>
						<li id = "li_novo" class="<?php echo ($quantidade_lista_desejo >= 7) ? "next" : "next disabled"; ?>"><a id = "a_novo" onClick="NovaListaDesejo('<?php echo ($quantidade_lista_desejo >= 7) ? "$id_ultima[5]','$id_ultima[0]','1" : "None','None','1";?>');">Nova →</a></li>
					</ul>
			</section>
		</section>

		<section class="col-md-6">
			<section class="panel panel-default">
				<section class="panel-heading"><h4>Últimos livros disponibilizados:</h4></section>
				<section class="panel-body" id="pag_inicial_livros_ultimos_disponibilizados">
						<?php
								if($quantidade_ultimos < 50)
								{	
										echo '
											<section class="alert alert-dismissable alert-info">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>Nos ajude!</strong> Ainda temos poucos livros em nosso site, disponibilize um <a href="?url=passo-a-passo-pesquisa" class="alert-link">aqui</a> em um simples passo a passo.
											</section>';
								}
								$quantidade_pagina = 0;
								$id_ultima_ultimos = array();
								while($ultimos=mysql_fetch_assoc($resultado_ultimos))
								{
									$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$ultimos['id_livro']." AND usuario_id=".$_SESSION['id']);
									$resultado_marcacao = $pesquisar_marcacões->pesquisar();
									$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
									
									if($array_marcacao['tipo'] == 1)
									{
										$botões = ' 
													<button id = "Resultado'.$ultimos['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
													<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
													<ul id = "acoes" class="dropdown-menu">
														<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
														<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
														<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
													</ul>';
									}
									else if($array_marcacao['tipo'] == 2)
									{
										$botões = ' 
												<button id = "Resultado'.$ultimos['id_livro'].'" value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-sm">Já Li</button>
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
												</ul>';
									}
									else if($array_marcacao['tipo'] == 3)
									{
										$botões = ' 
												<button id = "Resultado'.$ultimos['id_livro'].'" value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Já Li</button>
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Estou lendo</a></li>
												</ul>';
									}
									else
									{
										$botões = '
													<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
													<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
													<ul id = "acoes" class="dropdown-menu">
														<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
														<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
														<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
													</ul>';
									}
									$quantidade_pagina++;
									$id_ultima_ultimos[] = $ultimos['id_lista_livros'];
									echo'
											<form>
												<section class="panel panel-default">
													<section class="panel panel-body">  
														<section class="row">
															<section class="col-md-5">
																<center>
																	<section class = "bs-component" style = "maxheight: 177px; width:120px;"> 
																		<a href="?url=livro "class = "thumbnail">
																			<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
																		</a>	
																	</section>
																</center>
															</section>
															<section class="col-md-7">								
																<a href="?url=livro"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
																<a href="?url=livros_autores"> <h4>'.utf8_encode($ultimos['Autor']).' </h4></a>
																<a href="?url=livros_editora"> <h5>'.utf8_encode($ultimos['Editora']).' </h5></a>
																<a href="?url=perfil_usuario&cod='.$ultimos['id_usuario'].'"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
															</section>
														</section>
														<section class="row">
															<center>
																<section>
																	<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" onClick="SolicitarLivro('.$aspas.''.$ultimos["id_lista_livros"].''.$aspas.','.$aspas.''.$ultimos['id_usuario'].''.$aspas.')">Solicitar Livro</button>
																	<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
																	<section class = "btn-group">
																		'.$botões.'
																	</section>
																	<a href="?url=pesquisa&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_solicitar_livro" value = "Veja +"/></a>
																</section>
															</center>
														</section>
													</section>
												</section>
											</form>';
								}
						?>
					</section>
					<ul class="pager">
						<li id = "li_ultimos_antigo" class="previous disabled"><a id = "a_ultimos_antigo" onClick = "" >← Antigo</a></li>
						<li id = "li_ultimos_novo" class="<?php echo ($quantidade_ultimos >= 7) ? "next" : "next disabled"; ?>"><a id = "a_ultimos_novo" onClick="NovaDisponibilizados('<?php echo ($quantidade_ultimos >= 7) ? "$id_ultima_ultimos[5]','$id_ultima_ultimos[0]','1" : "None','None','1";?>');">Nova →</a></li>
					</ul>
				
			</section>
		</section>
	</section>

</article>

<section class="modal" id="myModal">
</section>