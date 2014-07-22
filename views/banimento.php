<?php

		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		$id_den = $_GET['cod_d'];
		$id_usu = $_GET['cod_usu'];
		
		/* Pesquisar ocorrências anteriores do usuário */ 
		
		$campos = "id_usuario, id_denuncias, usu.nome, email, motivo_id, motivo, outro_motivo, data,avaliacoes_negativas, avaliacoes_positivas";
		$tabela = "tbl_usuario usu JOIN tbl_denuncias ON usuario_denunciado_id = id_usuario JOIN tbl_motivos ON motivo_id = id_motivo";
		$condicao = "usuario_denunciado_id = $id_usu GROUP BY id_denuncias ORDER BY data";
		
		$pesquisa_den_usu = new Pesquisar("$tabela","$campos","$condicao");
		$resultado_den_usu = $pesquisa_den_usu->pesquisar();
		$Dados_Den_Usu = mysql_fetch_assoc($resultado_den_usu);
		
		
		
?>

<article>
	<section class="panel panel-default" style = "width:95%;position:fixed;margin-top:1%;margin-left:2%;">
	<section class="panel-heading">Banimentos</section>
		<section class="panel panel-default" style = "width:35%;position:fixed;margin-top:1%;margin-left:3%;">
			<section class="panel-heading">Histórico de denuncias do usuário</section>
				<section class="panel-body">
					<section class="list-group">
		<?php while($Dados_Den_Usu = mysql_fetch_assoc($resultado_den_usu)){
		   echo 
		   '<a class="list-group-item">
		    	<h4 class="list-group-item-heading">'.$Dados_Den_Usu['email'].' - '.$Dados_Den_Usu['data'] .'</h4>
		    		<p class="list-group-item-text">'.utf8_encode($Dados_Den_Usu['motivo']).'. '.utf8_encode($Dados_Den_Usu['outro_motivo']).'
						<section id = "avaliações" style = "width:50%;">
							<br><label> Avaliações: </label>
								&nbsp  
									<span class= "glyphicon glyphicon-thumbs-up"></span> <span class = "badge">'.$Dados_Den_Usu["avaliacoes_positivas"].'</span> 
								&nbsp
									<span class= "glyphicon glyphicon-thumbs-down"> </span> <span class = "badge">'.$Dados_Den_Usu["avaliacoes_negativas"].'</span>
						</section></p>			
		    </a>';
		}
		?>
					</section>
				</section>
		</section>
	<form method="post" action="">
		<section class ="panel panel-default" style = "width:50%;position:fixed;margin-top:1%;margin-left:42%;">
			<section class="panel-heading">Medidas</section>
				<section class="panel-body">
					<p> Qual medida você deseja tomar? </p>
						<section class="col-lg-10">
							<section class="radio">
								<label> Banir do site por 1 mês</label>
									<input type="radio" name="Ban" id="optionsRadios1" value="1">
							</section>
						<section class="radio">
								<label>Banir conta permanentemente</label>
									<input type="radio" name="Ban" id="optionsRadios3" value="3">    
						</section>
					    <section class="radio">
								<label>Emitir aviso de 1ª denuncia</label>
									<input type="radio" name="Ban" id="optionsRadios4" value="2">                   
						</section>
					    <section class="radio">
								<label>Emitir aviso de 2ª denuncia</label>
									<input type="radio" name="Ban" id="optionsRadios4" value="2">                   
						</section>
						<button type="submit" class="btn btn-primary" name = "btnBanir">
							<span class="glyphicon glyphicon-flag"></span> Banir
						</button>
   
						</section>
			</section>
		</section>
	</form>
</section>
</article>

<?php

		if(isset($_POST['btnBanir']))
		{
			if($_POST['Ban'] == 1)
			{
				mysql_query("CALL sp_atualiza_status_usu_banido($id_usu)");
				mysql_query("CALL sp_atualiza_status_den($id_den)");
			}
			else if ($_POST['Ban'] == 3)
			{
				mysql_query("CALL sp_atualiza_status_den($id_den)");
				mysql_query("CALL sp_atualiza_status_usu_banido_permanente($id_usu)");
			}
			else 
			{
				mysql_query("CALL sp_atualiza_status_den($id_den)");
			}
		}

?>