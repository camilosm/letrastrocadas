<?php

	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['cadastrar_editora']))
		{
			include("classes/class_banco.php");
			$banco = new Banco();
			include("cadastra_editora.php");
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
			
			$tabelas = "tbl_editora";
			$campos="nome";
			$condicao = "id_editora = ".$id;
			
			$pesquisar_editora = new Pesquisar($tabelas,$campos,$condicao);
			$resultado = $pesquisar_editora->pesquisar();
			
			
			while($pesquisar_editora=mysql_fetch_assoc($resultado))
			{
				$nome = $pesquisar_editora['nome'];
			}
		}
			
		
		if(isset($_POST['alterar']))
		{
			include("class_editar_caracteres.php");
			include("classes/class_banco.php");
			$banco = new Banco();
			include("classes/class_update.php");
			
			
			$id_editora = $_POST['id_editora'];
			
			
			$editar_id = new EditarCaracteres($id_editora);
			$id_editora = $editar_id->sanitizeString($_POST['id_editora']);
		
			$nome = $_POST['nome'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
			$campos = "nome = '".$nome."'";
			$condicao = "id_editora = ".$id_editora;
			$alterar_editora= new Alterar("tbl_editora",$campos,$condicao);
			$resultado_editora = $alterar_editora->alterar();
			if($resultado_editora == 1)
			{
					echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Editora alterado com sucesso!</strong>
						</section>";		
			}
			else
			{
				
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar editora.</strong> Tente novamente!
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
	
<div id="wrap">
<article id  = "cadastro_usuario" style = "position:relative;width:50%;height:20%;left:27%;">
		
		<form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Pesquisar Editora</legend>
				  
         <div class="form-group">
		 
                  <label for="inputID" class="col-lg-2 control-label">ID:</label>
         <div class="col-lg-9">
		 
                  <input type="text" class="form-control" name = "id" placeholder = "ID" >
				  
         </div>
		 <br>
		 <div class="col-lg-9 col-lg-offset-2">
		 <br>
                       
                       
					   <button style="margin-left: 5px; float:right;" type="submit" name = "pesquisar" class="btn btn-primary">Pesquisar</button>
		 </fieldset>
		 </form>
		
         <form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Cadastrar/Alterar Editora</legend>
				  
         <div class="form-group">
		 
				  <label for="inputID" class="col-lg-2 control-label">ID:</label>
         <div class="col-lg-9">
		 
                  <input type="text" class="form-control" name = "id_editora" value="<?php echo $id?>" placeholder = "ID" >
				  
         </div>
		 
                  <label for="inputDescricao" class="col-lg-2 control-label">Editora:</label>
				  
         <div class="col-lg-9">	 
                  <input type="text" class="form-control" value="<?php echo $nome ;?>"  name = "nome" required placeholder = "Editora" maxlength = "100">			  
         </div>
		 <br>
            
		          <div class="col-lg-9 col-lg-offset-2">
		 <br>
                       
                       
					   <button style="margin-left: 5px; float:right;" type="submit" name = "cadastrar_editora" class="btn btn-primary">Cadastrar</button>
					   <button style="margin-left: 5px; float:right;" type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					   <button style="float:right;" type = "reset "class="btn btn-default">Cancelar</button>
					   
        </div>
        </div>
		</form>
</article>
</div>