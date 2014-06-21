<?php
	// Verifica se o botão foi acionado
	if(isset($_POST['cadastrar_genero']))
	{
		include("classes/class_banco.php");
		
		//Instancia a classe responsável pela conexão com o banco de dados
		$banco = new Banco();
		include("cadastro_genero.php");
	}
?>

<article id  = "cadastro_usuario" style = "position:relative;width:40%;height:20%;left:30%;">

         <form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Cadastrar gênero</legend>
				  
         <div class="form-group">
		 
                  <label for="inputDescricao" class="col-lg-2 control-label">Descrição</label>
				  
         <div class="col-lg-10">	 
                  <input type="text" class="form-control"  name = "descricao" id="descricao" required placeholder = "Descrição" maxlength = "100">			  
         </div>
		 <br>
                  <label for="inputID" class="col-lg-2 control-label">ID</label>
         <div class="col-lg-10">
		 
                  <input type="text" class="form-control" name = "id" id="inputID" required placeholder = "ID" >
				  
         </div>
		 <br> 
		          <div class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button type = "reset "class="btn btn-default">Limpar</button>
                       <button type="submit" name = "cadastrar_genero" class="btn btn-primary">Cadastrar</button>
					   <button type="submit" name = "alterar_genero" class="btn btn-primary">Alterar</button>
        </div>
        </div>
		</form>
		
</article>