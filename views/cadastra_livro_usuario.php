<?php
	
	//Verifica se o botão foi acionado
	if(isset($_POST['cadastrarLivroUsuario']))
	{
		include("php_cadastrar_livro_usuario.php");
	}
	
?>

<article id  = "body_cadastra_livro_usu" style = "width:60%;height:60%;position:relative;left:30%;">
    
         <form class="form-horizontal" method="post" action=""  enctype="multipart/form-data">
            <fieldset>
			
                  <legend>Cadastrar livro</legend>
				  
         <section class="form-group">
		 		 	 
                <label for="textArea" class="col-lg-2 control-label">Estado:</label>
				
         <section class="col-lg-10">
                <textarea class="form-control" name = "estado" rows="3" required style = "width: 50%;"id="textArea" placeholder = "Escreva aqui as condições do livro que deseja disponibilizar(danos, observações, adicionais)"></textarea> 
         </section>
		 
				<label for="txtAno" class="col-lg-2 control-label">Ano:</label>
				
         <section class="col-lg-10">
                <input type="number" min = "1455" max="2014" class="form-control" required name = "ano" id = "txtAno" rows="3" style = "width: 50%;" placeholder = "Ano da fabricação"/>
         </section>
		 
                  <label for="inputFotolivro" class="col-lg-2 control-label">Fotos: </label>
		
    <section style = "position:relative; width:25%; height: 5%;left:20%;top:2%; ">		
         <section class="col-lg-10">
		 
                  <input type="file" id="inputFoto1" required name="primeira_foto" >
				  
         </section>
				  
         <section class="col-lg-10">
		 
                  <input type="file" id="inputFoto2" required name="segunda_foto">
				  
         </section>
		 
				  
         <section class="col-lg-10">
		 
                  <input type="file" id="inputFoto3" required name="terceira_foto" >
				  
         </section>
	</section>	
		<br>
        <section class="col-lg-10 col-lg-offset-2">
		<br>
                       <button type = "reset"class="btn btn-default">Cancelar</button>
                       <button type="submit" name = "cadastrarLivroUsuario" class="btn btn-primary">Cadastrar</button>
        </section>
		</section>
           </fieldset>
    </form>
</article>