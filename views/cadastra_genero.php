<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
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
			$banco = new Banco();
			
			$id = $_POST['id'];
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeStringNome($_POST['id']);
			
			$tabelas = "tbl_categoria";
			$campos="nome";
			$codição = "id_categoria = ".$id;
			
			$pesquisar_genero = new Pesquisar($tabelas,$campos,$condicao);
			$resultado = $pesquisar_genero->pesquisar();
			
			while($pesquisar_genero=mysql_fetch_array($resultado))
				{
					$nome[] = $pesquisa['nome'];
				}
		}
			
		
		if(isset($_POST['alterar']))
		{
			include("class_editar_caracteres.php");
			
			include("classes/class_update.php");
			
			
			$id = $_GET['id'];
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeString($_GET['id']);
		
			$nome = $_POST['nome'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = $editar_nome->sanitizeString($_POST['nome']);
		
			$campos = "nome = '".$nome."'";
			$codição = "id_categoria = ".$id;
			$alterar_lista_livro = new Alterar("tbl_categoria",$campos,$codição);
			$resultado_lista_livro = $alterar_lista_livro->alterar();
			if($resultado == 1)
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

<section id="wrap">
<article id  = "cadastro_usuario" style = "position:relative;width:50%;height:20%;left:27%;">
		
		<form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Pesquisar Gênero</legend>
				  
         <section class="form-group">
		 
                  <label for="inputID" class="col-lg-2 control-label">ID:</label>
         <section class="col-lg-9">
		 
                  <input type="text" class="form-control" name = "id" id="inputID" placeholder = "ID" >
				  
         </section>
		 <br>
		 <section class="col-lg-9 col-lg-offset-2">
		 <br>
                       
                       
					   <button style="margin-left: 5px; float:right;" type="submit" name = "pesquisar_editora" class="btn btn-primary">Pesquisar</button>
		 </fieldset>
		 </form>


         <form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Cadastrar/Alterar Gênero</legend>
				  
         <section class="form-group">
		 
                  <label for="inputDescricao" class="col-lg-2 control-label">Descrição:</label>
				  
         <section class="col-lg-9">	 
                  <input type="text" class="form-control"  name = "descricao" id="descricao" required placeholder = "Descrição" maxlength = "100">			  
         </section>
		 <br>
                  
		          <section class="col-lg-9 col-lg-offset-2">
		 <br>
					<button style="margin-left: 5px; float:right;" type="submit" name = "cadastrar_genero" class="btn btn-primary">Cadastrar</button>
					   <button style="margin-left: 5px; float:right;" type="submit" name = "alterar_genero" class="btn btn-primary">Alterar</button>
					   <button style="float:right;" type = "reset "class="btn btn-default">Cancelar</button>
                       
                       
        </section>
        </section>
		</form>
		
</article>
</section>