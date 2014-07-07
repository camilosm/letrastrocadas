<?php
	session_start();
	$status = $_SESSION['nivel_acesso'];
	$id = $_SESSION['id'];
	if($status == 1)
	{
		include("../views/classes/class_banco.php");
		include("../views/classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		$pesquisar_notificacoes = new Pesquisar("tbl_notificacoes","*","visualizado = false AND data_enviada >= DATE_SUB(NOW(),INTERVAL 5 SECOND");
		$resultado = $pesquisar_notificacoes->pesquisar();
		
		while($notificações=mysql_fetch_row($resultado))
		{
			$retorno.= '
			<section class="panel panel-default" style="float: left; margin-left:3%; width:20%; opacity:0.5;">
				<section class="panel-body">	
				<p> '.utf8_encode($notificações['mensagem']).' </p>
				</section>
			</section>
			';
		}
	}

?>