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
				if($_SESSION["nivel_acesso"] == 1)
				{
					@include("views/base/header_usuario.php");
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