<?php

		if(isset($_GET['btnPesquisa']))
		{
			$conteudo_text = $_GET['conteudo_text'];
		}

?>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<section class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<section class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand">Bem vindo, <?php
			session_start(); 
			if(empty($_SESSION['nome']))
			{
				echo utf8_encode($_SESSION['email']);
			}
			else
			{
				echo utf8_encode($_SESSION['nome']);
			}
			?>!</a>
			
		</section>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<section class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<form class="navbar-form navbar-left" role="search" method= "get" action = "?url=pesquisa">
				<section class="form-group">
					<input type="text" class="form-control" placeholder="Procurar" name = "conteudo_text">
				
				<button type="submit" class="btn btn-default" name = "btnPesquisa" href = "?url=pesquisa">
					<span class="glyphicon glyphicon-search"></span>
				</button>
				</section>
			</form>

			<ul class="nav navbar-nav navbar-right">
				<ul class="nav navbar-nav">
				<li><a href="?url=index_usuario"><span class="glyphicon glyphicon-home"></span>&nbsp Home</a></li>
				<li><a href="?url=perfil_usuario"><span class="glyphicon glyphicon-user"></span>&nbsp Perfil</a></li>
				   <li class="dropdown"> 
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span>&nbsp Meus livros<b class="caret"></b></a>
						  <ul class="dropdown-menu">
							  <li><a href="?url=livros_lidos">Lidos</a></li>
							  <li><a href="?url=livros_disponibilizados">Disponibilizados</a></li>
							  <li><a href="?url=livros_em_leitura">Lendo</a></li>
							  <li><a href="?url=livros_quero_ler">Quer Ler</a></li>
							  <li><a href="?url=passo-a-passo-pesquisa">Cadastrar novo livro</a></li>
						  </ul>
				   </li>
				</ul>

				<ul class="nav navbar-nav">
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>&nbsp Conta<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="?url=alterar_dados_perfil">Alterar dados</a></li>
						<li><a href="?url=alterar_senha_usuario">Alterar senha</a></li>
						<li><a href="?url=alterar_senha_usuario">Desativar conta</a></li>
					</ul>
				   </li>
						<li><a href="?url=logout&situacao=logado"><span class="glyphicon glyphicon-log-out"></span>&nbsp Sair</a></li>
				</ul>
			</ul>			
				</section><!-- /.navbar-collapse -->
	</section><!-- /.container-fluid -->
</nav>