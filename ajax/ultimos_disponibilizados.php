<?php
	
	if((isset($_GET['lista_lvro'])) && (isset($_GET['acao'])))
	{
		session_start();

		include("../views/classes/class_banco.php");
		include("../views/class_editar_caracteres.php");
		include("../views/classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$id = $_GET['lista_lvro'];
		
		$aspas = "'";
		
		if($_GET['acao'] == "Novo")
		{
			
			
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros < ".$id." AND tbl_lista_livros.status = 1 ORDER BY data_cadastro DESC LIMIT 6";
			$pesquisar_ultimos = new Pesquisar($tabelas,$campos,$condição);
			$resultado_ultimos = $pesquisar_ultimos->pesquisar();
			
			//Pesquisa a quantidade de livros no banco de dados
			$pesquisar_quantidade_ultimos = new Pesquisar("tbl_lista_livros ","COUNT(id_lista_livros) As Quantidade","id_lista_livros > ".$id);
			$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
			$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_ultimos = $array_quantidade_ultimos['Quantidade'];
			
			if($quantidade_ultimos >= 7)
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
			while($ultimos=mysql_fetch_assoc($resultado_ultimos))
			{
				$ct++;
				$id_ultima[] = $ultimos['id_lista_livros'];
				$return.= '
				<tr id = "desejados_linha">
					<td> 
						<form>
							<section class="panel panel-body">
								<section class = "col-lg-4">	  
									<section class = "bs-component" style = "height: 177px; width:120px;"> 
										<a href="?url=livro "class = "thumbnail">
											<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
										</a>	
									</section>
									<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
										<a href="?url=livro"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
										<a href="?url=livros_autores"> <h4>'.utf8_encode($ultimos['Autor']).' </h4></a>
										<a href="?url=livros_editora"> <h5>'.utf8_encode($ultimos['Editora']).' </h5></a>
										<a href="#"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
									</section>
								</section>
							</section> 
							
							<section>
								<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" onClick="SolicitarLivro('.$aspas.''.$ultimos["id_lista_livros"].''.$aspas.','.$aspas.''.$ultimos['id_usuario'].''.$aspas.')">Solicitar Livro</button>
								<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
								<section class = "btn-group">
									<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Eu...</button>
									<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
									<ul id = "acoes" class="dropdown-menu">
										<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
										<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
										<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
									</ul>
								</section>
								<a href="?url=pesquisa&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Veja +"/></a>
							</section>
						</form>	
					</td>
				</tr>';
			}

			$lista_livros = array('tabela'=> $return,'ultimo_id'=> "ultimo",'novo'=> $resto, 'primeiro' => "oi");
			
			echo json_encode($lista_livros);
			
		}
		if($_GET['acao'] == "Antigo")
		{
		
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros <= ".$id." AND tbl_lista_livros.status = 1 ORDER BY data_cadastro DESC LIMIT 6";
			$pesquisar_ultimos = new Pesquisar($tabelas,$campos,$condição);
			$resultado_ultimos = $pesquisar_ultimos->pesquisar();
			
			//Pesquisa a quantidade de livros no banco de dados
			$pesquisar_quantidade_ultimos = new Pesquisar("tbl_lista_livros ","COUNT(id_lista_livros) As Quantidade","1=1");
			$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
			$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_ultimos = $array_quantidade_ultimos['Quantidade'];
			
			if($quantidade_ultimos >= 7)
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
			while($ultimos=mysql_fetch_assoc($resultado_ultimos))
			{
				$ct++;
				$id_ultima[] = $ultimos['id_lista_livros'];
				$return.= '
				<tr id = "desejados_linha">
					<td> 
						<form>
							<section class="panel panel-body">
								<section class = "col-lg-4">	  
									<section class = "bs-component" style = "height: 177px; width:120px;"> 
										<a href="?url=livro "class = "thumbnail">
											<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
										</a>	
									</section>
									<section class="col-lg-4" style="margin-left:150%; margin-top:-200%; width:250%;">								
										<a href="?url=livro"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
										<a href="?url=livros_autores"> <h4>'.utf8_encode($ultimos['Autor']).' </h4></a>
										<a href="?url=livros_editora"> <h5>'.utf8_encode($ultimos['Editora']).' </h5></a>
										<a href="#"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
									</section>
								</section>
							</section> 
							
							<section>
								<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" name = "'.$ultimos['id_lista_livros'].'" value = "'.$ultimos['id_usuario'].'"/>Solicitar Livro</button>
								<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
								<section class = "btn-group">
									<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Eu...</button>
									<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
									<ul id = "acoes" class="dropdown-menu">
										<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
										<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
										<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
									</ul>
								</section>
								<a href="?url=pesquisa&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Veja +"/></a>
							</section>
						</form>	
					</td>
				</tr>';
			}

			$lista_livros = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1],'primeiro' => "oi");
			
			echo json_encode($lista_livros);
			
		}
	}

?>