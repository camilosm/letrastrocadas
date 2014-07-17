<?php
	
	session_start();
	if($_SESSION['nivel_acesso'] == 1)
	{
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		$alterar = new Alterar("tbl_notificacoes","visualizado = 'true'","usuario_id = ".$_SESSION['id']." AND tipo = 1 OR usuario_id = ".$_SESSION['id']." AND tipo = 2");
		$resultado = $alterar->alterar();
		
		$tabelas = 'tbl_solicitacao_troca solicitacao INNER JOIN tbl_usuario usuario INNER JOIN tbl_lista_livros lista INNER JOIN tbl_livro livro ON id_usuario = usuario_solicitador AND id_livro = livro_id AND id_lista_livros = lista_id';
		
		$pesquisar_trocas = new Pesquisar($tabelas,'livro.nome As livro, solicitacao.*',"aceito <> '' AND  usuario_solicitador = ".$_SESSION['id']." ORDER BY data_resposta DESC");
		$resultado_trocas = $pesquisar_trocas->pesquisar();
		
		echo '
		<section class="panel panel-default" style="margin-left:5%; width:70%;">
			<section class="panel-heading">
				<h3 class="panel-title">Suas trocas</h3>
			</section>
			<section class="panel-body">';
		$ct = 0;
		while($trocas=mysql_fetch_assoc($resultado_trocas))
		{
			$ct++;
			$pesquisar_nome_usuario = new Pesquisar('tbl_usuario','nome',"id_usuario = ".$trocas['usuario_dono_lista']);
			$resultado_nome = $pesquisar_nome_usuario->pesquisar();
			while($resultado = mysql_fetch_assoc($resultado_nome))
			{
				$nome = $resultado['nome'];
			}
			if($trocas['aceito'] == "Sim")
			{
				$pesquisar_codigo = new Pesquisar('tbl_cambio','cod_rastreamento',"usuario_disponibilizador = ".$trocas['usuario_dono_lista']." AND usuario_resgate =".$_SESSION['id']);
				$resultado_codigo = $pesquisar_codigo->pesquisar();
				while($resultado_codigo = mysql_fetch_assoc($resultado_codigo))
				{
					$codigo = $resultado_codigo['cod_rastreamento'];
				}
			}
			if($ct == 1)
			{
				$colapse = "in";
			}
			else
			{
				$colapse = "";
			}
			 echo '
			 <section class="panel-group" id="trocas">
				<section class="panel panel-default">
					<section class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#trocas" href="#collapse'.$ct.'">'.utf8_encode($trocas['livro']).' - '.$trocas['data_resposta'].'
							</a>
						</h4>
					</section>
					<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
						<section class="panel-body">
						<p>
							Dono do livro :  '.utf8_encode($nome).'<BR>
							Livro solicitado : '.$trocas['livro'].'<BR>
							Solicitação enviada no dia : '.$trocas['data_solicitacao'].'<BR>
							Respondida no dia : '.$trocas['data_resposta'].'<BR>
							Aceito : '.$trocas['aceito'].'<BR>
							Código de rastreamento : '.$codigo.'<BR>
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