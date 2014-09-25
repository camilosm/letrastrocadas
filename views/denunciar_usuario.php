<?php
        
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		$id_outro_usu = $_GET['cod'];
			
		$pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,foto,email,idade,bairro,uf,cidade", " id_usuario = $id_outro_usu");
		$resul_pesquisa = $pesquisa_dados->pesquisar();
		$pesq = mysql_fetch_array($resul_pesquisa);
		
		$nome = $pesq['nome'];
		$foto = $pesq['foto'];
		$idade = $pesq['idade'];
		$uf = $pesq['uf'];
		$cidade = $pesq['cidade'];
		$bairro = $pesq['bairro'];	
		$email = $pesq['email'];
		$cod_usu = $pesq['id_usuario'];
		
	if(isset($_POST['btnDenunciar']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$motivo = $_POST['MotivoDenuncia'];
		$outro_motiv = $_POST['outroMotivo'];
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_motivo = new EditarCaracteres($outro_motiv);
		$outro_motiv = $editar_motivo->sanitizeStringNome($_POST['outroMotivo']);
		
		//Realiza a inserção
		$values_denuncia = "NULL,".$id_outro_usu.",DATE(NOW()),".$motivo.",'".$outro_motiv."'";
		$cadastra_denuncia = new Inserir("tbl_denuncias",$values_denuncia);
		$res = $cadastra_denuncia->inserir();
		
		//Conferir se foi inserido 
		if ($res)
		{
			echo "Denuncia feita com sucesso!";
			$pesquisa_dados = new Pesquisar("tbl_denuncias join tbl_usuario on usuario_denunciado_id = id_usuario","count(id_denuncias) as ndenuncias", "usuario = $id_outro_usu");
			$resultado = $pesquisa_dados->pesquisar();
			$ndenuncias = mysql_fetch_array($resul_pesquisa);
			if($ndenuncias['ndenuncias'] > 2)
			{
				include ("classes/class_update.php");
				
				$banir = new Alterar("tbl_usuario","status = 3","where usuario = $cod_usu");
				$baniu = $banir->alterar();
			}
		}
		else
		{
			echo "Erro ao cadastrar denuncia.";
		}
		
	}

		
?>

<article id = "body_perfil_usuario">
            <section class="panel panel-default" style="width: 65%; position: relative; left: 5%">
			<section class="panel-body">
			
			<table class="table table-striped table-hover" style = "table-layout:fixed">
            <tbody>
            <tr>
				  <td id = "foto_usuario" rowspan = "3"> <img src = " <?php echo $foto; ?>" width="100%" ></td>
			      <td id = "nome_usuario" colspan = "4"><b>Nome:&nbsp;</b> <?php echo utf8_encode($nome); ?> </td>
            </tr>
            <tr>
			      <td id = "cidade_usuario" colspan = "2"><b> Cidade:&nbsp;</b> <?php echo utf8_encode($cidade); ?> </td>
			      <td id = "uf_usuario"><b>UF:&nbsp;</b> <?php echo utf8_encode($uf); ?></td>
			      <td id = "idade_usuario"> <b>Idade:&nbsp;</b> <?php  echo utf8_encode($idade);?> </td>
            </tr>
            <tr>
                  
            </tr>
			<tbody>
			
            </table>
    <form class="form-horizontal" method = "post" action ="">
		<fieldset>
            <legend>Denunciar</legend>           
				<section class="form-group">
						<label for="textArea" class="col-lg-2 control-label">Informe aqui o motivo</label>
	         		<section class="col-lg-10">
                        <section class="radio">
							<label> Livro com mais danos que o previsto na descrição.</label>
								<input type="radio" name="MotivoDenuncia" id="optionsRadios1" value="1">
						</section>
						<section class="radio">
							<label> Livro não foi enviado. </label>
								<input type="radio" name="MotivoDenuncia" id="optionsRadios2" value="2">
						</section>
						<section class="radio">
							<label>Livro recebido é diferente do livro solicitado.</label>
								<input type="radio" name="MotivoDenuncia" id="optionsRadios3" value="3">    
						</section>
					    <section class="radio">
							<label>Outro:</label>
								<input type="radio" name="MotivoDenuncia" id="optionsRadios4" value="4">                   
						<section class="form-group">
							<section class="col-lg-10">
								<textarea class="form-control" rows="3" id="textArea" name = "outroMotivo"></textarea>
								<span class="help-block">Máximo 255 caracteres.</span>
							</section>
						</section>
						</section>
					</section>
                </section>

            </section>
            
            <section class="form-group">
	         	<section class="col-lg-10 col-lg-offset-2">
	         		<button type="button" class="btn btn-default">
	         			<span class="glyphicon glyphicon-remove-circle"></span> Cancelar 
	         		</button>
	         		<button type="submit" class="btn btn-primary" name = "btnDenunciar">
	         			<span class="glyphicon glyphicon-flag"></span> Denunciar
	         		</button>
                </section>
			</section>
  </fieldset>
 </form>	
</article>