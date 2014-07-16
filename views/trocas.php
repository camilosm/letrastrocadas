<?php
	
	session_start();
	if($_SESSION['nivel_acesso'] == 1)
	{
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		$tabelas = 'tbl_solicitacao_troca solicitacao INNER JOIN tbl_usuario usuario INNER JOIN tbl_lista_livros lista INNER JOIN tbl_livro livro ON id_usuario = usuario_solicitador AND id_livro = livro_id AND id_lista_livros = lista_id';
		
		$pesquisar_trocas = new Pesquisar($tabelas,'livro.nome As livro, solicitacao.*',"aceito <> '' AND  usuario_solicitador = ".$_SESSION['id']);
		$resultado_trocas = $pesquisar_trocas->pesquisar();
		
		echo '
		<section class="panel panel-primary" style="margin-left:5%; width:70%;">
			<section class="panel-heading">
				<h3 class="panel-title">Suas trocas</h3>
			</section>
			<section class="panel-body">
				<ul class="list-group">';
		
		while($trocas=mysql_fetch_assoc($resultado_trocas))
		{
			echo $trocas['usuario_solicitador'];
			$pesquisar_nome_usuario = new Pesquisar('tbl_usuario','nome',"id_usuario = ".$trocas['usuario_solicitador']);
			$resultado_nome = $pesquisar_nome_usuario->pesquisar();
			while($resultado = mysql_fetch_assoc($resultado_nome))
			{
				$nome = $resultado['nome'];
			}
			 echo '
			<li class="list-group-item">
				<p>Usuário que solicitou : '.utf8_encode($nome).'<BR>
				Livro solicitado : '.$trocas['livro'].'<BR>
				Solicitação enviada no dia : '.$trocas['data_solicitacao'].'<BR>
				Respondida no dia : '.$trocas['data_resposta'].'<BR>
				Realizado : '.$trocas['aceito'].'</p>
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