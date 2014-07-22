<?php
	
	session_start();
	
	include("classes/class_pesquisar.php");
	include("classes/class_banco.php");
	
	//Instancia e faz conexão com o banco de dados
	$banco = new Banco();
	
	$id = $_SESSION['id'];
	
	if(isset($_POST['alterarDados']))
	{
		include("alterar_dados_perfil_n.php");
	}
	
	//Pega os dados para mostrar no formulário
		
	$pesquisa_dados = new Pesquisar("tbl_usuario","data_nasc,foto,nome,genero_favorito,logradouro,cidade,bairro,cep,uf,complemento,numero"," id_usuario = $id;");
	$resultado_pesquisa_dados = $pesquisa_dados->pesquisar();
	$dados_usu = mysql_fetch_assoc($resultado_pesquisa_dados);
	
	$pesquisa_generos = new Pesquisar("tbl_categoria","*"," 1=1 GROUP BY nome ASC");
	$resul_pesq_genero = $pesquisa_generos->pesquisar();
	$generos = mysql_fetch_assoc($resul_pesq_genero);
	
	$pesquisa_estado = new Pesquisar("tbl_estados","*"," 1=1");
	$resul_pesq_estado = $pesquisa_estado->pesquisar();
	$estados = mysql_fetch_assoc($resul_pesq_estado);
	
	$foto_p = $dados_usu["foto"];
	$nome_p = $dados_usu["nome"];
	$data_nasc_p = $dados_usu["data_nasc"];
	$genero_fav_p = $dados_usu["genero_favorito"];
	$logradouro_p = $dados_usu["logradouro"];
	$numero_p = $dados_usu["numero"];
	$cep_p = $dados_usu["cep"];
	$uf_p = $dados_usu["uf"];
	$complemento_p = $dados_usu["complemento"];
	$cidade_p = $dados_usu["cidade"];
	$bairro_p = $dados_usu["bairro"];
	
	
	$foto = $foto_p != "" ? $foto_p : "content/imagens/fotos_perfil/avatar-250.png";
	// Verifica se o botão foi acionado
	
?>
<script>
	var UploadFoto = function()
	{	
		$("#frm_upload").ajaxSubmit(
			{
				url: 'ajax/upload.php', 
				type: 'post',					
				dataType  : "json",
				success : function( data ){RetornaImagem(data.caminho,data.caminho_a);},
				resetForm : false
			}
		);	
	}
	var RetornaImagem = function(caminho,outro){
		$.post("ajax/abre_imagem.php",{caminho : caminho}, function(data){
				$("#img_perfil").attr("src", data.imagem);
				$("#caminho").attr("value", outro);
			}
		);
	}
</script>
<form name="frm_upload" id="frm_upload" class="form-horizontal" enctype="multipart/form-data" method="post" action="">
	<article id  = "alterar_dados_perfil" style = "width: 80%; margin-left: 10%;">
		<fieldset>

			<legend>Alterar dados</legend>

			<section class="form-group">	
		        <label class="col-lg-2 control-label">Se deseja alterar <br> sua foto de perfil,<br> clique na imagem.</label>
							<img alt="" id="img_perfil" class = "thumbnail" style="cursor:pointer;" onclick="$('#file').click();" src = "<?=$foto?>">
							<input type="text" value = "" style="visibility:hidden;" name="caminho" id="caminho" class="btn btn-primary btn-sm"/>
							<input type="file" style="visibility:hidden;" name="file" onchange="UploadFoto();" id="file" class="btn btn-primary btn-sm"/>

			</section>
			<section class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">E-mail</label>

				<section class="col-lg-10">	 
					<input type="text" class="form-control"  name = "email" id="email" required  placeholder = "E-mail" maxlength = "100" value = "<?php echo utf8_encode($_SESSION["email"]); ?>">			  
				</section>
				<label for="inputNome" class="col-lg-2 control-label">Nome</label>

				<section class="col-lg-10">	 
					<input type="text" class="form-control"  name = "nome" id="nome" required  placeholder = "Nome"  maxlength = "100" value = "<?php echo utf8_encode($nome_p); ?>">			  
				</section>

				<label for="inputDataNasc" class="col-lg-2 control-label">Data Nascimento</label>

				<section class="col-lg-10">
					<input type="date" class="form-control" name = "data_nascimento" id="data_nascimento" required value = "<?php echo $dados_usu["data_nasc"]; ?>">		  
				</section>
				
				<label for="inputGeneroFav" class="col-lg-2 control-label">Gênero favorito</label>
				<section class="col-lg-10">
					<select type="text" class="form-control" name = "genero" id="genero" required>	
							<?php 
							if ($genero_fav_p == "")
							{
							           echo '<option> Escolha um gênero... </option>';
							        	while ($generos = mysql_fetch_assoc($resul_pesq_genero)){
							        		echo '<option>' .utf8_encode($generos["nome"]). '</option>';						
							        }
							}
							else
							{
										while ($generos = mysql_fetch_assoc($resul_pesq_genero)){
										$selected = $genero_fav_p == $generos["nome"] ? 'selected="selected"' : '' ;
							    		echo '<option '. $selected .' >' .utf8_encode($generos["nome"]). '</option>';					
							        }
							}
							?>				
					</select>
				</section>

				<label for="inputRua" class="col-lg-2 control-label">Rua</label>

				<section class="col-lg-10">
					<input type="text" class="form-control" name = "logradouro" id="logradouro" required maxlength = "100" placeholder = "Rua" value = "<?php echo utf8_encode($logradouro_p); ?>">		  
				</section>

				<label for="inputNumero" class="col-lg-2 control-label">Número</label>

				<section class="col-lg-10">
					<input type="number" class="form-control" name = "numero" id="numero" required placeholder = "Número" value = "<?php echo $numero_p; ?>">		  
				</section>
		
				<label for="inputBairro" class="col-lg-2 control-label">Bairro</label>

				<section class="col-lg-10">
					<input type="text" class="form-control" name = "bairro" id="bairro" required maxlength = "100" placeholder = "Bairro" value = "<?php echo utf8_encode($bairro_p); ?>">		  
				</section>

				<label for="inputUF" class="col-lg-2 control-label">UF</label>
				<section class="col-lg-10">
					<select class="form-control" id="inputUF" name = "uf">
							<?php 
							
							if ($uf_p == "")
							{
								echo '<option> Selecione um estado... </option>';
									while ($estados = mysql_fetch_array($resul_pesq_estado)){
										echo '<option>' .$estados["nome"]. '</option>';
								
									}
							}
							else{							    
							    	while ($estados = mysql_fetch_array($resul_pesq_estado)){
										$selected = $uf_p == $estados["nome"] ? 'selected="selected"' : '' ;
							    		echo '<option '. $selected .' >' .$estados["nome"]. '</option>';
									}
							}
							?>						
					</select>
				</section>
				
				<label for="inputCidade" class="col-lg-2 control-label">Cidade</label>

				<section class="col-lg-10">
					<input type="text" class="form-control" name = "cidade" id="inputCidade" required maxlength = "100" placeholder = "Cidade" value = "<?php echo utf8_encode($cidade_p); ?>">		  
				</section>
				
				<label for="inputComplemento" class="col-lg-2 control-label">Complemento</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" name = "complemento" id="complemento" required placeholder = "Complemento" maxlength = "100" value = "<?php echo utf8_encode($complemento_p); ?>">
				</section>

				<label for="inputCEP" class="col-lg-2 control-label">CEP</label>
				
				<section class="col-lg-10">
					<input type="text" class="form-control" name = "cep" id="cep" required placeholder = "CEP" maxlength = "9" value = "<?php echo utf8_encode($cep_p); ?>">
				</section>

				<section class="col-lg-10 col-lg-offset-2">
					<br>
					<button type = "reset "class="btn btn-default">Cancelar</button>
					<button type="submit" name = "alterarDados" class="btn btn-primary">Salvar</button>
				</section>
				
			
			</section>

		</fieldset>	
	</article>
</form>