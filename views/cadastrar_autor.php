<?php
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
		$banco = new Banco();
		
		$id = $_POST['id'];
		
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeStringNome($_POST['id']);
		
		
		
		$tabelas = "tbl_autor";
		$campos="nome";
		$codição = "id_autor = ".$id;
		
		$pesquisar_autor = new Pesquisar($tabelas,$campos,$condicao);
		$resultado = $pesquisar_autor->pesquisar();
		
		while($pesquisar_autor=mysql_fetch_array($resultado))
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
		$codição = "id_autor = ".$id;
		$alterar_lista_livro = new Alterar("tbl_autor",$campos,$codição);
		$resultado_lista_livro = $alterar_lista_livro->alterar();
		if($resultado == 1)
		{
								echo "<div class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
										<strong>Autor alterado com sucesso!</strong>
								</div>";
		}
		else
		{
			
			echo "<div class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
					<strong>Erro ao alterar autor.</strong> Tente novamente!
			</div>";
			
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
			
                  <legend>Pesquisar Autor</legend>
				  
         <div class="form-group">
		 
                  <label for="inputID" class="col-lg-2 control-label">ID:</label>
         <div class="col-lg-9">
		 
                  <input type="text" class="form-control" name = "id" id="inputID" placeholder = "ID" >
				  
         </div>
		 <br>
		 <div class="col-lg-9 col-lg-offset-2">
		 <br>
                       
                       
					   <button style="margin-left: 5px; float:right;" type="submit" name = "pesquisar_editora" class="btn btn-primary">Pesquisar</button>
		 </fieldset>
		 </form>
		
         <form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Cadastrar/Alterar Autor</legend>
				  
         <div class="form-group">
		 
                  <label for="inputDescricao" class="col-lg-2 control-label">Autor:</label>
				  
         <div class="col-lg-9">	 
                  <input type="text" class="form-control"  name = "autor_nome" id="nome" required placeholder = "Nome" maxlength = "100">			  
         </div>
		
                 
		 <br> 
		          <div class="col-lg-9 col-lg-offset-2">
		 <br>
					   <button style="margin-left: 5px; float:right;" type="submit" name = "cadastrar_autor" class="btn btn-primary">Cadastrar</button>
					   <button style="margin-left: 5px; float:right;" type="submit" name = "alterarAutor" class="btn btn-primary">Alterar</button>
					   <button style="float:right;" type = "reset "class="btn btn-default">Cancelar</button>
                       
        </div>
        </div>
		</form>
</article>
</div>