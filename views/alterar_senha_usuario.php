<?php
	
	//Verifica se o botão foi acionado
	if(isset($_POST['alterarSenha']))
	{
		include("classes/class_banco.php");
		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();
		include("alterar_senha_usu_n.php");
	}
	
?>

<article id  = "mudar_senha" style = "width:51%;height:20%; position:relative;left:27%;">

    <form class="form-horizontal" method = "post" action = "">
            <fieldset id = "legend_senha">		
                  <legend>Alterar senha</legend>	
			  
		<div class="form-group">
				
				<label for="inputSenhaAntiga" class="col-lg-2 control-label">Senha Atual</label>
					<div class="col-lg-10">	 
						<input type="password" class="form-control" name = "senhaAntiga" id="inputSenhaT" required maxlength = "16" placeholder = "Senha Atual">			  
					</div>
                <label for="inputSenha" class="col-lg-2 control-label">Nova senha</label>			  
					<div class="col-lg-10">
						<input type="password" class="form-control" name = "senhaNova" id="inputSenhaT" required placeholder = "Senha" maxlength = "16">		  
					</div>
                <label for="inputConfirmarSenha" class="col-lg-2 control-label">Confirmar nova senha</label>			  
					<div class="col-lg-10">
						<input type="password" class="form-control" id="inputSenhaT" required placeholder = "Senha" maxlength = "16">	  
					</div>
		 <br>	
         <div class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button type = "reset "class="btn btn-default">Cancelar</button>
                       <button type="submit" name = "alterarSenha" class="btn btn-primary">Salvar</button>
        </div>
        </div>
			
           </fieldset>
    </form>
</article>