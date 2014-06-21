<?php

	// Include na classes de conexão com o banco de dados
	include("classes/class_banco.php");

	//Instanciando o banco de dados
	$banco_dados = new Banco();
	
	//Verifica se o botão responsável pelo cadastro do livro foi acionado
	if(isset($_POST['cadastrarLivro']))
	{
		include("php_cadastrar_livro.php");
	}
	//Verifica se o botão responsável pelo cadastro do autor foi acionado
	if(isset($_POST['cadastrar_autor']))
	{
		include("cadastra_autor.php");
	}
	//Verifica se o botão responsável pelo cadastro da editora foi acionado
	if(isset($_POST['cadastrar_editora']))
	{
		include("cadastra_editora.php");
	}
	
	// Página que carrega os combobox com dados do banco de dados
	include ("inicializacao_cadastro_livro_adm.php");
	

?>
<script type="text/javascript">

$(document).ready(function(){ 
	// Ao cliquar no botão de cadastrar editora o jquery torna o formulário da editora visível e o de autor invisível
    $("#mostrar_editora").click(function(){
            $("#body_cadastrar_editora").css({"display" : "inline-block"});
			$("#body_cadastrar_autor").css({"display" : "none"});
    });
	
	// Ao cliquar no botão de cadastrar autor o jquery torna o formulário da autor visível e o de editora invisível
	$("#mostrar_autor").click(function(){
             $("#body_cadastrar_autor").css({"display" : "inline-block"});
			 $("#body_cadastrar_editora").css({"display" : "none"});	 
    });
})

</script>

<article id  = "body_cadastra_livro" style = "width:30%;height:60%;position:relative;left:30%;">
    
    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            <fieldset>
			
                  <legend>Cadastrar livro</legend>
				  
         <div class="form-group">
		 
                  <label for="inputNome" class="col-lg-2 control-label">Nome</label>
				  
         <div class="col-lg-10">
		 
                  <input type="text" class="form-control" name = "nome" id="nome" required placeholder = "Nome do Livro" maxlength = "100">
				  
         </div>
		 <br>
		 <label for="inputEdicaolivro" class="col-lg-2 control-label">Edição</label>				  
         <div class="col-lg-10">
		 
                  <input type="number" class="form-control" name = "edicao" id="inputEdicao" required placeholder = "Edição do livro" maxlength = "20" min = "0" max = "20000">
				  
         </div>
		 <br>		 
                  <label for="inputIsnblivro" class="col-lg-2 control-label">ISBN</label>
				  
         <div class="col-lg-10">
		 
                  <input type="number" class="form-control" name="isbn" id="inputISBN" required maxlength = "17" placeholder = "ISBN" min="0" max = "20000">				  
         </div>
		 
                  <label for="select" class="col-lg-2 control-label">Editora</label>
			
         <div class="col-lg-10">
			
              <select class="form-control" name = "cmbEditora" id="select">
			  
                <?php
				/*Explica esse é um pouco difícil mas enfim (a gente viu isso na aula do Marcelo? nem me lembro mais, mas vou tentar
				explicar mesmo assim), a quem tiver dúvida me procura qualquer dia que eu explico @-@*/
				while($dados_editora = mysql_fetch_row($resultado_editora))
				{
					echo "<option value = ".$dados_editora[0].">".$dados_editora[1]."</option>";
				}
				
				?>
				
              </select>
			  
		</div>
			
                <label for="select" class="col-lg-2 control-label">Autor</label>
				
            <div class="col-lg-10">
			
              <select class="form-control" name = "cmbAutor" id="select">
			  
                <?php
				
				while($dados_autor = mysql_fetch_row($resultado_autor))
				{
					echo "<option value = ".$dados_autor[0].">".$dados_autor[1]."</option>";
				}
				
				?>
				
              </select>
         </div>
		 		   
              <label for="select" class="col-lg-2 control-label">Gênero</label>
			  
           <div class="col-lg-10">
		   
              <select class="form-control" name = "cmbGenero" id="select">
			  
                <?php
				
				while($dados_genero = mysql_fetch_row($resultado_genero))
				{
					echo "<option value = ".$dados_genero[0].">".$dados_genero[1]."</option>";
				}
				
				?>
				
              </select>
			  
		</div>
		<br>
				
			<label for="textArea" class="col-lg-2 control-label">Sinopse</label>
		<div class="col-lg-10">
		
			<textarea class="form-control" rows="3" name="sinopse" id="textArea"></textarea>
			
		</div>
			
			<label for="inputEdicaolivro" class="col-lg-2 control-label">Páginas</label>				  
		
		<div class="col-lg-10">

			  <input type="number" class="form-control" name = "numero_paginas" id="inputNumeros" required placeholder = "Números de páginas" maxlength = "20" min = "0" max = "20000">
			  
		</div>
		 
                <label for="inputFotolivro" class="col-lg-2 control-label">Foto: </label>
				  
         <div class="col-lg-10">
		 
                  <input type="file" name="file"/>
				  
         </div> 
		
         <div class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button type = "reset" class="btn btn-default">Cancelar</button>
                       <button type="submit" name = "cadastrarLivro" class="btn btn-primary">Cadastrar</button>
        </div>
		
			<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" 
			title="Adicionar Autor" data-original-title="Adicionar Autor" id = "mostrar_autor" 
			style = "position: relative;margin-left:100%;margin-top:-70%;">+</button>
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" 
			title="Adicionar Editora" data-original-title="Adicionar Editora" id = "mostrar_editora" 
			style = "position: relative;margin-left:100%;margin-top:-97%;">+</button>
           </fieldset>
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