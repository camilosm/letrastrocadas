<script type = "text/javascript">

	function Aceitar(id)
	{
		$.ajax({
		
			url : 'ajax/aceita_solicitacao.php?id='+id,
			dataType : 'json',
			success : function(data){
				$('#Aceitar_'+id).attr({'class' : 'btn btn-success disabled', 'value' : 'Aceito', 'onClick' : ''});
				$('#Recusar_'+id).hide();
			},
			error : function(data){
				alert('Ops ocorreu um erro. Para mais informações contate nossos administradores.');
			}
		
		});
	}
	
	function Recusar(id)
	{
		$.ajax({
		
			url : 'ajax/recusar_solicitacao.php?id='+id,
			dataType : 'json',
			success : function(data){
				$('#Recusar_'+id).attr({'class' : 'btn btn-danger disabled', 'value' : 'Recusado', 'onClick' : ''});
				$('#Aceitar_'+id).hide();
			},
			error : function(data){
				alert('Ops ocorreu um erro. Para mais informações contate nossos administradores.');
			}
		
		});
	}
	
	

</script>

<?php
	session_start();
	if($_SESSION['nivel_acesso'] == 1)
	{
		$aspas = "'";
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("class_editar_caracteres.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		if(isset($_POST['cadastrar_codigo']))
		{
			$rastreamento = $_POST['Codigo_rastreamento'];
			$codigo = $_GET['id'];
			
			$editar_rastreamento = new EditarCaracteres($rastreamento);
			$rastreamento = $editar_rastreamento->sanitizeString($_POST['Codigo_rastreamento']);
			
			$editar_codigo = new EditarCaracteres($codigo);
			$codigo = $editar_codigo->sanitizeString($_GET['id']);
			
			$alterar_codigo = new Alterar('tbl_cambio',"cod_rastreamento = '".$rastreamento."'",'id_cambio ='.$codigo);
			$resultado_codigo = $alterar_codigo->alterar();
		}
		
		$alterar_status_notificações = new Alterar('tbl_notificacoes','visualizado = "true"','tipo = 3 AND usuario_id = '.$_SESSION['id']);
		$resultado = $alterar_status_notificações->alterar();
		
		$tabelas = 'tbl_solicitacao_troca solicitacao INNER JOIN tbl_usuario usuario INNER JOIN tbl_lista_livros lista INNER JOIN tbl_livro livro INNER JOIN tbl_cambio cambio ON id_usuario = usuario_solicitador AND id_livro = livro_id AND id_lista_livros = lista_id AND id_lista_livros = lista_livros_id';
		
		$pesquisar_pendente = new Pesquisar($tabelas,'usuario.nome As nome, livro.nome As livro, solicitacao.*',"aceito = '' AND usuario_dono_lista = ".$_SESSION['id']);
		$resultado_pendente = $pesquisar_pendente->pesquisar();
		
		$pesquisar_respondidas = new Pesquisar($tabelas,'cambio.id_cambio as id_cambio,usuario.nome As nome, livro.nome As livro, solicitacao.*',"aceito <> '' AND  usuario_dono_lista = ".$_SESSION['id']);
		$resultado_respondidas = $pesquisar_respondidas->pesquisar();
		
		echo '
		<section class="panel panel-default" style="margin-left:5%; width:70%;">
			<section class="panel-heading">
				<h3 class="panel-title">Suas solicitações</h3>
			</section>
			<section class="panel-body">';
		$ct = 0;
		while($notificações_pendentes=mysql_fetch_assoc($resultado_pendente))
		{
			$ct++;
			if($ct == 1)
			{
			$colapse = "in";
			}
			else
			{
				$colapse = "";
			}
			
			$data = explode("-",$notificações_pendentes['data_solicitacao']);
			$data_pronta = $data[2]."/".$data[1]."/".$data[0];
			
			echo '
			<section class="panel-group" id="solicitações">
				<section class="panel panel-default">
					<section class="panel-heading" style="background-color:#D3D3D3;">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#solicitações" href="#collapse'.$ct.'">'.utf8_encode($notificações_pendentes['livro']).' - Pendente
							</a>
						</h4>
					</section>
					<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
						<section class="panel-body">
						<p>
							<H4>
							'.utf8_encode($notificações_pendentes['nome']).' solicitou seu livro "'.utf8_encode($notificações_pendentes['livro']).'"
							no dia '.$data_pronta.'<BR>
							Deseja aceitar?<BR>
							</H4>
						</p>
						<input type = "button" class="btn btn-primary btn-sm" id = "Aceitar_'.$notificações_pendentes['id_solicitacao'].'" onClick="Aceitar('.$notificações_pendentes['id_solicitacao'].')" value = "Aceitar"/>
						<input type = "button" class="btn btn-primary btn-sm" id = "Recusar_'.$notificações_pendentes['id_solicitacao'].'" onClick="Recusar('.$notificações_pendentes['id_solicitacao'].')" value="Recusar"/>
					</section>							
				</section>
			</section>';
			 
		}
		while($notificações_antigas=mysql_fetch_assoc($resultado_respondidas))
		{	
			if($ct == 0)
			{
				$colapse = "in";
			}
			else
			{
				$colapse = "";
			}
			
			$codigo = "";
			if($notificações_antigas['aceito'] == "Sim")
			{
				$codigo = '
							<BR>
							<label for="Codigo_rastreamento" class="control-label">Código de rastreamento:</label>
							<input type = "text" style="width:30%;" class = "form-control" name = "Codigo_rastreamento" id = "Codigo_rastreamento"><BR>
							<button type="submit" class="btn btn-primary" name = "cadastrar_codigo" id = "cadastrar_codigo">Cadastrar código</button>';
			}
			$ct++;
			
			$data_solicitada = explode("-",$notificações_antigas['data_solicitacao']);
			$data_pronta_solicitada = $data_solicitada[2]."/".$data_solicitada[1]."/".$data_solicitada[0];
			
			$data_respondida = explode("-",$notificações_antigas['data_resposta']);
			$data_pronta_respondida = $data_respondida[2]."/".$data_respondida[1]."/".$data_respondida[0];
			
			 echo '
			 <section class="panel-group" id="solicitações">
				<section class="panel panel-default">
					<section class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#solicitações" href="#collapse'.$ct.'">'.utf8_encode($notificações_antigas['livro']).' - Aceito : '.$notificações_antigas['aceito'].'
							</a>
						</h4>
					</section>
					<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
						<form action="?url=solicitacoes_recebidas&id='.$notificações_antigas['id_cambio'].'" method="post">
						<section class="panel-body">
						<p class="lead">
							<H4>
								'.utf8_encode($notificações_antigas['nome']).' solicitou seu livro "'.utf8_encode($notificações_antigas['livro']).'"
								no dia '.$data_pronta_solicitada.' e respondida no dia '.$data_pronta_respondida.' <BR>
								'.$codigo.'								
							</H4>
						</p>
						</section>
					</section>
				</section>
			</section>';
		}
		echo '
			</section>
		</section>';

	}
	else
	{
		if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
?>