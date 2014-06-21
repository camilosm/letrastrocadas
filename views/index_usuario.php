<script type="text/javascript">

/**
 * Função para criar um objeto XMLHTTPRequest
*/
function CriaRequest(){ 
	try
	{
		request = new XMLHttpRequest();
	}
	catch (IEAtual)
	{
		try
		{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(IEAntigo)
		{
			try
			{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(falha)
			{
				request = false;
			}
		}
	} 
	if (!request)
		alert("Seu Navegador não suporta Ajax!");
	else
		return request;
}
/**
 * Função para enviar os dados
*/
function getDadosQueroLer(){ // Declaração de Variáveis
	alert("Oi");
	var xmlreq = CriaRequest();
	// Exibi a imagem de progresso
	// Iniciar uma requisição
	xmlreq.open("GET", "algumacoisa.php?acao=queroler&usuario=<?php echo $_SESSION['id'];?>", true);
	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function(){
		// Verifica se foi concluído com sucesso e a conexão fechada
		(readyState=4) 
		if (xmlreq.readyState == 4)
		{ // Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200)
			{
				result.innerHTML = xmlreq.responseText;
			}
			else
			{ 
				result.innerHTML = "Erro: " + xmlreq.statusText;
			}
		} 
	};
	xmlreq.send(null); 
}

</script>
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
			$campos = "id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros > ".$ultimos." ORDER BY data_cadastro DESC LIMIT 6";
			$pesquisar_ultimos = new Pesquisar($tabelas,$campos,$condição);
			$resultado_ultimos = $pesquisar_ultimos->pesquisar();
			
			//Pesquisa a quantidade livros no banco de dados
			$pesquisar_quantidade_ultimos = new Pesquisar("tbl_lista_livros ","COUNT(id_lista_livros) As Quantidade","1=1");
			$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
			$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_ultimos = $array_quantidade_destaque['Quantidade'];
			
			//Pesquisa da lista de desejo do site
			$campos_lista = "livros_desejo.id_lista_desejo As id_lista,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
			$tabelas_lista = "tbl_lista_desejo livros_desejo INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
			$condição_lista = "id_lista_desejo > ".$desejo." AND usuario_id = ".$_SESSION['id']." LIMIT 6";
			$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
			
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
				alert('Você não tem permissão para acessar essa página');
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
													<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" disabled />
													<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
													<section class = "btn-group">
														<button type="button" class="btn btn-primary btn-sm">Eu...</button>
														<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
														<ul class="dropdown-menu">
															<li><a onclick="getDadosQueroLer();">Quero ler</a></li>
															<li><a href="">Já li</a></li>
															<li><a href="">Estou lendo</a></li>
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
						<a href="?url=index_usuario&desejo=<?php echo $id[$quantidade_pagina_lista - 1]?>"><li class="next">Nova →</li></a>
					</ul>
				</section>
			</section>

			<section class="panel panel-default" style="float: right; width:49%;">
				<section class="panel-heading"><h4>Últimos livros disponibilizados:</h4></section>
				<section class="panel-body">
					<table id = "pag_inicial_livros_destaques" border = 0px>
						<?php
							
								while($destaques=mysql_fetch_assoc($resultado_ultimos))
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
																<img src = "'.$destaques['imagem_livros'].'" alt = "'.utf8_encode($destaques['Livro']).'" /> 
															</a>	
														</section>
														<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
															<a href="?url=livro"> <h3> '.utf8_encode($destaques['Livro']).'</h3></a>				  
															<a href="?url=livros_autores"> <h4>'.utf8_encode($destaques['Autor']).' </h4></a>
															<a href="?url=livros_editora"> <h5>'.utf8_encode($destaques['Editora']).' </h5></a>
															<a href="#"> <h4>'.utf8_encode($destaques['usuario']).' </h4></a>
														</section>
													</section>
												</section> 
												
												<section style="margin-left:10%;">
													<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro" disabled />
													<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />															 
													<section class = "btn-group">
														<button type="button" class="btn btn-primary btn-sm" disabled>Eu...</button>
														<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" disabled><span class="caret"></span></button>
														<ul class="dropdown-menu">
															<li>Quero ler</li>
															<li>Já li</li>
															<li>Estou lendo</li>
														</ul>	
													</section>
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