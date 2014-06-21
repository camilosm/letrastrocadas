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
			<a class="navbar-brand">Bem vindo, <?php session_start(); echo utf8_encode($_SESSION['email']); ?>!</a>
		</section>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<section class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="#">Início</a></li>
			</ul>
			<form class="navbar-form navbar-left" role="search">
				<section class="form-group">
					<input type="text" class="form-control" placeholder="Procurar">
				</section>
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</form>
			
			<ul class="nav navbar-nav navbar-right">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastrar/Alterar <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?url=cadastra_livro_adm">Livro</a></li>
								<li><a href="?url=cadastrar_editora">Editora</a></li>
								<li><a href="?url=cadastrar_autor">Autor</a></li>
								<li><a href="?url=cadastra_genero">Gênero</a></li>
							</ul>
					</li>
				</ul>

				<ul class="nav navbar-nav">
				   <li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configurações<b class="caret"></b></a>
						  <ul class="dropdown-menu">
							  <li><a href="?url=alterar_dados_admin">Alterar dados</a></li>
							  <li><a href="?url=alterar_senha_admin">Alterar senha</a></li>
						  </ul>
				   </li>
			  
					<li><a href="?url=cadastro_adm">Adicionar administrador</a></li>
					<li><a href="?url=logout&situacao=logado">Sair</a></li>
				</ul>
			</ul>
		</section><!-- /.navbar-collapse -->
	</section><!-- /.container-fluid -->
</nav>