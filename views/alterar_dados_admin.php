<?php
	// Verifica se o botão foi acionado
	if(isset($_POST['alterar_dados_admin']))
	{
		include("classes/class_banco.php");
		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();
		include("alterar_dados_admin_n.php");
	}
?>

	<header>
		<?php  session_start(); @include('views/base/header_admin.php'); ?>
	</header>
<div id="wrap">
<article id  = "alterar_dados_perfil" style = "position:relative;width:50%;height:20%;left:27%;">

    <form class="form-horizontal" method = "post" action = "?url=alterar_dados_admin">
            <fieldset>
			
                  <legend>Alterar Dados Administrador</legend>
				  
      <div class="form-group">
		 
                  <label for="inputNome" class="col-lg-2 control-label">Nome:</label>
				  
         <div class="col-lg-9">	 
                  <input type="text" class="form-control"  name = "nome" id="nome" required placeholder = "Nome" maxlength = "100" value = "<?php echo $_SESSION["nome"]; ?>">			  
         </div>
		 
                  <label for="inputEmail" class="col-lg-2 control-label">E-mail:</label>
				  
         <div class="col-lg-9">
                  <input type="text" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100" value = "<?php echo $_SESSION["email"]; ?>">  
         </div>
		
                  <label for="inputNivel" class="col-lg-2 control-label">Nível de acesso:</label>
		<div class="col-lg-9">
			<select class="form-control" id="nivel_acesso" value = "<?php echo $_SESSION["nivel_acesso"]; ?>">
				<option value="1">1</option>
				<option value="2">2</option>
			</select>
		</div>
		
         <div class="col-lg-9 col-lg-offset-2">
		 <br>
                       <button style="margin-left: 5px; float:right;" type="submit" name = "alterar_dados_admin" class="btn btn-primary">Salvar Alterações</button>
					   <button style="float:right;" type = "reset" name="cancelar" class="btn btn-default">Cancelar</button>
        </div>
		</div>
      </fieldset>
    </form>
</article>
</div>