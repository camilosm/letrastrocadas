<?php
	
	if($_SESSION['nivel_acesso'] == 2)
	{
		// Include na classes de conexão com o banco de dados
		include("classes/class_banco.php");

		//Instanciando o banco de dados
		$banco_dados = new Banco();
		
		if(isset($_POST['cadastrarLivro']))
		{
			include("php_cadastrar_livro.php");
		}
		
		if(isset($_POST['cadastrar_autor']))
		{
			include("cadastra_autor.php");
		}
		
		if(isset($_POST['cadastrar_editora']))
		{
			include("cadastra_editora.php");
		}
		
		// Página que carrega os combobox com dados do banco de dados
		include ("inicializacao_cadastro_livro_adm.php");
		
			if(isset($_POST['pesquisar']))
		{
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");
			$banco = new Banco();
			
			$id = $_POST['id'];
			
				$editar_id = new EditarCaracteres($id);
				$id = $editar_id->sanitizeStringNome($_POST['id']);
			
			
			
			$tabelas = "tbl_livro";
			$campos="nome, imagem_livros, edicao, isnb, sinopse, numero_paginas, editora_id, autor_id, categora_id";
			$codição = "id_livro = ".$id;
			
			$pesquisar_editora = new Pesquisar($tabelas,$campos,$condicao);
			$resultado = $pesquisar_editora->pesquisar();
			
			while($pesquisar_editora=mysql_fetch_array($resultado))
				{
					$nome[] = $pesquisa['nome'];
					$imagem_livros[] = $pesquisa['imagem_livros'];
					$edicao[] = $pesquisa['edicao'];
					$isbn[] = $pesquisa['isbn'];
					$sinopse[] = $pesquisa['sinopse'];
					$numero_paginas[] = $pesquisa['numero_paginas'];
					$editora_nome[] = $pesquisa['editora_id'];
					$autor_nome[] = $pesquisa['autor_id'];
					$categoria_nome[] = $pesquisa['categoria_nome'];
					
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
			$codição = "id_livro = ".$id;
			$alterar_lista_livro = new Alterar("tbl_livro",$campos,$codição);
			$resultado_lista_livro = $alterar_lista_livro->alterar();
			if($resultado == 1)
			{
									echo "<div class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
											<strong>Livro alterado com sucesso!</strong>
									</div>";
			}
			else
			{
				
				echo "<div class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar livro.</strong> Tente novamente!
				</div>";
				
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

<script type="text/javascript">

$(document).ready(function(){
    $("#mostrar_editora").click(function(){
            $("#body_cadastrar_editora").css({"display" : "inline-block"});
			$("#body_cadastrar_autor").css({"display" : "none"});
    });
	
	$("#mostrar_autor").click(function(){
             $("#body_cadastrar_autor").css({"display" : "inline-block"});
			 $("#body_cadastrar_editora").css({"display" : "none"});	 
    });
})

</script>
<div id="wrap">
<article id  = "body_cadastra_livro" style = "width:50%;position:relative;left:27%;">
    
	<form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Pesquisar Livro</legend>
				  
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
	
    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            <fieldset>
			
                  <legend>Cadastrar/Alterar Livro</legend>
				  
         <div class="form-group">
		 
                  <label for="inputNome" class="col-lg-2 control-label">Nome:</label>
				  
         <div class="col-lg-9">
		 
                  <input type="text" class="form-control" value="<?php echo $nome ;?>" name = "nome" id="nome" required placeholder = "Nome do Livro" maxlength = "100">
				  
         </div>
		 <br>
		 <label for="inputEdicaolivro" class="col-lg-2 control-label">Edição:</label>				  
         <div class="col-lg-9">
		 
                  <input type="number" class="form-control" value="<?php echo $edicao ;?>" name = "edicao" id="inputEdicao" required placeholder = "Edição do livro" maxlength = "20" min = "0" max = "20000">
				  
         </div>
		 <br>		 
                  <label for="inputIsnblivro" class="col-lg-2 control-label">ISBN:</label>
				  
         <div class="col-lg-9">
		 
                  <input type="number" class="form-control" value="<?php echo $isbn ;?>" name="isbn" id="inputISBN" required maxlength = "17" placeholder = "ISBN" min="0" max = "20000">				  
         </div>
		 
                  <label for="select" class="col-lg-2 control-label">Editora:</label>
			
         <div class="col-lg-9">
			
              <select class="form-control" value="<?php echo $editora ;?>" name = "cmbEditora" id="select">
			  
			  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" 
			title="Adicionar Editora" data-original-title="Adicionar Editora" id = "mostrar_editora" 
			style = "position: relative;margin-left:150%;margin-top:%;">+</button> 
			  
                <?php
				
				while($dados_editora = mysql_fetch_row($resultado_editora))
				{
					echo "<option value = ".$dados_editora[0].">".$dados_editora[1]."</option>";
				}
				
				?>
				
              </select>
			
			 
		</div> 
					
                <label for="select" class="col-lg-2 control-label">Autor:</label>
				
            <div class="col-lg-9">
			
              <select class="form-control" value="<?php echo $autor ;?>"name = "cmbAutor" id="select">
			  
                <?php
				
				while($dados_autor = mysql_fetch_row($resultado_autor))
				{
					echo "<option value = ".$dados_autor[0].">".$dados_autor[1]."</option>";
				}
				
				?>
				
              </select>
         </div>
				
              <label for="select" class="col-lg-2 control-label">Gênero:</label>
			  
           <div class="col-lg-9">
		   
              <select class="form-control" value="<?php echo $genero ;?>"name = "cmbGenero" id="select">
			  
                <?php
				
				while($dados_genero = mysql_fetch_row($resultado_genero))
				{
					echo "<option value = ".$dados_genero[0].">".$dados_genero[1]."</option>";
				}
				
				?>
				
              </select>
			 
			  
		</div>
		<br>
				
			<label for="textArea" class="col-lg-2 control-label">Sinopse:</label>
		<div class="col-lg-9">
		
			<textarea class="form-control" rows="3" value="<?php echo $sinopse ;?>" name="sinopse" id="textArea"></textarea>
			
		</div>
			
			<label for="inputEdicaolivro" class="col-lg-2 control-label">Páginas:</label>				  
		
		<div class="col-lg-9">

			  <input type="number" class="form-control" value="<?php echo $numero_paginas ;?>" name = "numero_paginas" id="inputNumeros" required placeholder = "Números de páginas" maxlength = "20" min = "0" max = "20000">
			  
		</div>
		 
                <br><label for="inputFotolivro" class="col-lg-2 control-label">Foto: </label>
				  
         <div class="col-lg-9">
		 
                  <br><input type="file"  name="file" "position:relative; width:25%; height: 5%;left:20%;top:2%; "/>
				  
         </div> 
		
         <div class="col-lg-9 col-lg-offset-2">
		 <br>                       
                       <button style="margin-left: 5px; float:right;" type="submit" name = "cadastrarLivro" class="btn btn-primary">Cadastrar</button>
					   <button style="float:right;" type = "reset" class="btn btn-default">Cancelar</button>
        </div>
		
			<!--<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" 
			title="Adicionar Autor" data-original-title="Adicionar Autor" id = "mostrar_autor" 
			style = "position: relative;margin-left:100%;margin-top:-86%;">+</button>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" 
			title="Adicionar Editora" data-original-title="Adicionar Editora" id = "mostrar_editora" 
			style = "position: relative;margin-left:100%;margin-top:-104%;">+</button>
           </fieldset>-->
    </form>
</article>

<section id="body_cadastrar_editora" style = "display:none">
<form id = "cadastrar_editora" method="post" action = "">

	<input type = "text" name = "editora_nome" required placeholder = "Nome" maxlength = "100">
	<br>
	<input type = "submit" name = "cadastrar_editora" value = "Cadastrar Editora">

</form>
</section>

<section id="body_cadastrar_autor" style = "display:none">
<form id = "cadastrar_autor" method="post" action = "">

	<input type = "text" name = "autor_nome" required placeholder = "Nome" maxlength = "100">
	<br>
	<input type = "submit" name = "cadastrar_autor" value = "Cadastrar Autor">

</form>
</section>
</div>