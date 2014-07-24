<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
	if(isset($_POST['cadastrar_autor']))
	{
		include("classes/class_banco.php");
		$banco = new Banco();
		include("cadastra_autor.php");
	}
if(isset($_POST['pesquisar']))
		{
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");
			include("class_editar_caracteres.php");
			$banco = new Banco();
			
			$id = $_POST['id'];
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeString($_POST['id']);
			
			$tabelas = "tbl_autor";
			$campos="nome";
			$condicao = "id_autor = ".$id;
			
			$pesquisar_autor = new Pesquisar($tabelas,$campos,$condicao);
			$resultado = $pesquisar_autor->pesquisar();
			
			
			while($pesquisar_autor=mysql_fetch_assoc($resultado))
			{
				$nome = $pesquisar_autor['nome'];
			}
		}
			
		
		if(isset($_POST['alterar']))
		{
			include("class_editar_caracteres.php");
			include("classes/class_banco.php");
			$banco = new Banco();
			include("classes/class_update.php");
			
			
			$id_autor = $_POST['id_autor'];
			
			
			$editar_id = new EditarCaracteres($id_autor);
			$id_autor = $editar_id->sanitizeString($_POST['id_autor']);
		
			$nome = $_POST['nome'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
			$campos = "nome = '".$nome."'";
			$condicao = "id_autor = ".$id_autor;
			$alterar_autor= new Alterar("tbl_autor",$campos,$condicao);
			$resultado_autor = $alterar_autor->alterar();
			if($resultado_autor == 1)
			{
					echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Autor alterado com sucesso!</strong>
						</section>";		
			}
			else
			{
				
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar autor.</strong> Tente novamente!
				</section>";	
				
				
			}
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


<article id  = "cadastro_usuario" style = "position:relative;width:50%;height:20%;left:27%;">
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Pesquisar Autor</legend>
			<section class="form-group">
				<label for="inputID" class="col-md-2 control-label">ID:</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "id" id="inputID" placeholder = "ID" >  
				</section>
				<br>
				<section class="col-md-10 col-md-offset-2">
					<button style="margin-left: 5px; float:right;" type="submit" name = "pesquisar" class="btn btn-primary">Pesquisar</button>
				</section>
			</section>
		</fieldset>
	</form>

	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Cadastrar/Alterar Autor</legend>
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
					<button type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
				
			</section>
		</fieldset>
	</form>
</article>