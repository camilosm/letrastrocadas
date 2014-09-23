<script type="text/javascript" >
	$(function () {

		/* 
		* Gênero Favoritos
		*/ 

		function removeGenerosF() {
			$(".removerGenerosF").bind("click", function () {
				i=0; $(".generosF p.camposGenerosF").each(function () { 
					i++; 
				});
				if (i>1) { 
					$(this).parent().remove(); 
				} 
			}); 
		} 

		removeGenerosF();
		$(".adicionarGeneroF").click(function () {
			novoCampo = $(".generosF p.camposGenerosF:first").clone();
			novoCampo.find("input").val(""); 
			novoCampo.insertAfter(".generosF p.camposGenerosF:last");
			removeGenerosF();
		}); 

		/* 
		* Gênero Desagradáveis
		*/ 

		function removeGenerosD() {
			$(".removerGenerosD").bind("click", function () {
				is=0; $(".generosD p.camposGenerosD").each(function () { 
					is++; 
				});
				if (is>1) { 
					$(this).parent().remove(); 
				} 
			}); 
		} 

		removeGenerosD();
		$(".adicionarGeneroD").click(function () {
			novoCampo = $(".generosD p.camposGenerosD:first").clone();
			novoCampo.find("input").val(""); 
			novoCampo.insertAfter(".generosD p.camposGenerosD:last");
			removeGenerosD();
		}); 

		/* 
		* Autores Favoritos
		*/ 

		function removeAutoresF() {
			$(".removerAutoresF").bind("click", function () {
				i=0; $(".autoresF p.camposAutoresF").each(function () { 
					i++; 
				});
				if (i>1) { 
					$(this).parent().remove(); 
				} 
			}); 
		} 

		removeAutoresF();
		$(".adicionarAutoresF").click(function () {
			novoCampo = $(".autoresF p.camposAutoresF:first").clone();
			novoCampo.find("input").val(""); 
			novoCampo.insertAfter(".autoresF p.camposAutoresF:last");
			removeAutoresF();
		}); 

		/* 
		* Autores Chatos
		*/ 

		function removeAutoresC() {
			$(".removerAutoresC").bind("click", function () {
				i=0; $(".autoresC p.camposAutoresC").each(function () { 
					i++; 
				});
				if (i>1) { 
					$(this).parent().remove(); 
				} 
			}); 
		} 

		removeAutoresC();
		$(".adicionarAutoresC").click(function () {
			novoCampo = $(".autoresC p.camposAutoresC:first").clone();
			novoCampo.find("input").val(""); 
			novoCampo.insertAfter(".autoresC p.camposAutoresC:last");
			removeAutoresC();
		}); 
	});

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
	function PegarCep()
	{
		var cep = $('#cep').val();

		$.ajax({				
			url : 'http://cep.correiocontrol.com.br/'+ cep +'.json',
			dataType : 'json',
			success : function(data){
				alert(data.localidade);
				$('#inputCidade').attr({'value': data.localidade, 'text' : data.localidade});	
				$('#logradouro').attr({'value': data.logradouro, 'text' : data.logradouro});
				$('#bairro').attr({'value': data.bairro, 'text' : data.bairro});
				$('#inputUF').attr({'value': data.uf, 'text' : data.uf});
									
			},
			error : function(data){
			alert('Ops! Ocorreu um erro na verificação do cep. Confira se o cep está no formado correto (Só números).');
			$('#cep').focus();
			}
		});
	}
</script>
<?php
	
	include("classes/class_pesquisar.php");
	include("classes/class_insert.php");
	include("classes/class_banco.php");
	
	//Instancia e faz conexão com o banco de dados
	$banco = new Banco();
	
	$id = $_SESSION['id'];
	
	/*if(isset($_POST['alterarDados']))
	{
		include("alterar_dados_perfil_n.php");
	}*/
	
	//Pega os dados para mostrar no formulário
		
	$pesquisa_dados = new Pesquisar("tbl_usuario","data_nasc,foto,nome,logradouro,cidade,bairro,cep,uf,complemento,numero"," id_usuario = $id;");
	$resultado_pesquisa_dados = $pesquisa_dados->pesquisar();
	$dados_usu = mysql_fetch_assoc($resultado_pesquisa_dados);
	
	$pesquisa_generos = new Pesquisar("tbl_categoria","*"," 1=1 GROUP BY nome ASC");
	$resul_pesq_genero = $pesquisa_generos->pesquisar();
	$resul_pesq_generoD = $pesquisa_generos->pesquisar();
	
	$pesquisar_autor = new Pesquisar("tbl_autor","*","1=1 GROUP BY nome ASC");
	$resultado_autor = $pesquisar_autor->pesquisar();
	$resultado_autorC = $pesquisar_autor->pesquisar();
	
	$pesquisa_estado = new Pesquisar("tbl_estados","*"," 1=1");
	$resul_pesq_estado = $pesquisa_estado->pesquisar();
	$estados = mysql_fetch_assoc($resul_pesq_estado);
	
	$foto_p = $dados_usu["foto"];
	$nome_p = $dados_usu["nome"];
	$data_nasc_p = $dados_usu["data_nasc"];
	$logradouro_p = $dados_usu["logradouro"];
	$numero_p = $dados_usu["numero"];
	$cep_p = $dados_usu["cep"];
	$uf_p = $dados_usu["uf"];
	$complemento_p = $dados_usu["complemento"];
	$cidade_p = $dados_usu["cidade"];
	$bairro_p = $dados_usu["bairro"];
	
	
	$foto = $foto_p != "" ? $foto_p : "content/imagens/fotos_perfil/avatar-250.png";
	// Verifica se o botão foi acionado

	$genero = $_POST['genero'];
	$quantidade = count($genero);
	for ($i=0; $i<$quantidade; $i++) 
	{ 
		if($genero[$i] != "Escolha o seu gênero favorito...")
		{
			$pes_genero_fav = new Pesquisar('tbl_generos_favoritos','*','categoria_id ='.$genero[$i].' AND usuario_id = '.$_SESSION['id']);
			$res_genero_fav = $pes_genero_fav->pesquisar();
			$qt_genero_fav = mysql_num_rows($res_genero_fav);
			if($qt_genero_fav == 0)
			{
				$ins_genero_fav = new Inserir('tbl_generos_favoritos','NULL,'.$genero[$i].','.$_SESSION['id']);
				$res_genero_fav = $ins_genero_fav->inserir();
			}
		}
	}

	$autor = $_POST['autor'];
	$quantidade = count($autor);
	for ($i=0; $i<$quantidade; $i++) 
	{ 
		if($autor[$i] != "Escolha o seu autor favorito...")
		{
			$pes_autor_fav = new Pesquisar('tbl_autores_favoritos','*','autor_id ='.$autor[$i].' AND usuario_id = '.$_SESSION['id']);
			$res_autor_fav = $pes_autor_fav->pesquisar();
			$qt_autor_fav = mysql_num_rows($res_autor_fav);
			if($qt_autor_fav == 0)
			{
				$ins_autor_fav = new Inserir('tbl_autores_favoritos','NULL,'.$autor[$i].','.$_SESSION['id']);
				$res_autor_fav = $ins_autor_fav->inserir();
			}
		}
	}

	$generoD = $_POST['generoD'];
	$quantidade = count($generoD);
	for ($i=0; $i<$quantidade; $i++) 
	{ 
		if(($generoD[$i] != "Escolha um gênero que você não gosta...") AND ($generoD[$i] != "Nenhum"))
		{
			$pes_genero_des = new Pesquisar('tbl_generos_desapreciados','*','genero_id ='.$generoD[$i].' AND usuario_id = '.$_SESSION['id']);
			$res_genero_des = $pes_genero_des->pesquisar();
			$qt_genero_des = mysql_num_rows($res_genero_des);
			if($qt_genero_des == 0)
			{
				$ins_genero_des = new Inserir('tbl_generos_desapreciados','NULL,'.$generoD[$i].','.$_SESSION['id']);
				$res_genero_des = $ins_genero_des->inserir();
			}
		}
	}

	$autorC = $_POST['autorC'];
	$quantidade = count($autorC);
	for ($i=0; $i<$quantidade; $i++) 
	{ 
		if(($autorC[$i] != "Escolha um autor que você não gosta...") AND ($autorC[$i] != "Nenhum"))
		{
			$pes_autor_cha = new Pesquisar('tbl_autores_desapreciados','*','autor_id ='.$autorC[$i].' AND usuario_id = '.$_SESSION['id']);
			$res_autor_cha = $pes_autor_cha->pesquisar();
			$qt_autor_cha = mysql_num_rows($res_autor_cha);
			if($qt_autor_cha == 0)
			{
				$ins_autor_cha = new Inserir('tbl_autores_desapreciados','NULL,'.$autorC[$i].','.$_SESSION['id']);
				$res_autor_cha = $ins_autor_cha->inserir();
			}
		}
	}
	
?>
<form name="frm_upload" id="frm_upload" class="form-horizontal" enctype="multipart/form-data" method="post" action="">
	<article id  = "alterar_dados_perfil" style = "width: 80%; margin-left: 10%;">
		<fieldset>
			<legend>Alterar dados</legend>
			<section class="form-group">	
		        <label class="col-md-2 control-label">Se deseja alterar <br> sua foto de perfil,<br> clique na imagem.</label>
				<img alt="" id="img_perfil" class = "thumbnail" style="cursor:pointer;" onclick="$('#file').click();" src = "<?=$foto?>">
				<input type="text" value = "<?=$foto?>" style="visibility:hidden;" name="caminho" id="caminho" class="btn btn-primary btn-sm"/>
				<input type="file" style="visibility:hidden;" name="file" onchange="UploadFoto();" id="file" class="btn btn-primary btn-sm"/>
			</section>
			<section class="form-group">
				<label for="inputEmail" class="col-md-2 control-label">E-mail</label>
				<section class="col-md-10">	 
					<input type="text" class="form-control"  name = "email" id="email" required  placeholder = "E-mail" maxlength = "100" value = "<?php echo utf8_encode($_SESSION["email"]); ?>">			  
				</section>
				<label for="inputNome" class="col-md-2 control-label">Nome</label>
				<section class="col-md-10">	 
					<input type="text" class="form-control"  name = "nome" id="nome" required  placeholder = "Nome"  maxlength = "100" value = "<?php echo utf8_encode($nome_p); ?>">			  
				</section>
				<label for="inputDataNasc" class="col-md-2 control-label">Data Nascimento</label>
				<section class="col-md-10">
					<input type="date" class="form-control" name = "data_nascimento" id="data_nascimento" required value = "<?php echo $dados_usu["data_nasc"]; ?>">		  
				</section>	
				<label for="inputRua" class="col-md-2 control-label">Rua</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "logradouro" id="logradouro" required maxlength = "100" placeholder = "Rua" value = "<?php echo utf8_encode($logradouro_p); ?>">		  
				</section>
				<label for="inputNumero" class="col-md-2 control-label">Número</label>
				<section class="col-md-10">
					<input type="number" class="form-control" name = "numero" id="numero" required min = "1" placeholder = "Número" value = "<?php echo $numero_p; ?>">		  
					</section>
				<label for="inputBairro" class="col-md-2 control-label">Bairro</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "bairro" id="bairro" required maxlength = "100" placeholder = "Bairro" value = "<?php echo utf8_encode($bairro_p); ?>">		  
				</section>
				<label for="inputUF" class="col-md-2 control-label">UF</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "inputUF" id="inputUF" required maxlength = "100" placeholder = "UF" value = "<?php echo utf8_encode($uf_p); ?>">
				</section>
				<label for="inputCidade" class="col-md-2 control-label">Cidade</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "cidade" id="inputCidade" required maxlength = "100" placeholder = "Cidade" value = "<?php echo utf8_encode($cidade_p); ?>">		  
				</section>
				<label for="inputComplemento" class="col-md-2 control-label">Complemento</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "complemento" id="complemento" required placeholder = "Complemento" maxlength = "100" value = "<?php echo utf8_encode($complemento_p); ?>">
				</section>
				<label for="inputCEP" class="col-md-2 control-label">CEP</label>
				<section class="col-md-10">
					<input type="text" class="form-control" onblur = "PegarCep()" name = "cep" id="cep" required placeholder = "CEP" maxlength = "9" value = "<?php echo utf8_encode($cep_p); ?>">
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Gêneros Favoritos: &nbsp;&nbsp; <a class="adicionarGeneroF" title="Clique para adicionar mais um gênero"><button type="button" name="plus" id="plus"><span class="glyphicon glyphicon-plus"></span></button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<section class="generosF"> 
								<p class="camposGenerosF">
									<select type="text" class="form-control" name = "genero[]" id="genero" required>	
											<?php 
												if ($genero_fav_p == "")
												{
													echo '<option> Escolha o seu gênero favorito... </option>';
													while ($generos = mysql_fetch_assoc($resul_pesq_genero))
													{
														echo '<option value = "'.$generos["id_categoria"].'">' .utf8_encode($generos["nome"]). '</option>';						
													}
												}
												else
												{
													while ($generos = mysql_fetch_assoc($resul_pesq_genero))
													{
														$selected = $genero_fav_p == $generos["nome"] ? 'selected="selected"' : '' ;
												    	echo '<option '. $selected .' value = "'.$generos["id_categoria"].'" >' .utf8_encode($generos["nome"]). '</option>';					
													}
												}
											?>				
									</select>
									<a class="removerGenerosF" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
								</p>
							</section>
						</section>
					</fieldset>
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Autores Favoritos: &nbsp;&nbsp; <a class="adicionarAutoresF" title="Clique para adicionar mais um autor"><button type="button" name="plus" id="plus"><span class="glyphicon glyphicon-plus"></span></button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<section class="autoresF"> 
								<p class="camposAutoresF">
									<select type="text" class="form-control" name = "autor[]" id="autor" required>	
											<?php 
												echo "<option> Escolha o seu autor favorito...</option>";
												while($dados_autor = mysql_fetch_assoc($resultado_autor))
												{
													echo "<option value = ".$dados_autor['id_autor'].">".utf8_encode($dados_autor['nome'])."</option>";
												}
											?>				
									</select>
									<a class="removerAutoresF" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
								</p>
							</section>
						</section>
					</fieldset>
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Gêneros Desagradáveis: &nbsp;&nbsp; <a class="adicionarGeneroD" title="Clique para adicionar mais um gênero"><button type="button" name="plus" id="plus"><span class="glyphicon glyphicon-plus"></span></button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<section class="generosD"> 
								<p class="camposGenerosD">
									<select type="text" class="form-control" name = "generoD[]" id="generoD" required>	
											<?php 
												if ($genero_fav_p == "")
												{
													echo '<option> Escolha um gênero que você não gosta... </option>';
													echo '<option> Nenhum </option>';
													while ($generos = mysql_fetch_assoc($resul_pesq_generoD))
													{
														echo '<option value = "'.$generos['id_categoria'].'">' .utf8_encode($generos["nome"]). '</option>';						
													}
												}
												else
												{
													echo '<option> Nenhum </option>';
													while ($generos = mysql_fetch_assoc($resul_pesq_generoD))
													{
														$selected = $genero_fav_p == $generos["nome"] ? 'selected="selected"' : '' ;
														echo '<option '. $selected .' value = "'.$generos['id_categoria'].'">' .utf8_encode($generos["nome"]). '</option>';					
													}
												}
											?>				
									</select>
									<a class="removerGenerosD" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
								</p>
							</section>
						</section>
					</fieldset>
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Autores Chatos: &nbsp;&nbsp; <a class="adicionarAutoresC" title="Clique para adicionar mais um autor"><button type="button" name="plus" id="plus"><span class="glyphicon glyphicon-plus"></span></button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<section class="autoresC"> 
								<p class="camposAutoresC">
									<select type="text" class="form-control" name = "autorC[]" id="autorC" required>	
											<?php 
												echo "<option> Escolha um autor que você não gosta...</option>";
												echo '<option> Nenhum </option>';
												while($dados_autor = mysql_fetch_assoc($resultado_autorC))
												{
													echo "<option value = ".$dados_autor['id_autor'].">".utf8_encode($dados_autor['nome'])."</option>";
												}
											?>				
									</select>
									<a class="removerAutoresC" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
								</p>
							</section>
						</section>
					</fieldset>
				</section>
				<section class="col-md-10 col-md-offset-2">
					<br>
					<input type = "reset" value="Limpar"class="btn btn-default"/>
					<button type="submit" name = "alterarDados" class="btn btn-primary">Salvar</button>
				</section>
			</section>
		</fieldset>	
	</article>
</form>