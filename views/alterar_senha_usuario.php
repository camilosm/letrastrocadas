<?php
	
	if($_SESSION['nivel_acesso'] == 1)
	{
		if(isset($_POST['alterarSenha']))
		{
		    include('alterar_senha_usu_n.php');
		}
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
	
?>


<article id  = "mudar_senha" style = "width:51%;height:20%; position:relative;left:27%;">

         <form class="form-horizontal" method = "post" action = "">
            <fieldset id = "legend_senha">
			
                  <legend>Alterar senha</legend>
				  
		 <div class="form-group">
		 
                  <label for="inputSenhaAntiga" class="col-lg-2 control-label">Senha Atual</label>
				  
         <div class="col-lg-10">
		 
                  <input type="password" class="form-control" name = "senhaAtual" id="inputSenhaT" required maxlength = "16" placeholder = "Senha Atual">
				  
         </div>
                <label for="inputSenha" class="col-lg-2 control-label">Nova senha</label>
				  
         <div class="col-lg-10">
		 
                  <input type="password" class="form-control" id="inputSenhaT" name = "senhaNova" required placeholder = "Senha" maxlength = "16">
				  
         </div>
		 <br>
                  <label for="inputConfirmarSenha" class="col-lg-2 control-label">Confirmar nova senha</label>
				  
         <div class="col-lg-10">
		 
                  <input type="password" class="form-control" id="inputSenhaT" name = "confirmaSenha" required placeholder = "Senha" maxlength = "16">
				  
         </div>
		 <br>	
         <div class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button type = "reset "class="btn btn-default">Cancelar</button>
                       <button type="submit" class="btn btn-primary" name = "alterarSenha">Salvar alterações</button>
        </div>
        </div>
			
           </fieldset>
    </form>
</article>