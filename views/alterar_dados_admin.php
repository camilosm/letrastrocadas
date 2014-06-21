<article id  = "alterar_dados_perfil" style = "position:relative;width:40%;height:20%;left:30%;">

    <form class="form-horizontal" method = "post" action = "?url=alterar_dados_admin">
            <fieldset>
			
                  <legend>Alterar Dados Administrador</legend>
				  
      <div class="form-group">
		 
                  <label for="inputNome" class="col-lg-2 control-label">Nome</label>
				  
         <div class="col-lg-10">	 
                  <input type="text" class="form-control"  name = "nome" id="nome" required placeholder = "Nome" maxlength = "100">			  
         </div>
		 
                  <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				  
         <div class="col-lg-10">
                  <input type="text" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100">  
         </div>
		
                  <label for="inputNivel" class="col-lg-2 control-label">Nível de acesso</label>
		<div class="col-lg-10">
			<select class="form-control" id="nivel_acesso">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
		
         <div class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button type = "reset " class = "btn btn-default">Cancelar</button>
                       <button type = "submit" name = "Salvar" class="btn btn-primary">Salvar</button>
        </div>
		</div>
			
           </fieldset>
    </form>
</article>