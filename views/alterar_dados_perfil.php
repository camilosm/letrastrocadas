<?php
	// Verifica se o botão foi acionado
	if(isset($_POST['alterarDados']))
	{
		include("classes/class_banco.php");
		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();
		include("alterar_dados_perfil_n.php");
		
	}
?>

<article id  = "alterar_dados_perfil" style = "width: 80%; margin-left: 10%;">

	<form class="form-horizontal" method = "post" action = "">
		<fieldset>

			<legend>Alterar dados</legend>

			<section class="form-group">

				<label for="inputNome" class="col-lg-2 control-label">Nome</label>

				<section class="col-lg-10">	 
					<input type="text" class="form-control"  name = "nome" id="nome" required placeholder = "Nome" maxlength = "100">			  
				</section>

				<label for="inputDataNasc" class="col-lg-2 control-label">Data Nascimento</label>

				<section class="col-lg-10">
					<input type="date" class="form-control" name = "data_nascimento" id="data_nascimento" required placeholder = "DataNascimento">		  
				</section>
				
				<label for="inputGeneroFav" class="col-lg-2 control-label">Gênero favorito</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" name = "genero" id="genero" required maxlength = "100" placeholder = "Digite aqui os gêneros literários que você mais gosta de ler">		  
				</section>

				<label for="inputRua" class="col-lg-2 control-label">Rua</label>

				<section class="col-lg-10">
					<input type="text" class="form-control" name = "logradouro" id="logradouro" required maxlength = "100" placeholder = "Rua">		  
				</section>

				<label for="inputNumero" class="col-lg-2 control-label">Número</label>

				<section class="col-lg-10">
					<input type="number" class="form-control" name = "numero" id="numero" required placeholder = "Número">		  
				</section>
		
				<label for="inputBairro" class="col-lg-2 control-label">Bairro</label>

				<section class="col-lg-10">
					<input type="text" class="form-control" name = "bairro" id="bairro" required maxlength = "100" placeholder = "Bairro">		  
				</section>

				<label for="inputUF" class="col-lg-2 control-label">UF</label>
				<section class="col-lg-10">
					<select class="form-control" id="inputUF" name = "uf">
						<option>Selecione um estado...</option>
						<option>AC</option>
						<option>AC</option>
						<option>AL</option>
						<option>AP</option>
						<option>AM</option>
						<option>BA</option>
						<option>CE</option>
						<option>DF</option>
						<option>ES</option>
						<option>GO</option>
						<option>MA</option>
						<option>MT</option>
						<option>MS</option>
						<option>MG</option>
						<option>PA</option>
						<option>PB</option>
						<option>PR</option>
						<option>PE</option>
						<option>PI</option>
						<option>RJ</option>
						<option>RN</option>
						<option>RS</option>
						<option>RO</option>
						<option>RR</option>
						<option>SC</option>
						<option>SP</option>
						<option>SE</option>
						<option>TO</option>
					</select>
				</section>
				
				<label for="inputCidade" class="col-lg-2 control-label">Cidade</label>

				<section class="col-lg-10">
					<input type="text" class="form-control" name = "cidade" id="inputCidade" required maxlength = "100" placeholder = "Cidade">		  
				</section>

				<label for="inputComplemento" class="col-lg-2 control-label">Complemento</label>
				
				<section class="col-lg-10">
					<input type="text" class="form-control" name = "complemento" id="complemento" required placeholder = "Complemento" maxlength = "100">
				</section>

				<label for="inputCEP" class="col-lg-2 control-label">CEP</label>
				
				<section class="col-lg-10">
					<input type="text" class="form-control" name = "cep" id="cep" required placeholder = "CEP" maxlength = "9">
				</section>

				<section class="col-lg-10 col-lg-offset-2">
					<br>
					<button type = "reset "class="btn btn-default">Cancelar</button>
					<button type="submit" name = "alterarDados" class="btn btn-primary">Salvar</button>
				</section>
				
			
			</section>

		</fieldset>
	</form>
</article>