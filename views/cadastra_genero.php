<?php
	$nome = "";
	$id = "";
	//if($_SESSION['nivel_acesso'] == 2)
	//{
		if(isset($_POST['cadastrar_genero']))
		{
			include("classes/class_banco.php");
			$banco = new Banco();
			include("cadastro_genero.php");
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
			
			$tabelas = "tbl_categoria";
			$campos="nome";
			$condicao = "id_categoria = ".$id;
			
			$pesquisar_genero = new Pesquisar($tabelas,$campos,$condicao);
			$resultado = $pesquisar_genero->pesquisar();
			
			
			while($pesquisar_genero=mysql_fetch_assoc($resultado))
			{
				$nome = $pesquisar_genero['nome'];
			}
		}
			
		
		if(isset($_POST['alterar']))
		{
			include("class_editar_caracteres.php");
			include("classes/class_banco.php");
			$banco = new Banco();
			include("classes/class_update.php");
			
			
			$id_genero = $_POST['id_genero'];
			
			
			$editar_id = new EditarCaracteres($id_genero);
			$id_genero = $editar_id->sanitizeString($_POST['id_genero']);
		
			$nome = $_POST['nome'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
			$campos = "nome = '".$nome."'";
			$condicao = "id_categoria = ".$id_genero;
			$alterar_genero = new Alterar("tbl_categoria",$campos,$condicao);
			$resultado_genero = $alterar_genero->alterar();
			if($resultado_genero == 1)
			{
									echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
											<strong>Gênero alterado com sucesso!</strong>
									</section>";
			}
			else
			{
				
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar gênero.</strong> Tente novamente!
				</section>";
				
			}
		}
	//}
	/*else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}*/
?>

<section id="wrap">
<article id  = "cadastro_usuario" style = "position:relative;width:50%;height:20%;left:27%;">
		
		<form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Pesquisar Gênero</legend>
				  
         <section class="form-group">
		 
                  <label for="inputID" class="col-lg-2 control-label">ID:</label>
         <section class="col-lg-9">
		 
                  <input type="text" class="form-control" name = "id" placeholder = "ID" >
				  
         </section>
		 <br>
		 <section class="col-lg-9 col-lg-offset-2">
		 <br>
                       
                       
					   <button style="margin-left: 5px; float:right;" type="submit" name = "pesquisar" class="btn btn-primary">Pesquisar</button>
		 </fieldset>
		 </form>


         <form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Cadastrar/Alterar Gênero</legend>
				  
         <section class="form-group">
		 
				  <label for="inputID" class="col-lg-2 control-label">ID:</label>
         <section class="col-lg-9">
		 
                  <input type="text" class="form-control" name = "id_genero" value ="<?php echo $id; ?>"  placeholder = "ID" >
				  
         </section>
		 
                  <label for="inputDescricao" class="col-lg-2 control-label">Descrição:</label>
				  
         <section class="col-lg-9">	 
                  <input type="text" class="form-control"  name = "nome" id="descricao" required value="<?php echo $nome; ?>" placeholder = "Descrição" maxlength = "100">			  
         </section>
		 <br>
                  
		          <section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "cadastrar_autor" class="btn btn-primary">Cadastrar</button>
					<button type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
        </section>
		</form>
		
</article>
</section>