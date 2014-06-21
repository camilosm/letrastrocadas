<article style="width: 60%; margin-left: 20%;">	
	<form class="form-horizontal" method = "post" action = "?url=cadastro_usuario">
		<fieldset>

			<legend>Esqueceu senha</legend>

			<section class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				<section class="col-lg-10">	 
					<input type="email" class="form-control"  name = "email" id="email" required placeholder = "Digite seu e-mail" maxlength = "100">			  
					<br>
				</section>
				
				<section class="col-lg-10 col-lg-offset-2">
						<span style="float: right;">
							<button type = "reset" class="btn btn-default">Limpar</button>
							<button type="submit" name = "enviar" class="btn btn-primary">Enviar</button>
						</span>
				</section>
			</section>
		</fieldset>
	</form>
</article>