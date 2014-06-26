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
			
			$desejo = $_GET['desejo'];
			$ultimos = $_GET['ultimos'];
			
			if(empty($desejo))
			{
				$desejo = "0";
			}
			
			if(empty($ultimos))
			{
				$ultimos = 0;
			}
			
			$editar_destaque = new EditarCaracteres($destaque);
			$destaque = $editar_destaque->sanitizeString($destaque);
			
			$editar_ultimos = new EditarCaracteres($ultimos);
			$ultimos = $editar_ultimos->sanitizeString($ultimos);
			
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros > ".$ultimos." AND tbl_lista_livros.status = 1 ORDER BY data_cadastro DESC LIMIT 6";
			$pesquisar_ultimos = new Pesquisar($tabelas,$campos,$condição);
			$resultado_ultimos = $pesquisar_ultimos->pesquisar();
			
			//Pesquisa a quantidade de livros no banco de dados
			$pesquisar_quantidade_ultimos = new Pesquisar("tbl_lista_livros ","COUNT(id_lista_livros) As Quantidade","1=1");
			$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
			$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_ultimos = $array_quantidade_destaque['Quantidade'];
			
			//Pesquisa a quantidade restabte de livros no banco de dados
			$pesquisar_quantidade_ultimos_resto = new Pesquisar("tbl_lista_livros ","COUNT(id_lista_livros) As Quantidade",$condição);
			$resultado_quantidade_ultimos_resto = $pesquisar_quantidade_ultimos_resto->pesquisar();			
			$array_quantidade_ultimos_resto = mysql_fetch_assoc($resultado_quantidade_ultimos_resto);
			$quantidade_ultimos_resto = $array_quantidade_ultimos_resto['Quantidade'];
			
			//Pesquisa da lista de desejo do site
			$campos_lista = "livros_desejo.id_lista_desejo As id_lista,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
			$tabelas_lista = "tbl_lista_desejo livros_desejo INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
			$condição_lista = "id_lista_desejo > ".$desejo." AND usuario_id = ".$_SESSION['id']." LIMIT 6";
			$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
			
			//Pesquisa a quantidade de livros da lista de desejo que ainda restam no banco de dados/
			$pesquisar_quantidade_resto = new Pesquisar("tbl_lista_desejo ","COUNT(id_lista_desejo) As Quantidade",$condição_lista);
			$resultado_quantidade_resto = $pesquisar_quantidade_resto->pesquisar();			
			$array_quantidade_resto = mysql_fetch_assoc($resultado_quantidade_resto);
			$quantidade_resto = $array_quantidade_resto['Quantidade'];
			
			//Pesquisa a quantidade de livros na lista de desejo no banco de dados/
			$pesquisar_quantidade_lista_desejo = new Pesquisar("tbl_lista_desejo ","COUNT(id_lista_desejo) As Quantidade","1=1");
			$resultado_quantidade_lista_desejo = $pesquisar_quantidade_lista_desejo->pesquisar();			
			$array_quantidade_lista_desejo = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_lista_desejo = $array_quantidade_lista_desejo['Quantidade'];
			
	}
	else
	{	
		//Emite um alerta (não tá funcioando ¬¬) pois eles não tem acesso a essa página
		echo "
			<script type='text/javascript'>
				confirm('Você não tem permissão para acessar essa página');
			</script>";
		
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
<!DOCTYPE HTML>
 <html lang="pt-br">
	<head>

	<head>
		<style>
			body { padding-top: 70px; }
		</style>
	</head>
	
	<header>
		
		<?php @include("views/base/header_usuario.php") ?>
	
	</header>
	
	<body>
	
		<article style="width: 70%; margin-left: 4%;">

			<section class="panel panel-default" style="float: left; width:49%;">
				<section class="panel-heading"><h4>Livros que você deseja:</h4></section>
				<section class="panel-body">
					<table id = "pag_inicial_livros_desejados" border = 0px >
						<?php
							$id= array();
							while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
							{
								$id[] = $lista_desejo['id_lista'];
								
								$quantidade_pagina_lista++;
								echo'
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
															<a href="?url=livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
															<a href="?url=livros_autores"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
															<a href="?url=livros_editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
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
															<li name = "Desmarcar" id = "'.$lista_desejo['id_livro'].'" ><a>Desmarcar</a></li>
															<li name = "JaLi" id = "'.$lista_desejo['id_livro'].'" ><a>Já li</a></li>
															<li name = "Lendo" id = "'.$lista_desejo['id_livro'].'" ><a>Estou lendo</a></li>
														</ul>
													</section>
												</section>
											</form>	
										</td>
									</tr>';	
							}
							if($quantidade_lista_desejo < 6)
							{
								if($quantidade_pagina_lista < 6)
								{
									echo '
										<section class="alert alert-dismissable alert-info">
											<button type="button" class="close" data-dismiss="alert">×</button>
											Você tem poucos livro em sua lista de desejo, adicione mais pesquisando livros e marcando a opção Quero Ler nas opções de "Eu"
										</section>';
								}
							}
							
						?>
				   
					</table>
						<br>
					<ul class="pager">
						<li class="previous disabled"><a href="">← Antigo</a></li>
						<li <?php
								if($quantidade_resto > 7)
								{
									echo 'class="next"';
								}
								else
								{
									echo 'class="next disabled"';
								}
								?>><a <?php if($quantidade_resto > 7){echo 'href="?url=index_usuario&desejo='.$id[$quantidade_pagina_lista - 1];}?>>Nova →</a></li>
					</ul>
				</section>
			</section>

			<section class="panel panel-default" style="float: right; width:49%;">
				<section class="panel-heading"><h4>Últimos livros disponibilizados:</h4></section>
				<section class="panel-body">
					<table id = "pag_inicial_livros_destaques" border = 0px>
						<?php
							
								while($ultimos=mysql_fetch_assoc($resultado_ultimos))
								{
									$quantidade_pagina++;
									echo'
									<tr id = "desejados_linha">
										<td> 
											<form>
												<section class="panel panel-body">
													<section class = "col-lg-4">	  
														<section class = "bs-component" style = "height: 177px; width:120px;"> 
															<a href="?url=livro "class = "thumbnail">
																<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
															</a>	
														</section>
														<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
															<a href="?url=livro"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
															<a href="?url=livros_autores"> <h4>'.utf8_encode($ultimos['Autor']).' </h4></a>
															<a href="?url=livros_editora"> <h5>'.utf8_encode($ultimos['Editora']).' </h5></a>
															<a href="#"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
														</section>
													</section>
												</section> 
												
												<section style="margin-left:10%;">
													<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" name = "'.$ultimos['id_lista_livros'].'" value = "'.$ultimos['id_usuario'].'"/>Solicitar Livro</button>
													<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
													<section class = "btn-group">
														<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Eu...</button>
														<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
														<ul id = "acoes" class="dropdown-menu">
															<li name = "QueroLer" id = "'.$ultimos['id_livro'].'" ><a>Quero Ler<a></li>
															<li name = "JaLi" id = "'.$ultimos['id_livro'].'" ><a>Já li</a></li>
															<li name = "Lendo" id = "'.$ultimos['id_livro'].'" ><a>Estou lendo</a></li>
														</ul>
													</section>
													<a href="?url=pesquisa&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Veja +"/></a>
												</section>
											</form>	
										</td>
									</tr>';
								}
								if($quantidade_destaque < 18)
								{
									if($quantidade_pagina < 6)
									{
										echo '
											<section class="alert alert-dismissable alert-info">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>Nos ajude!</strong> Ainda temos poucos livros em nosso site, disponibilize um <a href="?url=passo-a-passo-pesquisa" class="alert-link">aqui</a> em um simples passo a passo.
											</section>';
									}
								}
							
						?>
				   
					</table>
					
					<br>
					
					<ul class="pager">
						<li class = "previous disabled"><a>← Antigo</a></li>
						<li <?php
								if($quantidade_ultimos_resto > 7)
								{
									echo 'class="next"';
								}
								else
								{
									echo 'class="next disabled"';
								}
								?>
						><a <?php if($quantidade_ultimos_resto > 7){echo 'href="?url=index_usuario&ultimo='.$id[$quantidade_pagina - 1];}?>>Nova →</a></li>
					</ul>
				</section>
			</section>
			
			<section class="modal" id="myModal">
			  <section class="modal-dialog">
				<section class="modal-content">
				  <section class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Solicitação de livro</h4>
				  </section>
				  <section class="modal-body">
					<p id = "TextDialog">Você deseja solicitar este livro?</p>
				  </section>
				  <section class="modal-footer">
					<button id = "cancelar" type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					<button name = "BotaoConfirmar" id = "confirmar_solicitação" type="button" class="btn btn-primary">Sim</button>
				  </section>
				</section>
			  </section>
			</section>
	   
		</article>
		
		<aside style = "width:20%; height: auto; position: fixed; left: 76%; margin-top:0%">
			<section class="panel panel-default">
				<section class="panel-heading">Notificações</section>
				<section class="panel-body">
					<nav>
						<ul class="nav navbar-nav" style="width: 100%;">
							<a><li class="list-group-item"> Moedas<span class="badge">0</span></li></a>
							<a href = "?url=solicitacoes"><li class="list-group-item"> Trocas aceitas  <span class="badge">0</span></li></a>
							<a href = "?url=solicitacoes"><li class="list-group-item"> Solicitações recebidas<span class="badge">0</span></li></a>
							<a href = "?url=solicitacoes"><li class="list-group-item"> Livro chegou  <span class="badge">0</span></li></a>
						</ul>
					</nav>
				</section>
			</section>
		</aside>
		
	</body>
</html>