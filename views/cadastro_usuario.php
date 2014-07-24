<script type='text/javascript'>
</script>
<?php
	if(empty($_SESSION['nivel_acesso']))
	{
		// Verifica se o botão foi acionado
		if(isset($_POST['entrar']))
		{
			//Inclui a página responsável or realizar o login
			include("cadastrar_usuario.php");
		}
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
?>

<article id  = "cadastro_usuario" style = "width: 60%; margin-left: 20%;">
	<form class="form-horizontal" method = "post" action = "?url=cadastro_usuario">
		<fieldset>
			<legend>Cadastro</legend>				  
			<section class="form-group">
				<label for="inputEmail" class="col-md-2 control-label">E-mail</label>
				<section class="col-md-10">	 
					<input type="email" class="form-control"  name = "email" id="email" value = "" required placeholder = "E-mail" maxlength = "100">			  
				</section>
				<br>
				<label for="inputSenha" class="col-md-2 control-label">Senha</label>
				<section class="col-md-10">
					<input type="password" class="form-control" name = "senha" id="inputSenha" required maxlength = "16" placeholder = "Entre 8 e 16 dígitos" maxlength = "16">
				</section>
				<br> 
				<label for="inputConfirmarSenha" name = "confirmar" class="col-md-2 control-label">Confirmar Senha</label>
				<section class="col-md-10">
					<input type="password" class="form-control" name = "confirmar" id="inputSenha" required maxlength = "16" placeholder = "Digite sua senha novamente">		  
				</section>
				<br>
				<section class="col-md-12 col-md-offset-2">
					<input type = "reset" class="btn btn-default" value="Limpar"/>
					<button type="submit" name = "entrar" class="btn btn-primary">Cadastrar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>