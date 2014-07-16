<script type='text/javascript'>
</script>
<?php
	if(empty($_SESSION['nivel_acesso']))
	{
		// Verifica se o botão foi acionado
		if(isset($_POST['entrar']))
		{
			//Inclui a página responsável or realizar o login
			include("cadastrar_usuario.php");
		}
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
?>

<article id  = "cadastro_usuario" style = "position:relative;width:50%;left:25%;">

         <form class="form-horizontal" method = "post" action = "?url=cadastro_usuario">
            <fieldset>
			
                  <legend>Cadastro</legend>
				  
         <section class="form-group">
		 
                  <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				  
         <section class="col-lg-10">	 
                  <input type="email" class="form-control"  name = "email" id="email" value = "" required placeholder = "E-mail" maxlength = "100">			  
         </section>
		 <br>
                  <label for="inputSenha" class="col-lg-2 control-label">Senha</label>
         <section class="col-lg-10">
		 
                  <input type="password" class="form-control" name = "senha" id="inputSenha" required placeholder = "Senha" maxlength = "16">
				  
         </section>
		 <br> 
                  <label for="inputConfirmarSenha" name = "confirmar" class="col-lg-2 control-label">Confirmar Senha</label>
				  
         <section class="col-lg-10">
                  <input type="password" class="form-control" name = "confirmar" id="inputSenha" required maxlength = "16" placeholder = "Confirmar senha">		  
         </section>
         <section class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button type = "reset "class="btn btn-default">Limpar</button>
                       <button type="submit" name = "entrar" class="btn btn-primary">Cadastrar</button>
        </section>
        </section>
			
           </fieldset>
    </form>
</article>