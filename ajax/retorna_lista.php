<?php
	session_start();
	if(isset($_GET['livro']))
	{
		$livro = $_GET['livro'];
		
		include("../views/classes/class_banco.php");
		include("../views/classes/class_pesquisar.php");
		
		$bd = new Banco();

		$campos = "id_marcacao,imagem_livros,id_livro,livro.nome AS Livro,autor.nome AS Autor,editora.nome As Editora, livro.sinopse As sinopse";
		$tabelas = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id AND id_livro = livro_id";
		$pesquisar_livro = new Pesquisar($tabelas,$campos,'livro_id = '.$livro);
		$resposta = $pesquisar_livro->pesquisar();

		$id_livro = array();
		$id = array();
		$nome = array();
		$imagem = array();
		$editora = array();
		$autor = array();
		$sinopse = array();
		
		while($pesquisa=mysql_fetch_assoc($resposta))
		{
			$id_livro[] = $pesquisa['id_livro'];
			$id[] = $pesquisa['id_marcacao'];
			$nome[] = $pesquisa['Livro'];
			$imagem[] = $pesquisa['imagem_livros'];
			$editora[] = $pesquisa['Editora'];
			$autor[] = $pesquisa['Autor'];
			$sinopse[] = $pesquisa['sinopse'];
		}

		$retorno = '
			<section class = "col-lg-4" style = "width: auto;">	
				<section class = "bs-component"> 
					<a class = "thumbnail">
						<img src = "'.$imagem['0'].'>" alt = "'.utf8_encode($nome[0]).'" height = "177px" width = "120px"/> 
					</a>
				</section>
			</section>
			<section class = "col-lg-4">
				<a> <h3> '.utf8_encode($nome[0]).' </h3> </a>				  
				<a> <h4> '.utf8_encode($autor[0]).' </h4></a>
				<a> <h5> '.utf8_encode($editora[0]).' </h5></a>
				<form method="post" action="?url=alterar_livro_usuario&cod='.$id_livro[0].'">
					<input type="submit" class="btn btn-primary btn-sm" name="alterarlivro" value="Alterar Livro"/>
				</form>
			</section>
			<section class = "col-lg-4" style = "width:48%;">
				<textarea class="form-control" rows="9" readonly>
					'.$sinopse[0].'
				</textarea>
			</section> 
		';

		$caixa_dialogo = array('section' => $retorno);
				
		echo json_encode($caixa_dialogo);
	}

?>