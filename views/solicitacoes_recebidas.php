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
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		$tabelas = 'tbl_solicitacao_troca solicitacao INNER JOIN tbl_usuario usuario INNER JOIN tbl_lista_livros lista INNER JOIN tbl_livro livro ON id_usuario = usuario_solicitador AND id_livro = livro_id AND id_lista_livros = lista_id';
		
		$pesquisar_pendente = new Pesquisar($tabelas,'usuario.nome As nome, livro.nome As livro, solicitacao.*',"aceito = '' AND usuario_dono_lista = ".$_SESSION['id']);
		$resultado_pendente = $pesquisar_pendente->pesquisar();
		
		$pesquisar_respondidas = new Pesquisar($tabelas,'usuario.nome As nome, livro.nome As livro, solicitacao.*',"aceito = 'Sim' OR aceito = 'Nao' AND  usuario_dono_lista = ".$_SESSION['id']);
		$resultado_respondidas = $pesquisar_respondidas->pesquisar();
		
		echo '
		<section class="panel panel-primary" style="margin-left:5%; width:70%;">
			<section class="panel-heading">
				<h3 class="panel-title">Solicitações recebidas</h3>
			</section>
			<section class="panel-body">
				<ul class="list-group">';
		while($notificações_penddentes=mysql_fetch_assoc($resultado_pendente))
		{
			echo '
			<li class="list-group-item" style="background-color:#DCDCDC;">
				<p>Você tem uma nova solicitação de troca!<BR>
				Usuário que solicitou : '.utf8_encode($notificações_penddentes['nome']).'<BR>
				Livro solicitado : '.$notificações_penddentes['livro'].'<BR>
				Solicitação enviada no dia : '.$notificações_penddentes['data_solicitacao'].'<BR>
				Deseja aceitar?<BR></p>
				<input type = "button" class="btn btn-primary btn-sm" id = "Aceitar_'.$notificações_penddentes['id_solicitacao'].'" onClick="Aceitar('.$notificações_penddentes['id_solicitacao'].')" value = "Aceitar"/>
				<input type = "button" class="btn btn-primary btn-sm" id = "Recusar_'.$notificações_penddentes['id_solicitacao'].'" onClick="Recusar('.$notificações_penddentes['id_solicitacao'].')" value="Recusar"/>
			</li>';
			 
			$alterar_status_notificações = new Alterar('tbl_notificacoes','visualizado = "true"','tipo = 3 AND usuario_id = '.$_SESSION[id]);
			$resultado = $alterar_status_notificações->alterar();
			 
		}
		while($notificações_antigas=mysql_fetch_assoc($resultado_respondidas))
		{
			 echo '
			<li class="list-group-item">
				<p>Usuário que solicitou : '.utf8_encode($notificações_antigas['nome']).'<BR>
				Livro solicitado : '.$notificações_antigas['livro'].'<BR>
				Solicitação enviada no dia : '.$notificações_antigas['data_solicitacao'].'<BR>
				Respondida no dia : '.$notificações_antigas['data_resposta'].'<BR>
				Realizado : '.$notificações_antigas['aceito'].'</p>
			 </li>';
		}
		echo '
				</ul>
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