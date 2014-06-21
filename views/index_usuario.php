<!DOCTYPE HTML>
 <html lang="pt-br">
	<head>

	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>Teste com bootstrap</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap.min.css"/>
		<!-- Include all compiled plugins (below), or include insectionidual files as needed -->
		<script src="../scripts/jquery.min.js"></script>
		<script src="../scripts/bootstrap.min.js"></script>
		<style>
			body { padding-top: 70px; }
		</style>
	</head>
	
	<header>
		
		<?php session_start(); @include("views/base/header_usuario.php") ?>
	
	</header>
	
	<body>
	
		<article style="width: 70%; margin-left: 4%;">

			<section class="panel panel-default" style="float: left; width:49%;">
				<section class="panel-heading"><h4>Livros que você deseja:</h4></section>
				<section class="panel-body">
					<table id = "pag_inicial_livros_desejados" border = 0px >
						<tr id = "desejados_linha1">
							<td> 
								<form method="post" action = "?url=cadastra_livro_usuario">
									<section class="panel panel-body">
										<section class = "col-lg-4">	  
											<section class = "bs-component" style = "height: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
												</a>	
											</section>
											<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro"> <h3> <?php echo "Morro Dos Ventos Uivantes"; ?></h3> </a>				  
												<a href="?url=livros_autores"> <h4> <?php echo "Emily Brontë" ?> </h4></a>
												<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
											</section>
										</section>
									</section> 
									
									<section style="margin-left:10%;">
										<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" />
										<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
										<section class = "btn-group">
											<button type="button" class="btn btn-primary btn-sm">Eu...</button>
											<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li>Quero ler</li>
												<li>Já li</li>
												<li>Estou lendo</li>
											</ul>	
										</section>
									</section>
								</form>	
							</td>
						</tr>
						
						<tr id = "desejados_linha2">
							<td id = "coluna2_da_linha1_desejados"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>			  
												<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
												<a href="?url=livros_editora"> <h5> <?php echo 'Lua de Papel' ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>  
							</td>
						</tr>
						
						<tr id = "desejados_linha3">
							<td id = "coluna1_da_linha2_desejados"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
												</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
												<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
												<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
							</td>
						</tr>
						
						<tr id = "desejados_linha4">
							<td id = "coluna2_da_linha2_desejados"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
												</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
												<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
												<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro"  />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro"  />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
						   </td>
						</tr>
					   
						<tr id = "desejados_linha5">
							<td id = "coluna1_da_linha2_desejados"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
											<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
											<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
											<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
							</td>
						</tr>
						
						<tr id = "desejados_linha6">
							<td id = "coluna2_da_linha2_desejados"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
											<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
											<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
											<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro"  />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>				  
							</td>
						</tr>
					   
						<!-- to pensando aqui, será que colocamos um botão de proximo e anterior aqui?
						não sei exatamente como isso funcionaria, porque aumentaria os resultados de select
						do banco e como não mudaríamos de página ao botão ser clicado pode ser que isso pese... Não sei 
						como funcionaria -->
				   
					</table>
				
						<br>
				
					<ul class="pager">
						<li class="previous disabled"><a>← Antigo</a></li>
						<li class="next"><a>Nova →</a></li>
					</ul>
				</section>
			</section>

			<section class="panel panel-default" style="float: right; width:49%;">
				<section class="panel-heading"><h4>Destaques:</h4></section>
				<section class="panel-body">
					<table id = "pag_inicial_livros_destaques" border = 0px>
						<tr id = "destaques_linha1">
							<td id = "coluna1_da_linha1_destaques">
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
											<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
											<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
											<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro"  />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro"  />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
					   
							</td>
						</tr>
						   
						<tr id = "destaques_linha2">
							<td id = "coluna2_da_linha1_destaques"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
												</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
												<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
												<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>		  
							</td>
						</tr>
						
						<tr id = "destaques_linha3">
							<td id = "coluna1_da_linha2_destaques"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
											<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
											<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
											<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
							</td>
						</tr>
							   
						<tr id = "destaques_linha4">
							<td id = "coluna2_da_linha2_destaques"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
											<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
											<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
											<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro"  />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro"  />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
							</td>
						</tr>
					   
						<tr id = "destaques_linha5">
							<td> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
												</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
												<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
												<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
												<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro"  />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro"  />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" >Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
							</td>
						</tr>       
						
						<tr id = "destaques_linha6">
							<td id = "coluna2_da_linha2_destaques"> 
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt = "cidade"/> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
											<a href="?url=livro"> <h3> <?php echo 'Morro dos ventos Uivantes'?> </h3> </a>				  
											<a href="?url=livros_autores"> <h4> <?php echo 'Emily Brontë' ?> </h4></a>
											<a href="?url=livros_editora"> <h5> <?php echo "Lua de Papel" ?> </h5></a>
										</section>
									</section>
								</section> 
								<section style="margin-left:10%;">
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro"  />
									<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro"  />															 
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm">Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
							</td>
					   </tr>
				   
					</table>
					
					<br>
					
					<ul class="pager">
						<li class="previous disabled"><a>← Antigo</a></li>
						<li class="next"><a>Nova →</a></li>
					</ul>
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