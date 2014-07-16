<?php
	
	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['alterarSenha']))
		{
		    include('alterar_senha_admin_n.php');
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

	
<div id="wrap">
<article id  = "mudar_senha" style = "width:52%;height:20%; position:relative;left:27%;"><!--margin-bottom:17.64%;-->

         <form class="form-horizontal" method = "post" action = "">
            <fieldset id = "legend_senha">
			
                  <legend>Alterar Senha Administrador</legend>
				  
		         <div class="form-group">
		 
                  <label for="inputSenhaAntiga" class="col-lg-2 control-label">Senha Atual:</label>
				  
         <div class="col-lg-9">
		 
                  <input type="password" class="form-control" id="inputSenhaT" name = "senhaAtual" required maxlength = "16" placeholder = "Senha Atual">
				  
         </div>
		
		 
                  <label for="inputSenha" class="col-lg-2 control-label">Nova senha:</label>
				  
         <div class="col-lg-9">
		 
                  <input type="password" class="form-control" id="inputSenhaT" name = "senhaNova" required placeholder = "Senha" maxlength = "16">
				  
         </div>
		 <br>
		 
                  <label for="inputConfirmarSenha" class="col-lg-2 control-label">Confirmar nova senha:</label>
				  
         <div class="col-lg-9">
		 
                  <input type="password" class="form-control" id="inputSenhaT" name = "confirmaSenha" required placeholder = "Senha" maxlength = "16">
				  
         </div>

		 <br>
         <div class="col-lg-9 col-lg-offset-2">
		 <br>
                       <button style="margin-left: 5px; float:right;" type="submit" name = "alterarSenha" class="btn btn-primary">Salvar Alterações</button>
					   <button style="float:right;" type = "reset" class="btn btn-default">Cancelar</button>
        </div>
        </div>
			
           </fieldset>
    </form>
</article>
</div>