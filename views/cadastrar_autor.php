<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['cadastrar_autor']))
		{
			include("classes/class_banco.php");
			$banco = new Banco();
			include("cadastra_autor.php");
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

<article id  = "cadastro_usuario" style = "position:relative;width:50%;height:20%;left:27%;">
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Cadastrar Autor</legend>
			<section class="form-group">
				<label for="inputID" class="col-md-2 control-label">ID:</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "id_autor" value="<?php echo $id?>" id="inputID" placeholder = "ID" >
				</section>
				<br>
				<label for="inputDescricao" class="col-md-2 control-label">Autor:</label>			  
				<section class="col-md-10">	 
					<input type="text" class="form-control"  name = "nome" value="<?php echo $nome?>" required placeholder = "Nome" maxlength = "100">			  
				</section>
				<br>
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "cadastrar_autor" class="btn btn-primary">Cadastrar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>