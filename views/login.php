<?php
	if(empty($_SESSION['nivel_acesso']))
	{
		//Verifica se o botao foi acionado
		if(isset($_POST['entrar']))
		{
			//Inclui a classe da banco de dados
			include("classes/class_banco.php");
			//Instancia a classe
			$banco = new Banco();
			//Inclui a página responsável por verificar e realizar o login
			include("verificar_login.php");
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

<article id  = "login" style = "width:60%; position: absolute; left:20%;">
	<form class="form-horizontal" method="post" action="">
		<fieldset>
			<legend>Login</legend>	  
			<section class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				<section class="col-lg-10">		 
					<input type="email" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100">			  
				</section>
				<label for="inputSenha" class="col-lg-2 control-label">Senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" name = "senha" id="inputSenha" required placeholder = "Senha" maxlength = "16">
				</section>
				<section class="col-lg-10 col-lg-offset-2">
					<button style="float: right; margin-top:2%;" type="submit" name = "entrar" class="btn btn-primary">Entrar</button>
					<a style="float: left; margin-top:2%;" href="?url=esqueceu_senha">Esqueceu sua senha?</a>
				</section>
			</section>
		</fieldset>
	</form>
</article>