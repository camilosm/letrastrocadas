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
		include("classes/class_editar_caracteres.php");
		include("classes/class_update.php");
		include("classes/class_delete.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		$data_nasc = $_POST['data_nascimento'];
		$logradouro = $_POST['logradouro'];
		$numero = $_POST['numero'];
		$cep = $_POST['cep'];
		$uf = $_POST['inputUF'];
		$complemento = $_POST['complemento'];
		$cidade = $_POST['cidade'];
		$bairro = $_POST['bairro'];	
		$nova_imagem = $_POST['caminho'];
		$explode = explode('.',$nova_imagem);
		$imagem = $nova_imagem;
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
		//Instancia e passa os valores para a classe de Update 
		$valores_altera_dados_perfil = "nome = '" .utf8_decode($nome). "',
		status = 4,
		foto = '".$imagem."',
        data_nasc = '".$data_nasc."',
		logradouro = '".utf8_decode($logradouro)."',
		numero = ".$numero.",
		cep = '".$cep."',
		cidade = '".utf8_decode($cidade)."',
		bairro = '".utf8_decode($bairro)."',
		uf = '".$uf."',
		complemento = '".utf8_decode($complemento)."'";
		
		$condicao = "id_usuario =".$id."";
		$alterar_dados = new Alterar("tbl_usuario",$valores_altera_dados_perfil, $condicao);
		$resposta = $alterar_dados->alterar();

		//Pega um array com todos os gêneros favoritos que estavam na tela
		$genero = $_POST['genero'];
		$quantidade = count($genero);

		//Deleta todos os registros da tabela desse usuário
		$dlt_gen_fav = new Deletar('tbl_generos_favoritos','usuario_id = '.$_SESSION['id']);
		$res_del = $dlt_gen_fav->deletar(); 
		
		for ($i=0; $i<$quantidade; $i++) 
		{ 
			//Verifica se é uma opção válida para o cadastro
			if($genero[$i] != "Escolha o seu gênero favorito ...")
			{
				//Cadastra os gêneros que estão na tela
				$ins_genero_fav = new Inserir('tbl_generos_favoritos','NULL,'.$genero[$i].','.$_SESSION['id']);
				$res_genero_fav = $ins_genero_fav->inserir();
			}
		}

		//Pega um array com todos os autores favoritos que estavam na tela
		$autor = $_POST['autor'];
		$quantidade = count($autor);

		//Deleta todos os registros da tabela desse usuário
		$dlt_aut_fav = new Deletar('tbl_autores_favoritos','usuario_id = '.$_SESSION['id']);
		$res_del = $dlt_aut_fav->deletar(); 

		for ($i=0; $i<$quantidade; $i++) 
		{ 
			//Verifica se é uma opção válida para o cadastro
			if($autor[$i] != "Escolha o seu autor favorito ...")
			{
				//Cadastra os autores que estão na tela
				$ins_autor_fav = new Inserir('tbl_autores_favoritos','NULL,'.$autor[$i].','.$_SESSION['id']);
				$res_autor_fav = $ins_autor_fav->inserir();

			}
		}

		$generoD = $_POST['generoD'];
		$quantidade = count($generoD);

		//Deleta todos os registros da tabela desse usuário
		$dlt_gen_des = new Deletar('tbl_generos_desapreciados','usuario_id = '.$_SESSION['id']);
		$res_del = $dlt_gen_des->deletar(); 

		for ($i=0; $i<$quantidade; $i++) 
		{ 
			if(($generoD[$i] != "Escolha um gênero que você não gosta...") AND ($generoD[$i] != "Nenhum"))
			{
				$ins_genero_des = new Inserir('tbl_generos_desapreciados','NULL,'.$generoD[$i].','.$_SESSION['id']);
				$res_genero_des = $ins_genero_des->inserir();
				
			}
		}

		$autorC = $_POST['autorC'];
		$quantidade = count($autorC);

		//Deleta todos os registros da tabela desse usuário
		$dlt_aut_des = new Deletar('tbl_autores_desapreciados','usuario_id = '.$_SESSION['id']);
		$res_del = $dlt_aut_des->deletar(); 

		for ($i=0; $i<$quantidade; $i++) 
		{ 
			if(($autorC[$i] != "Escolha um autor que você não gosta...") AND ($autorC[$i] != "Nenhum"))
			{
				$ins_autor_cha = new Inserir('tbl_autores_desapreciados','NULL,'.$autorC[$i].','.$_SESSION['id']);
				$res_autor_cha = $ins_autor_cha->inserir();
			}
		}
		
		$idade = mysql_query("call calc_idade($id)");
	}
	
	//Pega os dados para mostrar no formulário
		
	$pesquisa_dados = new Pesquisar("tbl_usuario","data_nasc,foto,nome,logradouro,cidade,bairro,cep,uf,complemento,numero"," id_usuario = $id;");
	$resultado_pesquisa_dados = $pesquisa_dados->pesquisar();
	$dados_usu = mysql_fetch_assoc($resultado_pesquisa_dados);
	
	$pesquisa_generos = new Pesquisar("tbl_categoria","*"," 1=1 GROUP BY nome ASC");
	$resul_pesq_genero = $pesquisa_generos->pesquisar();
	
	$pesquisar_autor = new Pesquisar('tbl_autor','*','1=1 GROUP BY nome ASC');
	$resultado_autor = $pesquisar_autor->pesquisar();

	$pesquisa_generos_fav = new Pesquisar('tbl_generos_favoritos JOIN tbl_categoria ON id_categoria = categoria_id','*',"usuario_id = $id");
	$res_genero_fav = $pesquisa_generos_fav->pesquisar();

	$pesquisa_autor_fav = new Pesquisar('tbl_autores_favoritos JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id");
	$res_autor_fav = $pesquisa_autor_fav->pesquisar();

	$pesquisa_generos_des = new Pesquisar('tbl_generos_desapreciados JOIN tbl_categoria ON id_categoria = genero_id','*',"usuario_id = $id");
	$res_genero_des = $pesquisa_generos_des->pesquisar();

	$pesquisa_autor_des = new Pesquisar('tbl_autores_desapreciados JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id");
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

<article id  = "alterar_dados_perfil" class="col-sm-offset-1 col-sm-10">
	<form name="frm_upload" id="frm_upload" class="form-horizontal" enctype="multipart/form-data" method="post" action="">
		<fieldset>
			<legend>Alterar dados</legend>
			<section class="row">
				<section class="col-lg-4">
					<center><label>Se deseja alterar sua foto de perfil, clique na imagem.</label></center>
					<center><img alt="" id="img_perfil" class = "thumbnail" style="cursor:pointer;" onclick="$('#file').click();" src = "<?=$foto?>"></center>
					<input type="text" value = "<?=$foto?>" style="visibility:hidden;" name="caminho" id="caminho" class="btn btn-primary btn-sm"/>
					<input type="file" style="visibility:hidden;" name="file" onchange="UploadFoto();" id="file" class="btn btn-primary btn-sm"/>
				</section>
				<section class="col-lg-4">
					<section class="row">
						<label for="inputEmail" class="col-md-3 control-label">E-mail</label>
						<section class="col-md-9">	 
							<input type="text" class="form-control"  name = "email" id="email" required  placeholder = "E-mail" maxlength = "100" value = "<?php echo utf8_encode($_SESSION["email"]); ?>">			  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputNome" class="col-md-3 control-label">Nome</label>
						<section class="col-md-9">	 
							<input type="text" class="form-control"  name = "nome" id="nome" required  placeholder = "Nome"  maxlength = "100" value = "<?php echo utf8_encode($nome_p); ?>">			  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputDataNasc" class="col-md-6 control-label">Data Nascimento</label>
						<section class="col-md-6">
							<input type="date" class="form-control" name = "data_nascimento" id="data_nascimento" required value = "<?php echo $dados_usu["data_nasc"]; ?>">		  
						</section>
					</section>
				</section>
				
				<section class="col-lg-4">
					<section class="row">
						<label for="inputCEP" class="col-sm-2 control-label">CEP</label>
						<section class="col-sm-10">
							<input type="text" class="form-control" onblur = "PegarCep()" name = "cep" id="cep" required placeholder = "CEP" maxlength = "9" value = "<?php echo utf8_encode($cep_p); ?>">
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputRua" class="col-md-2 control-label">Rua</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "logradouro" id="logradouro" required maxlength = "100" placeholder = "Rua" value = "<?php echo utf8_encode($logradouro_p); ?>" readonly>		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputNumero" class="col-md-2 control-label">Número</label>
						<section class="col-md-10">
							<input type="number" class="form-control" name = "numero" id="numero" required min = "1" placeholder = "Número" value = "<?php echo $numero_p; ?>">		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputBairro" class="col-md-2 control-label">Bairro</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "bairro" id="bairro" required maxlength = "100" placeholder = "Bairro" value = "<?php echo utf8_encode($bairro_p); ?>" readonly>		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputUF" class="col-md-2 control-label">UF</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "inputUF" id="inputUF" required maxlength = "100" placeholder = "UF" value = "<?php echo utf8_encode($uf_p); ?>" readonly>
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputCidade" class="col-md-2 control-label">Cidade</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "cidade" id="inputCidade" required maxlength = "100" placeholder = "Cidade" value = "<?php echo utf8_encode($cidade_p); ?>" readonly>		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputComplemento" class="col-md-4 control-label">Complemento</label>
						<section class="col-md-8">
							<input type="text" class="form-control" name = "complemento" id="complemento" placeholder = "Complemento" maxlength = "100" value = "<?php echo utf8_encode($complemento_p); ?>">
						</section>
					</section>
				</section>
			</section>
			<br>
				<!-- 
					Gêneros Favoritos 
				-->
			<section class="row">			
				<section class="panel panel-default">
					<section class="panel-heading"><b>Gêneros Favoritos:</b> &nbsp;&nbsp; <a class="adicionarGeneroF" style="color:grey" title="Clique para adicionar mais um gênero"><button type="button" name="plus" class="btn" id="plus"><span class="glyphicon glyphicon-plus"></button></a></section>
					<section class="panel-body">
						<section class="col-sm-10 col-sm-offset-1">
							<section class="col-sm-6">
								<section class="panel panel-default">
									<section class="panel-heading"><b>Seus Gêneros Favoritos:</b> &nbsp;&nbsp;</section>
									<section class="panel-body">
										<section class="row">
											<section class="col-sm-6">
												<input id="1" type="checkbox" name="generos[]">
												<label for="1"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
											</section>
											<section class="col-sm-6">
												<input id="2" type="checkbox" name="generos[]">
												<label for="2"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
											</section>
										</section>
										<section class="row">
											<section class="col-sm-6">
												<input id="3" type="checkbox" name="generos[]">
												<label for="3"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
											</section>
											<section class="col-sm-6">
												<input id="4" type="checkbox" name="generos[]">
												<label for="4"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
											</section>
										</section>
										<section class="row">
											<button type="button" class="btn btn-primary center-block">Excluir</button>
										</section>
									</section>
								</section>
							</section>
							<section class="col-lg-6">
								<section class="row">
									<section class="col-md-9">
										<section class="input-group">
											<input type="text" name = "pesquisa" class="form-control" placeholder="Procurar">
											<span class="input-group-btn">
												<button type="submit" name = "pesquisar_livro" class="btn btn-default">
													<span class="glyphicon glyphicon-search"></span>
												</button>
											</span>
										</section>
									</section>
								</section>
								<section class="row">
									<section class="col-md-5">
										<input id="a" type="checkbox" name="generos[]">
										<label for="a"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
									</section>
									<section class="col-md-5">
										<input id="b" type="checkbox" name="generos[]">
										<label for="b"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
									</section>
								</section>
								<section class="row">
									<section class="col-md-5">
										<input id="c" type="checkbox" name="generos[]">
										<label for="c"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
									</section>
									<section class="col-md-5">
										<input id="d" type="checkbox" name="generos[]">
										<label for="d"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
									</section>
								</section>
								<section class="row">
									<section class="col-md-5">
										<input id="e" type="checkbox" name="generos[]">
										<label for="e"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
									</section>
									<section class="col-md-5">
										<input id="f" type="checkbox" name="generos[]">
										<label for="f"><img style="width:100%;cursor:pointer;" class="thumbnail" src="content/imagens/fotos_perfil/tmp/tmp_profile_1.jpg"></label>
									</section>
								</section>
								<section class="row">
									<button type="button" class="btn btn-primary">Adicionar</button>
								</section>
							</section>
						</section>
					</section>
				</section>
			</section>
				<!-- 
					Autores Favoritos 
				-->
					<section class="panel panel-default">
						<section class="panel-heading"><b>Autores Favoritos:</b> &nbsp;&nbsp; <a class="adicionarAutoresF" style="color:grey" title="Clique para adicionar mais um autor"><button type="button" name="plus" class="btn" id="plus"><span class="glyphicon glyphicon-plus"></button></a></section>
						<section class="panel panel-body">
							<section class="col-sm-10 col-sm-offset-1">	
								<?php
									$qt_autores_fav = 0;
									while($autor_usu = mysql_fetch_assoc($res_autor_fav))
									{
										echo '
											<section class=" input-group autoresF"> 
												<p class="camposAutoresF">
													<select class="form-control"  name = "autor[]" id="autor" required>';
										$qt_autores_fav++;
										
											foreach ($autor_nome as $key => $value) 
											{
												if($autor_usu["nome"] == $value)
												{
													echo '<option selected value = "'.$autor_id[$key].'" >' .utf8_encode($value). '</option>';
												}
												else
												{
													echo '<option value = "'.$autor_id[$key].'" >' .utf8_encode($value). '</option>'; 
												}
											}
										echo '
													</select>
													<a class="removerAutoresF" title="Clique para remover este campo">
														<section class="input-group-btn">
															<button type="button" class="btn btn-default" name="minus" id="minus">
																Remover
															</button>																
														</section>
													</a>
												</p>
											</section>';
									}

									if($qt_autores_fav == 0)
									{
										echo '
											<section class="autoresF"> 
												<p class="camposAutoresF">
													<select type="text" class="form-control"  name = "autor[]" id="autor" required>';

										foreach ($autor_nome as $key => $value) 
										{
											echo '<option value = "'.$autor_id[$key].'" >' .utf8_encode($value). '</option>'; 
										}

										echo '
													</select>
													<a class="removerAutoresF" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
												</p>
											</section>';
									}
								?>
							</section>						
						</section>
					<!-- 
						Gêneros Desapreciados 
					-->
					<section class="col-md-12">
						<fieldset>
							<legend>Gêneros Desagradáveis: &nbsp;&nbsp; <a class="adicionarGeneroD" style="color:grey" title="Clique para adicionar mais um gênero"><button type="button" name="plus" id="plus">+</button></a></legend>
							<section class="col-md-10" style="margin-left:15.8%;">
								<?php
									$qt_genero_ruim = 0;
									while($gen_des_usu = mysql_fetch_assoc($res_genero_des))
									{
										$qt_genero_ruim++;
										echo '
											<section class="generosD"> 
												<p class="camposGenerosD">
													<select type="text" class="form-control"  name = "generoD[]" id="generoD" required>';
										foreach ($generos_nome as $key => $value) 
										{
											if($gen_des_usu["nome"] == $value)
											{
												echo '<option selected value = "'.$generos_id[$key].'" >' .utf8_encode($value). '</option>';
											}
											else
											{
												echo '<option value = "'.$generos_id[$key].'" >' .utf8_encode($value). '</option>'; 
											}
										}
										echo '
													</select>
													<a class="removerGenerosD" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
												</p>
											</section>';
									}
									if($qt_genero_ruim == 0)
									{
										echo '
											<section class="generosD"> 
												<p class="camposGenerosD">
													<select type="text" class="form-control"  name = "generoD[]" id="generoD" required>';
										foreach ($generos_nome as $key => $value) 
										{
											echo '<option value = "'.$generos_id[$key].'" >' .utf8_encode($value). '</option>'; 
										}
										echo '
													</select>
													<a class="removerGenerosD" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
												</p>
											</section>';
									}
								?>
							</section>
						</fieldset>
					</section>
					<!-- 
						Autores Desapreciados 
					-->
					<section class="col-md-12">
					<fieldset>
						<legend>Autores Chatos: &nbsp;&nbsp; <a class="adicionarAutoresC" style="color:grey" title="Clique para adicionar mais um autor"><button type="button" name="plus" id="plus">+</button></a></legend>
						<section class="col-md-10" style="margin-left:15.8%;">
							<?php

								$qt_autores_ruim = 0;
								while($autor_des_usu = mysql_fetch_assoc($res_autor_des))
								{
									$qt_autores_ruim++;
									echo '<section class="autoresC"> 
											<p class="camposAutoresC">
												<select type="text" class="form-control"  name = "autorC[]" id="autor" required>';
									foreach ($autor_nome as $key => $value) 
									{
										if($autor_usu["nome"] == $value)
										{
											echo '<option selected value = "'.$autor_id[$key].'" >' .utf8_encode($value). '</option>';
										}
										else
										{
											echo '<option value = "'.$autor_id[$key].'" >' .utf8_encode($value). '</option>'; 
										}
									}
									echo '		</select>
												<a class="removerAutoresC" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>';
								}

								if($qt_autores_ruim == 0)
								{
									echo '<section class="autoresC"> 
											<p class="camposAutoresC">
												<select type="text" class="form-control"  name = "autorC[]" id="autor" required>';
									foreach ($autor_nome as $key => $value) 
									{
										echo '<option value = "'.$autor_id[$key].'" >' .utf8_encode($value). '</option>';
									}
									echo '		</select>
												<a class="removerAutoresC" style="color:grey" title="Clique para remover este campo"><button type="button" name="minus" id="minus"><span class="glyphicon glyphicon-minus"></span></button></a>
											</p>
										</section>';
								}
							?>
						</section>
					</fieldset>
				</section>
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "alterarDados" class="btn btn-primary">Salvar</button>
					<input type = "reset" value="Original" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>	
	</form>
</article>
