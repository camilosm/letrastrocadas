<?php

	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['cadastrar_editora']))
		{
			include("classes/class_banco.php");
			$banco = new Banco();
			include("cadastra_editora.php");
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

<article id  = "cadastro_usuario" style = "width: 60%; margin-left:20%;">
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Cadastrar Editora</legend>
			<section class="form-group">
				<label for="inputDescricao" class="col-md-2 control-label">Editora:</label>
				<section class="col-md-10">	 
					<input type="text" class="form-control" name = "nome" required placeholder = "Editora" maxlength = "100">			  
				</section>
				<br>						
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "cadastrar_editora" class="btn btn-primary">Cadastrar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>