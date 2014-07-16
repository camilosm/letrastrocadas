<?php
	
	if((isset($_GET['lista'])) && (isset($_GET['acao'])))
	{
		$aspas = "'";
		if($_GET['acao'] == "Novo")
		{
			session_start();

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
						<tr id = "desejados_linha">
							<td> 
								<form>
									<section class="panel panel-body">
										<section class = "col-lg-4">	  
											<section class = "bs-component" style = "height: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
												</a>	
											</section>
											<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
												<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
												<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
											</section>
										</section>
									</section> 
									
									<section style="margin-left:10%;">
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
								</form>	
							</td>
						</tr>';	
			}
		
			$lista_desejo = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1], 'novo'=> $resto, 'primeiro' => $id_ultima[0]);
			
			echo json_encode($lista_desejo);
		}
		if($_GET['acao'] == "Antigo")
		{
			session_start();

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
					<tr id = "desejados_linha">
							<td> 
								<form>
									<section class="panel panel-body">
										<section class = "col-lg-4">	  
											<section class = "bs-component" style = "height: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
												</a>	
											</section>
											<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
												<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
												<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
											</section>
										</section>
									</section> 
									
									<section style="margin-left:10%;">
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
								</form>	
							</td>
						</tr>';	
			}

			$lista_desejo = array('tabela'=> $return,'ultimo_id'=> $id_ultima,'primeiro' => $id_antigo);
			echo json_encode($lista_desejo);
		}
	}
?>