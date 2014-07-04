<?php
	
	if(isset($_GET['livro']) && isset($_GET['usuario']))
	{
		$id_livro = $_GET['livro'];
		$id_usuario = $_GET['usuario'];
		
		$aspas = "'";
		
		$retorno = '
				<section class="modal-dialog">
					<section class="modal-content">
						<section class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Solicitação de livro</h4>
						</section>
						<section class="modal-body">
							<p id = "TextDialog" >Você deseja solicitar este livro?</p>
						</section>
						<section class="modal-footer">
							<button id = "cancelar" type="button" class="btn btn-default" data-dismiss="modal">Não</button>
							<button id = "confirmar_solicitação" type="button" class="btn btn-primary" onClick="ConfirmarSolicitacao('.$aspas.''.$id_livro.''.$aspas.','.$aspas.''.$id_usuario.''.$aspas.')">Sim</button>
						</section>
					</section>
				</section>';
		
		$caixa_dialogo = array('section' => $retorno);
				
		echo json_encode($caixa_dialogo);
	}

?>