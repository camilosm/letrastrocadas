<?php
	// Verifica se o botão foi acionado
	session_start();
	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['alterar_dados_admin']))
		{
			include("classes/class_banco.php");
			//Instancia e faz conexão com o banco de dados
			$banco = new Banco();
			include("alterar_dados_admin_n.php");	
		}
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
?>

<header>
	<?php  session_start(); @include('views/base/header_admin.php'); ?>
</header>
	
<article id  = "alterar_dados_perfil" style = "width: 60%; margin-left: 20%;">

	<form class="form-horizontal" method = "post" action = "?url=alterar_dados_admin">
		<fieldset>
			<legend>Alterar Dados Administrador</legend>
			<section class="form-group">
				<label for="inputNome" class="col-md-2 control-label">Nome:</label>
				<section class="col-md-10">	 
					<input type="text" class="form-control"  name = "nome" id="nome" required placeholder = "Nome" maxlength = "100" value = "<?php echo $_SESSION["nome"]; ?>">			  
				</section>
				 <br>
				<label for="inputEmail" class="col-md-2 control-label">E-mail:</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100" value = "<?php echo $_SESSION["email"]; ?>">  
				</section>
				<br>
				<section class="col-md-12 col-md-offset-2">
					<input type = "reset" name="cancelar" value="Limpar" class="btn btn-default"/>
					<button type="submit" name = "alterar_dados_admin" class="btn btn-primary">Salvar Alterações</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>