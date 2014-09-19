<?php
	session_start();
	if((isset($_GET['lista'])) && (isset($_GET['acao'])))
	{
		$aspas = "'";
		if($_GET['acao'] == "Novo")
		{
			include("../views/classes/class_banco.php");
			include("../views/class_editar_caracteres.php");
			include("../views/classes/class_pesquisar.php");
			
			$bd = new Banco();
			
			$id = $_GET['lista'];
			
			//Pesquisa da lista de desejo do site
			$campos_lista = "marcacao.id_marcacao As id_lista,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
			$tabelas_lista = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
			$condição_lista = "id_marcacao > ".$id." AND usuario_id = ".$_SESSION['id']." AND tipo = 1 ORDER BY id_marcacao LIMIT 6";
			
			$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
			
			//Pesquisa a quantidade de livros na lista de desejo no banco de dados
			$pesquisar_quantidade_lista_desejo = new Pesquisar("tbl_marcacao ","COUNT(id_marcacao) As Quantidade","id_marcacao > ".$id." AND tipo = 1 AND usuario_id = ".$_SESSION['id']);
			$resultado_quantidade_lista_desejo = $pesquisar_quantidade_lista_desejo->pesquisar();			
			$array_quantidade_lista_desejo = mysql_fetch_assoc($resultado_quantidade_lista_desejo);
			$quantidade_lista_desejo = $array_quantidade_lista_desejo['Quantidade'];

			if($quantidade_lista_desejo >= 7)
			{
				$resto = "Sim";
			}
			else
			{
				$resto = "Não";
			}
			
			$return = "";
			$ct=0;
			$id_ultima = array();
			while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
			{
				$ct++;
				$id_ultima[] = $lista_desejo['id_lista'];
				$return.= '
						<section class="panel panel-default">
											<section class="panel panel-body">
												<section class="row">
													<section class = "col-md-4">	  
														<center>
															<section class = "bs-component" style = "maxheight: 177px; width:120px;">
																<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" class = "thumbnail">
																	<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
																</a>	
															</section>
														</center>
													</section>
													<section class="col-md-6">
														<center>
															<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
															<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
															<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
														</center>
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
			//Se não tiver resposta para mostrar, faz uma pesquisa para dar sujestões ao usuário
			if($ct_desejo < 6)
			{			
				$limite = 6 - $ct_desejo;
				
				// Pesquisando o filtro de gêneros favoritos para a pesquisa de últimos disponibilizados 
				$pesquisa_generos_favoritos = new Pesquisar("tbl_generos_favoritos","categoria_id","usuario_id = ".$_SESSION['id']);
				$resultado_generos_favoritos = $pesquisa_generos_favoritos->pesquisar();
				
				// Quantidade de gêneros marcados pelo usuário como seus favoritos.
				$pesquisa_generos_favoritos_qt = new Pesquisar("tbl_generos_favoritos","COUNT(categoria_id)As quantidade","usuario_id = ".$_SESSION['id']);
				$resultado_quantidade_favoritos = $pesquisa_generos_favoritos_qt->pesquisar();
				$array_generos_favoritos = mysql_fetch_assoc($resultado_quantidade_favoritos);
				$qt_genero_favoritos = $array_generos_favoritos['quantidade'];

				// Fazendo a condição da pesquisa 
				$string_condicao_genero_favoritos = "";
				$contador_genero_favoritos = 0;
				while($generos_favoritos=mysql_fetch_assoc($resultado_generos_favoritos))
				{	
					$contador_genero_favoritos++;
					if(($qt_genero_favoritos != 1) AND ($qt_genero_favoritos == $contador_genero_favoritos))
					{
						$string_condicao_genero_favoritos.= "categoria_id = ".$generos_favoritos['categoria_id'];
					}
					else if($qt_genero_favoritos == 1)
					{
						$string_condicao_genero_favoritos.= "categoria_id = ".$generos_favoritos['categoria_id'];
					}
					else
					{
						$string_condicao_genero_favoritos.= "categoria_id = ".$generos_favoritos['categoria_id']." AND ";
					}

				}

				if($contador_genero_favoritos == 0)
				{
					$string_condicao_genero_favoritos = "1=1";
				}
				
				// Pesquisando o filtro de gêneros favoritos para a pesquisa de últimos disponibilizados 
				$pesquisa_autores_favoritos = new Pesquisar("tbl_autores_favoritos","autor_id","usuario_id = ".$_SESSION['id']);
				$resultado_autores_favoritos = $pesquisa_autores_favoritos->pesquisar();
				
				// Quantidade de gêneros marcados pelo usuário como favoritos.
				$pesquisa_autores_favoritos_quantidade = new Pesquisar("tbl_autores_favoritos","COUNT(autor_id)As quantidade","usuario_id = ".$_SESSION['id']);
				$resultado_quantidade_autores = $pesquisa_autores_favoritos_quantidade->pesquisar();
				$array_qt_autores = mysql_fetch_assoc($resultado_quantidade_autores);
				$qt_autores = $array_qt_autores['quantidade'];
				
				// Fazendo a condição da pesquisa 
				$string_condicao_autores_fvrt = "";
				$contador_autores = 0;
				while($autores_favoritos=mysql_fetch_assoc($resultado_autores_favoritos))
				{	
					$contador_autores++;
					if(($qt_autores != 1) AND ($qt_autores == $contador_autores))
					{
						$string_condicao_autores_fvrt.= "autor_id = ".$autores_favoritos['autor_id'];
					}
					else if($qt_autores == 1)
					{
						$string_condicao_autores_fvrt.= "autor_id = ".$autores_favoritos['autor_id'];
					}
					else
					{
						$string_condicao_autores_fvrt.= "autor_id = ".$autores_favoritos['autor_id']." AND ";
					}
			
				}

				// Utilizando um recurso técnico necessário
				if($contador_autores == 0)
				{
					$string_condicao_autores_fvrt = "1=1";
				}

				// Verifica se tem algum filtro para a pesquisa, se não será exibido uma mensagem para o usuário para que ele cadastre autores ou gênero preferidos para podermos dar sujestões
				if(($string_condicao_autores_fvrt != "1=1") OR ($string_condicao_genero_favoritos != "1=1"))
				{	
					$string_condicao = "";
					if(($string_condicao_autores_fvrt != "1=1") && ($string_condicao_autores_fvrt != ""))
					{
						if($string_condicao_genero_favoritos != "1=1")
						{
							$string_condicao.= ' AND ('.$string_condicao_autores_fvrt.' OR '.$string_condicao_genero_favoritos.')';
						}	
						else
						{
							$string_condicao.= 'AND '.$string_condicao_autores_fvrt;
						}
					}
					else
					{
						if(($string_condicao_genero_favoritos != "1=1") && ($string_condicao_genero_favoritos != ""))
						{
							$string_condicao.= 'AND '.$string_condicao_genero_favoritos;
						}
						else
						{
							$string_condicao = "1=1";
						}
					}
				}
				else
				{
					$string_condicao = "1=1";
				}
				
					
				//Pesquisa da lista de desejo do site
				$campos_lista = "id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
				$tabelas_lista = "tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id";
				$condição_lista = "autor_id NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
				AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].") 
				AND $string_condicao 
				AND id_livro NOT IN (SELECT DISTINCT livro_id FROM tbl_marcacao where usuario_id = ".$_SESSION['id'].")";

				$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
				$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
				
				//Pesquisa a quantidade de livros na lista de desejo no banco de dados
				$pesquisar_quantidade_lista_desejo = new Pesquisar("tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id",
				"COUNT(id_livro) As Quantidade",
				"autor_id NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
				AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].") 
				AND $string_condicao 
				AND id_livro NOT IN (SELECT DISTINCT livro_id FROM tbl_marcacao where usuario_id = ".$_SESSION['id'].")");
				$resultado_quantidade_lista_desejo = $pesquisar_quantidade_lista_desejo->pesquisar();			
				$array_quantidade_lista_desejo = mysql_fetch_assoc($resultado_quantidade_lista_desejo);
				$quantidade_lista_desejo = $array_quantidade_lista_desejo['Quantidade'];	
				
				$id_ultima = array();
				$ct_desejo = 0;

				$return.= '
					<fielset>
					<a href="?url=sugestoes" title="Clique para ver mais sugestões!"><legend>Sugestões do LetrasTrocadas para você!</legend></a>
				';
				while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
				{

					$botões = '
								<button id = "Resultado'.$lista_desejo['id_livro'].'" value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$lista_desejo['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
									<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$lista_desejo['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$lista_desejo['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
								</ul>';
					
					$ct_desejo++;
					$id_ultima[] = $lista_desejo['id_livro'];
					$return.= '	<section class="panel panel-default">
								<section class="panel panel-body">
									<section class="row">
										<section class = "col-md-4">
											<center>
												<section class = "bs-component" style = "max-height: 177px; width:120px;">
													<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" class = "thumbnail">
														<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
													</a>	
												</section>
											</center>
										</section>
										<section class="col-md-6">
											<center>
												<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
												<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
												<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
											</center>
										</section>
									</section>
								
									<section class="row">
										<center>
											<section>
												<a href="?url=pesquisa&nome='.$lista_desejo['Livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
												<a href="?url=passo-a-passo-dados-usuario&cod='.$lista_desejo['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>													 
												<section class = "btn-group">
													'.$botões.'
												</section>
											</section>
										</center>
									</section>
								</section>
							</section>';
				}
			}
		
			$lista_desejo = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1], 'novo'=> $resto, 'primeiro' => $id_ultima[0]);
			
			echo json_encode($lista_desejo);
		}
		if($_GET['acao'] == "Antigo")
		{
			include("../views/classes/class_banco.php");
			include("../views/class_editar_caracteres.php");
			include("../views/classes/class_pesquisar.php");
			
			$bd = new Banco();
			
			$id = $_GET['lista'];
			
			//Pesquisa da lista de desejo do site
			$campos_lista = "marcacao.id_marcacao As id_lista,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
			$tabelas_lista = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
			$condição_lista = "id_marcacao >= ".$id." AND usuario_id = ".$_SESSION['id']." AND tipo = 1 ORDER BY id_marcacao LIMIT 6";
			
			$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
		
			$id_antigo = "";
			//Pesquisa a quantidade de livros na lista de desejo no banco de dados
			$pesquisar_id = new Pesquisar("tbl_marcacao ","id_marcacao","id_marcacao < ".$id." AND tipo = 1 ORDER BY id_marcacao DESC");
			$resultado_id = $pesquisar_id->pesquisar();			
			while($ids=mysql_fetch_assoc($resultado_id))
			{
				$id_antigo = $ids['id_marcacao'];
			}
			
			$return = "";
			while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
			{
				$id_ultima = $lista_desejo['id_lista'];
				
				$return.= '
					<section class="panel panel-default">
											<section class="panel panel-body">
												<section class="row">
													<section class = "col-md-4">	  
														<center>
															<section class = "bs-component" style = "maxheight: 177px; width:120px;">
																<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" class = "thumbnail">
																	<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
																</a>	
															</section>
														</center>
													</section>
													<section class="col-md-6">
														<center>
															<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
															<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
															<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
														</center>
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

			$lista_desejo = array('tabela'=> $return,'ultimo_id'=> $id_ultima,'primeiro' => $id_antigo);
			echo json_encode($lista_desejo);
		}
	}
?>