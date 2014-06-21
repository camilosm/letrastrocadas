<section id  = "body_contato" style = "width:60%;position:relative;left:20%;">

         <form class="form-horizontal" method = "post" action = "">
            <fieldset id = "legend_senha">
			
                  <legend>Contato</legend>
				  
		         <section class="form-group">
		 
                  <label for="inputNome" class="col-lg-2 control-label">Nome</label>
				  
         <section class="col-lg-10">
                  <input type="text" class="form-control" id="inputNome" required maxlength = "100" placeholder = "Nome">			  
         </section>
                  <label for="inputAssunto" class="col-lg-2 control-label">Assunto</label>		  
         <section class="col-lg-10">
                  <input type="text" class="form-control" id="inputAssunto" required placeholder = "Assunto" maxlength = "100">	  
         </section>
		 <br>
                <label for="textArea" class="col-lg-2 control-label">Texto</label>
				
         <section class="col-lg-10">
                <textarea class="form-control" rows="3" id="textArea" placeholder = "Escreva aqui o que deseja"></textarea> 
         </section>
		 <br>
         <section class="col-lg-10 col-lg-offset-2">
		 <br>
                       <button style="margin-left: 5px; float:right;" type = "reset "class="btn btn-default">Cancelar</button>
                       <button style="float:right;" type="submit" class="btn btn-primary">Enviar</button>
        </section>
        </section>
			
           </fieldset>
    </form>
</section>