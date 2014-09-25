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
	
	if(isset($_POST['alterarDados']))
	{
		include("alterar_dados_perfil_n.php");
	}
	
	//Pega os dados para mostrar no formulário
		
	$pesquisa_dados = new Pesquisar("tbl_usuario","data_nasc,foto,nome,logradouro,cidade,bairro,cep,uf,complemento,numero"," id_usuario = $id;");
	$resultado_pesquisa_dados = $pesquisa_dados->pesquisar();
	$dados_usu = mysql_fetch_assoc($resultado_pesquisa_dados);
	
	$pesquisa_generos = new Pesquisar("tbl_categoria","*"," 1=1 GROUP BY nome ASC");
	$resul_pesq_genero = $pesquisa_generos->pesquisar();
	
	$pesquisar_autor = new Pesquisar('tbl_autor','*','1=1 GROUP BY nome ASC');
	$resultado_autor = $pesquisar_autor->pesquisar();

	$pesquisa_generos_fav = new Pesquisar('tbl_generos_favoritos','*',"usuario_id = $id");
	$res_genero_fav = $pesquisa_generos_fav->pesquisar();

	$pesquisa_autor_fav = new Pesquisar('tbl_autores_favoritos','*',"usuario_id = $id");
	$res_autor_fav = $pesquisa_autor_fav->pesquisar();

	$pesquisa_generos_des = new Pesquisar('tbl_generos_desapreciados','*',"usuario_id = $id");
	$res_genero_des = $pesquisa_generos_des->pesquisar();

	$pesquisa_autor_des = new Pesquisar('tbl_autores_desapreciados','*',"usuario_id = $id");
	$res_autor_des = $pesquisa_autor_des->pesquisar();
	
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

	$generos_id = array();
	$generos_nome = array();
	while ($generos = mysql_fetch_assoc($resul_pesq_genero))
	{
		$generos_id[] = $generos['id_categoria'];
		$generos_nome[] = $generos['nome'];
	}

	$qt_gen = count($generos_id);

	$autor_id = array();
	$autor_nome = array();
	while ($autores = mysql_fetch_assoc($resultado_autor))
	{
		$autor_id[] = $autores['id_autor'];
		$autor_nome[] = $autores['nome'];
	}

	$qt_aut = count($autor_id);
	
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
					<input type="text" class="form-control" name = "complemento" id="complemento" placeholder = "Complemento" maxlength = "100" value = "<?php echo utf8_encode($complemento_p); ?>">
				</section>
				<label for="inputCEP" class="col-md-2 control-label">CEP</label>
				<section class="col-md-10">
					<input type="text" class="form-control" onblur = "PegarCep()" name = "cep" id="cep" required placeholder = "CEP" maxlength = "9" value = "<?php echo utf8_encode($cep_p); ?>">
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Gêneros Favoritos: &nbsp;&nbsp; <a class="adicionarGeneroF" style="color:grey" title="Clique para adicionar mais um gênero"><button type="button" name="plus" id="plus">+</button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<?php
								$ct_gen_fav = 0;
								while($generos_usu = mysql_fetch_assoc($res_genero_fav))
								{
									$ct_gen_fav++;
							    	for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$selected = $generos_usu["categoria_id"] == $generos_id[$i] ? 'selected="selected"' : '' ;
							    		$conteudo .= '<option '. $selected .' value = "'.$generos_usu["categoria_id"].'" >' .utf8_encode($generos_nome[$i]). '</option>';
							    	}
									echo '
										<section class="generosF"> 
											<p class="camposGenerosF">
												<select type="text" class="form-control"  name = "genero[]" id="genero" required>	
													'.$conteudo.'
												</select>
												<a class="removerGenerosF" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									';
								}
								if($ct_gen_fav == 0)
								{
									$conteudo = '<option> Escolha o seu gênero favorito ...</option>';
									for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$conteudo .= '<option '. $selected .' value = "'.$generos_usu["categoria_id"].'" >' .utf8_encode($generos_nome[$i]). '</option>';
							    	}
									echo '

										<section class="generosF"> 
											<p class="camposGenerosF">
												<select type="text" class="form-control"  name = "genero[]" id="genero" required>
													'.$conteudo.'
												</select>
												<a class="removerGenerosF" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									</section>
									';
								}
							?>
					</fieldset>
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Autores Favoritos: &nbsp;&nbsp; <a class="adicionarAutoresF" style="color:grey" title="Clique para adicionar mais um autor"><button type="button" name="plus" id="plus">+</button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">	
							<?php
								$ct_aut_fav = 0;
								while($autor_usu = mysql_fetch_assoc($res_autor_fav))
								{
									$ct_aut_fav++;
							    	for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$selected = $autor_usu["autor_id"] == $autor_id[$i] ? 'selected="selected"' : '' ;
							    		$conteudo .= '<option '. $selected .' value = "'.$autor_usu["autor_id"].'" >' .utf8_encode($autor_nome[$i]). '</option>';
							    	}
									echo '
										<section class="autoresF"> 
											<p class="camposAutoresF">
												<select type="text" class="form-control"  name = "autor[]" id="autor" required>	
													'.$conteudo.'
												</select>
												<a class="removerAutoresF" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									';
								}
								if($ct_aut_fav == 0)
								{
									$conteudo = '<option> Escolha o seu autor favorito ...</option>';
									for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$conteudo .= '<option '. $selected .' value = "'.$autor_usu["autor_id"].'" >' .utf8_encode($autor_nome[$i]). '</option>';
							    	}
									echo '

										<section class="generosF"> 
											<p class="camposGenerosF">
												<select type="text" class="form-control"  name = "autor[]" id="autor" required>
													'.$conteudo.'
												</select>
												<a class="removerGenerosF" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									</section>
									';
								}
							?>
						</section>
					</fieldset>
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Gêneros Desagradáveis: &nbsp;&nbsp; <a class="adicionarGeneroD" style="color:grey" title="Clique para adicionar mais um gênero"><button type="button" name="plus" id="plus">+</button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<?php
								$ct_gen_des = 0;
								while($gen_des_usu = mysql_fetch_assoc($res_genero_des))
								{
									$ct_gen_des++;
									$conteudo = '<option> Escolha um gênero que você não gosta ...</option>';
							    	for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$selected = $gen_des_usu["genero_id"] == $generos_id[$i] ? 'selected="selected"' : '' ;
							    		$conteudo .= '<option '. $selected .' value = "'.$gen_des_usu["genero_id"].'" >' .utf8_encode($generos_nome[$i]). '</option>';
							    	}
									echo '
										<section class="generosD"> 
											<p class="camposGenerosD">
												<select type="text" class="form-control"  name = "generoD[]" id="generoD" required>	
													'.$conteudo.'
												</select>
												<a class="removerGenerosD" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									';
								}
								if($ct_gen_des == 0)
								{
									$conteudo = '<option> Escolha um gênero que você não gosta...</option>';
									for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$conteudo .= '<option '. $selected .' value = "'.$gen_des_usu["autor_id"].'" >' .utf8_encode($autor_nome[$i]). '</option>';
							    	}
									echo '

										<section class="generosD"> 
											<p class="camposGenerosD">
												<select type="text" class="form-control"  name = "generoD[]" id="generoD" required>
													'.$conteudo.'
												</select>
												<a class="removerGenerosD" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									</section>
									';
								}
							?>
						</section>
					</fieldset>
				</section>
				<section class="col-md-12">
					<br>
					<fieldset>
						<legend>Autores Chatos: &nbsp;&nbsp; <a class="adicionarAutoresC" style="color:grey" title="Clique para adicionar mais um autor"><button type="button" name="plus" id="plus">+</button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<?php
								$ct_aut_fav = 0;
								while($autor_des_usu = mysql_fetch_assoc($res_autor_des))
								{
									$ct_aut_fav++;
									$conteudo = '<option> Escolha um autor que você não gosta ...</option>';
							    	for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$selected = $autor_des_usu["autor_id"] == $autor_id[$i] ? 'selected="selected"' : '' ;
							    		$conteudo .= '<option '. $selected .' value = "'.$autor_des_usu["autor_id"].'" >' .utf8_encode($autor_nome[$i]). '</option>';
							    	}
									echo '
										<section class="autoresC"> 
											<p class="camposAutoresC">
												<select type="text" class="form-control"  name = "autorC[]" id="autor" required>	
													'.$conteudo.'
												</select>
												<a class="removerAutoresC" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									';
								}
								if($ct_aut_fav == 0)
								{
									$conteudo = '<option> Escolha um autor que você não gosta...</option>';
									for($i=0;$i<$qt_gen;$i++)
							    	{
							    		$conteudo .= '<option '. $selected .' value = "'.$autor_des_usu["autor_id"].'" >' .utf8_encode($autor_nome[$i]). '</option>';
							    	}
									echo '

										<section class="autoresC"> 
											<p class="camposAutoresC">
												<select type="text" class="form-control"  name = "autorC[]" id="autorC" required>
													'.$conteudo.'
												</select>
												<a class="removerAutoresC" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>
									</section>
									';
								}
							?>
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