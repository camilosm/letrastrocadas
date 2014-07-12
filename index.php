<!DOCTYPE HTML>
<html lang="pt-br">
	<head>

		<title>Letras Trocadas</title>
		<link rel="shortcut icon" href="content/ico/icone.ico">
		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css"/>
		<!-- Include all compiled plugins (below), or include insectionidual files as needed -->
		<script src="scripts/jquery.min.js"></script>
		<script src="scripts/bootstrap.min.js"></script>
		<script src="scripts/jquery.forms.min.js"></script>
		
		<style>
			body { padding-top: 70px; }
			footer { background-color: #dd4814; }
		</style>
		
	</head>
   
	<header>   
		<?php 
	
		

			session_start();
			
			if(empty($_SESSION['email']))
			{
				@include("views/base/header_visitante.php");
			}
			else
			{	
				$nivel_acesso = $_SESSION["nivel_acesso"];
				if($nivel_acesso == 1)
				{
					@include("views/base/header_usuario.php");
					echo "
						<style type='text/css'>

							p
							{
								margin-top:0%;
							}

							#notificações1
							{
								text-align:center;
								width:20%;
								height: 15%;
								position: fixed;
								left: 76%;
								margin-top:35%;
								display:none;
							}
							
							#notificações2
							{
								text-align:center;
								height: 15%;
								width:20%;
								position: fixed;
								left: 76%;
								margin-top:27%;
								display:none;
							}
							
							#notificações3
							{
								text-align:center;
								height: 15%;
								width:20%;
								position: fixed;
								left: 76%;
								margin-top:19%;
								display:none;
							}
							
						</style>
						<script type = 'text/javascript'>							
							var inicio = setInterval('Sidebar()', 0000);
							var inicio_notificações = setInterval('Notificações()', 0000);
							var intervalo = setInterval('Sidebar()', 5000);
							var notificações = setInterval('Notificações()', 5000);
	
							function Notificações()
							{
								$.ajax({
								
									url : 'ajax/notificacoes.php',
									dataType : 'json',
									success : function(data){
									$('#notificações').html(data.retorno);
									$('#notificações1').fadeIn('slow');
									$('#notificações2').fadeIn('slow');
									$('#notificações3').fadeIn('slow');
										
									},
									error : function(data){
									alert('Ops! Ocorreu um erro nas notificações, contate nossos administradores para mais informações.');
									}
									
								});
								clearInterval(inicio_notificações);
							}
							
							function Sidebar()
							{
								
								$.ajax({
									url : 'ajax/sidebar.php',
									dataType : 'json',
									success : function(data){
										document.getElementById('Moedas').innerHTML = data.moedas;
										
										document.getElementById('Trocas_aceitas').innerHTML = data.trocas_aceitas;
										if(data.trocas_aceitas != 0)
										{
										    document.getElementById('Trocas_aceitas').style.backgroundColor = '#dd4814';
										}
										else
										{
											document.getElementById('Trocas_aceitas').style.backgroundColor = '#aea79f';
										}
										
										document.getElementById('Solicitacoes_recebidas').innerHTML = data.solicitacoes_recebidas;
										if(data.solicitacoes_recebidas != 0)
										{
										    document.getElementById('Solicitacoes_recebidas').style.backgroundColor = '#dd4814';
										}
										else
										{
											document.getElementById('Solicitacoes_recebidas').style.backgroundColor = '#aea79f';
										}
										
										document.getElementById('CadeMeusLivros').innerHTML = data.trajetoria_livros;
										if(data.trajetoria_livros != 0)
										{
										    document.getElementById('CadeMeusLivros').style.backgroundColor = '#dd4814';
										}
										else
										{
											document.getElementById('CadeMeusLivros').style.backgroundColor = '#aea79f';
										}
									},
									error : function(data){
									alert('Ops! Ocorreu um erro com sua sidebar, contate nossos administradores para mais informações.');
									}
								
								});
								clearInterval(inicio);
							}						
			
						</script>";
						
					echo '<aside style = "width:20%; height: auto; position: fixed; left: 76%; margin-top:0%">
							<section class="panel panel-default">
								<section class="panel-heading">Notificações</section>
								<section class="panel-body">
									<nav>
										<ul class="nav navbar-nav" style="width: 100%;">
											<a><li class="list-group-item"> Moedas<span id="Moedas" class="badge">0</span></li></a>
											<a href = "?url=trocas_aceitas"><li class="list-group-item"> Trocas aceitas  <span id="Trocas_aceitas" class="badge">0</span></li></a>
											<a href = "?url=solicitacoes_recebidas"><li class="list-group-item"> Solicitações recebidas<span id="Solicitacoes_recebidas"class="badge">0</span></li></a>
											<a href = "?url=solicitacoes"><li class="list-group-item"> Cadê meus livros?  <span id="CadeMeusLivros" class="badge">0</span></li></a>
										</ul>
									</nav>
								</section>
							</section>
						</aside>
						<section id = "notificações">
						<section>';
				}
				else
				{
					@include("views/base/header_admin.php");
				}
				
			}
		?>
	</header>
	
	<body>
		<?php			
			//Verifica se ha alguma pagina selecionada
			if(isset($_GET["url"])){
				//verifica se a pagina veio com extencao, se nao concatena a ext php.
				$arquivo = $_GET["url"].(preg_match('/.php/i',$_GET["url"],$matches,PREG_OFFSET_CAPTURE) ? "" : ".php");		
				//Tenta anexar a pagina, senao imprime a mensagem de pagina nao encontrada
				if(!@include('views/'.$arquivo))
					echo "Pagina nao encontrada!";
			}
			else
			{
				if(empty($_SESSION['email']))
				{
					@include("views/home_visitante.php");
				}
				else
				{
					if($_SESSION["nivel_acesso"] == 1)
					{
						@include("views/index_usuario.php");
					}
					else
					{
						@include("views/home_admin.php");
					}
					
				}
			}
		?>
		

		
	</body>
	
	
</html>