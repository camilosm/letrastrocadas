<?php

	if($_SESSION['nivel_acesso'] == 2)
	{
		// Include na classes de conexão com o banco de dados
		include("classes/class_banco.php");

		//Instanciando o banco de dados
		$banco_dados = new Banco();
		// Verifica  se o botão foi acionado
		if(isset($_POST['cadastrar']))
		{
			include("php_cadastrar_administrador.php");
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

<section id  = "cadastro_adm" style = "position:relative;width:40%;height:20%;left:30%;">

         <form class="form-horizontal" method = "post" action = "">
            <fieldset>
			
                  <legend>Cadastro</legend>
				 
				 
         <div class="form-group">
		 
                  <label for="inputNome" class="col-lg-2 control-label">Nome</label>
				  
         <div class="col-lg-10">
		 
                  <input type="nome" class="form-control" name = "nome" id="nome" required placeholder = "Nome" maxlength = "100">
				  
         </div>
		 
                  <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				  
         <div class="col-lg-10">
		 
                  <input type="email" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100">
				  
         </div>
		 
                  <label for="inputSenha" class="col-lg-2 control-label">Senha</label>
				  
         <div class="col-lg-10">
		 
                  <input type="password" class="form-control" name = "senha" id="inputSenha" required placeholder = "Senha" maxlength = "16">
				  
         </div>
		 
                  <label for="inputConfirmarSenha" class="col-lg-2 control-label">Confirmar Senha</label>
				  
         <div class="col-lg-10">
		 
                  <input type="password" class="form-control" name = "confirmarsenha" id="inputSenha" required maxlength = "16" placeholder = "Confirmar senha">
				  
         </div>
        
	
		
         <div class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button type = "reset "class="btn btn-default">Cancelar</button>
                       <button type="submit" name = "cadastrar" class="btn btn-primary">Cadastrar</button>
        </div>
        </div>
			
           </fieldset>
    </form>
</section>