<?php
	
	session_start();
	if($_SESSION['nivel_acesso'] == 1)
	{
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		$pesquisar_novas = new Pesquisar('tbl_notificacoes','*','tipo = 1 AND visualizado = "false" AND usuario_id = '.$_SESSION['id']);
		$resultado_novas = $pesquisar_novas->pesquisar();
		
		$pesquisar_antigas = new Pesquisar('tbl_notificacoes','*','tipo = 1 AND visualizado = "true" AND usuario_id = '.$_SESSION['id']);
		$resultado_antigas = $pesquisar_antigas->pesquisar();
		
		echo '
		<section class="panel panel-primary" style="margin-left:5%; width:70%;">
			<section class="panel-heading">
				<h3 class="panel-title">Suas trocas</h3>
			</section>
			<section class="panel-body">
				<ul class="list-group">';
		
		while($notificações_novas=mysql_fetch_assoc($resultado_novas))
		{
			echo '
			<li class="list-group-item" style="background-color:#DCDCDC;">
				<p>'.utf8_encode($notificações_novas['mensagem']).'<BR>
				Dono do livro : 
				</p>
			</li>';
			 
			$alterar_status_notificações = new Alterar('tbl_notificacoes','visualizado = "true"','id_notificacoes ='.$notificações_novas['id_notificacoes']);
			$resultado = $alterar_status_notificações->alterar();
			 
		}
		while($notificações_antigas=mysql_fetch_assoc($resultado_antigas))
		{
			 echo '
			<li class="list-group-item">
				<p>'.utf8_encode($notificações_antigas['mensagem']).'</p>
			 </li>';
		}
		echo '
				</ul>
			</section>
		</section>';
		
		
		
	}
	else
	{
		header("location: ?url=sem_permissão");
	}
?>