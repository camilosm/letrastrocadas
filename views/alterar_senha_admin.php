<?php
	
	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['alterarSenha']))
		{
		    include('alterar_senha_admin_n.php');
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

<article id  = "mudar_senha" style = "width:52%;height:20%; position:relative;left:27%;"><!--margin-bottom:17.64%;-->
	<form class="form-horizontal" method = "post" action = "">
		<fieldset id = "legend_senha">
			<legend>Alterar Senha Administrador</legend>
			<section class="form-group">
				
				<label for="inputSenhaAntiga" class="col-md-2 control-label">Senha Atual:</label>
				<section class="col-md-10">
					<input type="password" class="form-control" id="inputSenhaT" name = "senhaAtual" required maxlength = "16" placeholder = "Senha Atual">
				</section>

				<label for="inputSenha" class="col-md-2 control-label">Nova senha:</label>
				<section class="col-md-10">
					<input type="password" class="form-control" id="inputSenhaT" name = "senhaNova" required placeholder = "Senha" maxlength = "16">
				</section>
				<br>
				<label for="inputConfirmarSenha" class="col-md-2 control-label">Confirmar nova senha:</label>
				<section class="col-md-10">
					<input type="password" class="form-control" id="inputSenhaT" name = "confirmaSenha" required placeholder = "Senha" maxlength = "16">
				</section>
				<br>
				<section class="col-md-10 col-md-offset-2">
					<br>
					<input type = "reset" class="btn btn-default" value="Limpar"/>
					<button type="submit" name = "alterarSenha" class="btn btn-primary">Salvar Alterações</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>