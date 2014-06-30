<?php
	
	if((isset($_GET['lista'])) && (isset($_GET['acao'])))
	{
		if($_GET['acao'] == "Novo")
		{
			session_start();

			include("../views/classes/class_banco.php");
			include("../views/class_editar_caracteres.php");
			include("../views/classes/class_pesquisar.php");
			
			$bd = new Banco();
			
			$id = $_GET['lista'];
			
			//Pesquisa da lista de desejo do site
			$campos_lista = "livros_desejo.id_lista_desejo As id_lista,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
			$tabelas_lista = "tbl_lista_desejo livros_desejo INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
			$condição_lista = "id_lista_desejo > ".$id." AND usuario_id = ".$_SESSION['id']." ORDER BY id_lista_desejo LIMIT 6";
			
			$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
			
			//Pesquisa a quantidade de livros na lista de desejo no banco de dados
			$pesquisar_quantidade_lista_desejo = new Pesquisar("tbl_lista_desejo ","COUNT(id_lista_desejo) As Quantidade","id_lista_desejo > ".$id);
			$resultado_quantidade_lista_desejo = $pesquisar_quantidade_lista_desejo->pesquisar();			
			$array_quantidade_lista_desejo = mysql_fetch_assoc($resultado_quantidade_lista_desejo);
			$quantidade_lista_desejo = $array_quantidade_lista_desejo['Quantidade'];

			if($quantidade_lista_desejo >= 7)
			{
				$resto = "Sim";
			}
			else
			{
				$resto = "Não";
			}
			
			$return = "";
			$ct=0;
			$id_ultima = array();
			while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
			{
				$ct++;
				$id_ultima[] = $lista_desejo['id_lista'];
				$return.= '
					<tr id = "desejados_linha">
						<td> 
							<form>
								<section class="panel panel-body">
									<section class = "col-lg-4">	  
										<section class = "bs-component" style = "height: 177px; width:120px;"> 
											<a href="?url=livro "class = "thumbnail">
												<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
											</a>	
										</section>
										<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
											<a href="?url=livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
											<a href="?url=livros_autores"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
											<a href="?url=livros_editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
										</section>
									</section>
								</section> 
								
								<section style="margin-left:10%;">
									<a href="?url=pesquisa&cod='.$lista_desejo['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
									<a href="?url=passo-a-passo-dados-usuario&cod='.$lista_desejo['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>													 
									<section class = "btn-group">
										<button id = "Resultado'.$lista_desejo['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
										<ul id = "acoes" class="dropdown-menu">
											<li name = "Desmarcar" id = "'.$lista_desejo['id_livro'].'" ><a>Desmarcar</a></li>
											<li name = "JaLi" id = "'.$lista_desejo['id_livro'].'" ><a>Já li</a></li>
											<li name = "Lendo" id = "'.$lista_desejo['id_livro'].'" ><a>Estou lendo</a></li>
										</ul>
									</section>
								</section>
							</form>	
						</td>
					</tr>';	
			}
			
			$lista_desejo = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1], 'novo'=> $resto, 'primeiro' => $id_ultima[0]);
			
			echo json_encode($lista_desejo);
		}
	}
?>