<?php
        
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		$id_outro_usu = $_GET['cod'];
			
		$pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,foto,email,idade,uf,cidade,genero_favorito", " id_usuario = $id_outro_usu");
		$resul_pesquisa = $pesquisa_dados->pesquisar();
		$pesq = mysql_fetch_array($resul_pesquisa);
		
		$nome = $pesq['nome'];
		$foto = $pesq['foto'];
		$idade = $pesq['idade'];
		$genero_favorito = $pesq['genero_favorito'];
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
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_motivo = new EditarCaracteres($motivo);
		$motivo = $editar_motivo->sanitizeStringNome($_POST['MotivoDenuncia']);
		
		//Realiza a inserção
		$values_denuncia = "NULL,".$id_outro_usu.",'".$motivo."',1";
		$cadastra_denuncia = new Inserir("tbl_denuncias",$values_denuncia);
		$res = $cadastra_denuncia->inserir();
		
		//Conferir se foi inserido 
		if ($res)
		{
			echo "Denuncia feita com sucesso!";
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
                  <td id = "generos_fav_usuario" colspan = "4" ><b> Gênero favorito: &nbsp;</b> <?php echo utf8_encode($genero_favorito); ?></td>
            </tr>
			<tbody>
			
            </table>
            <form class="form-horizontal" method = "post" action ="">
  <fieldset>
            <legend>Denunciar</legend>
            
            <div class="form-group">
	         	<label for="textArea" class="col-lg-2 control-label">Informe aqui o motivo</label>
	         		<div class="col-lg-10">
	         			<textarea class="form-control" rows="3" id="textArea" name = "MotivoDenuncia"></textarea>
	         			<span class="help-block">Maximo de 224 caracteres.</span>
	         		</div>
            </div>
            
            <div class="form-group">
	         	<div class="col-lg-10 col-lg-offset-2">
	         		<button type="button" class="btn btn-default">
	         			<span class="glyphicon glyphicon-remove-circle"></span> Cancelar 
	         		</button>
	         		<button type="submit" class="btn btn-primary" name = "btnDenunciar">
	         			<span class="glyphicon glyphicon-flag"></span> Denunciar
	         		</button>
                </div>
			</div>
  </fieldset>
			</form>	
</article>