<?php
	
	if((isset($_GET['lista_lvro'])) && (isset($_GET['acao'])))
	{
		session_start();

		include("../views/classes/class_banco.php");
		include("../views/class_editar_caracteres.php");
		include("../views/classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$id = $_GET['lista_lvro'];
		
		// Pesquisando o filtro de gêneros ruins para a pesquisa de últimos disponibilizados 
			$pesquisa_generos_ruins = new Pesquisar("tbl_generos_desapreciados","genero_id","usuario_id = ".$_SESSION['id']);
			$resultado = $pesquisa_generos_ruins->pesquisar();
			
			// Quantidade de gêneros marcados pelo usuário como fora do seu gosto.
			$pesquisa_generos_ruins_quantidade = new Pesquisar("tbl_generos_desapreciados","COUNT(genero_id)As quantidade","usuario_id = ".$_SESSION['id']);
			$resultado_quantidade = $pesquisa_generos_ruins_quantidade->pesquisar();
			$array = mysql_fetch_assoc($resultado_quantidade);
			$qt_genero = $array['quantidade'];
			
			// Fazendo a condição da pesquisa 
			$string_condicao_genero = "";
			$contador_genero = 0;
			while($generos_ruins=mysql_fetch_assoc($resultado))
			{	
				$contador_genero++;
				if(($qt_genero != 1) AND ($qt_genero == $contador_genero))
				{
					$string_condicao_genero.= "categoria_id <> ".$generos_ruins['genero_id'];
				}
				else if($qt_genero == 1)
				{
					$string_condicao_genero.= " AND categoria_id <> ".$generos_ruins['genero_id'];
				}
				else if($qt_genero == 0)
				{
					$string_condicao_genero = "";
				}
				else
				{
					$string_condicao_genero.= " AND categoria_id <> ".$generos_ruins['genero_id']." AND ";
				}
		
			}
			
			// Pesquisando o filtro de autores ruins para a pesquisa de últimos disponibilizados 
			$pesquisa_autores_ruins = new Pesquisar("tbl_autores_desapreciados","autor_id","usuario_id = ".$_SESSION['id']);
			$resultado_autores = $pesquisa_autores_ruins->pesquisar();
			
			// Quantidade de autores marcados pelo usuário como fora do seu gosto.
			$pesquisa_autores_ruins_quantidade = new Pesquisar("tbl_autores_desapreciados","COUNT(autor_id)As quantidade","usuario_id = ".$_SESSION['id']);
			$resultado_quantidade = $pesquisa_autores_ruins_quantidade->pesquisar();
			$array_autor = mysql_fetch_assoc($resultado_quantidade);
			$qt_autor = $array_autor['quantidade'];
			
			// Fazendo a condição da pesquisa 
			$string_condicao_autor = "";
			$contador_autor = 0;
			while($autores_ruins=mysql_fetch_assoc($resultado_autores))
			{	
				$contador_autor++;
				if(($qt_autor != 1) && ($qt_autor == $contador_autor))
				{
					$string_condicao_autor.= " 	autor_id <> ".$autores_ruins['autor_id'];
				}
				else if($qt_autor == 1)
				{
					$string_condicao_autor.= " AND autor_id <> ".$autores_ruins['autor_id'];
				}
				else if($qt_autor == 0)
				{
					$string_condicao_autor = "";
				}
				else
				{
					$string_condicao_autor.= " AND autor_id <> ".$autores_ruins['autor_id']." AND ";
				}
		
			}	

		$aspas = "'";
		
		if($_GET['acao'] == "Novo")
		{
			
			
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros < ".$id." AND tbl_lista_livros.status = 1 $string_condicao_autor $string_condicao_genero ORDER BY data_cadastro DESC LIMIT 6";
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
				$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$ultimos['id_livro']." AND usuario_id=".$_SESSION['id']);
				$resultado_marcacao = $pesquisar_marcacões->pesquisar();
				$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
				
				if($array_marcacao['tipo'] == 1)
				{
					$botões = ' 
								<button id = "Resultado'.$ultimos['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
								</ul>';
				}
				else if($array_marcacao['tipo'] == 2)
				{
					$botões = ' 
							<button id = "Resultado'.$ultimos['id_livro'].'" value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-sm">Já Li</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Já li</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
							</ul>';
				}
				else if($array_marcacao['tipo'] == 3)
				{
					$botões = ' 
							<button id = "Resultado'.$ultimos['id_livro'].'" value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Já Li</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Estou lendo</a></li>
							</ul>';
				}
				else
				{
					$botões = '
								<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
								</ul>';
				}
				$ct++;
				$id_ultima[] = $ultimos['id_lista_livros'];
				$return.= '
					<form>
						<section class="panel panel-default">
							<section class="panel panel-body">  
								<section class="row">
									<section class="col-md-5">
										<center>
											<section class = "bs-component" style = "maxheight: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
												</a>	
											</section>
										</center>
									</section>
									<section class="col-md-7">								
										<a href="?url=livro"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
										<a href="?url=livros_autores"> <h4>'.utf8_encode($ultimos['Autor']).' </h4></a>
										<a href="?url=livros_editora"> <h5>'.utf8_encode($ultimos['Editora']).' </h5></a>
										<a href="?url=perfil_usuario&cod='.$ultimos['id_usuario'].'"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
									</section>
								</section>
								<section class="row">
									<center>
										<section>
											<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" onClick="SolicitarLivro('.$aspas.''.$ultimos["id_lista_livros"].''.$aspas.','.$aspas.''.$ultimos['id_usuario'].''.$aspas.')">Solicitar Livro</button>
											<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
											<section class = "btn-group">
												'.$botões.'
											</section>
											<a href="?url=pesquisa&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_solicitar_livro" value = "Veja +"/></a>
										</section>
									</center>
								</section>
							</section>
						</section>
					</form>';
			}

			$lista_livros = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1],'novo'=> $resto, 'primeiro' => "oi");
			
			echo json_encode($lista_livros);
			
		}
		if($_GET['acao'] == "Antigo")
		{
		
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros <= ".$id." AND tbl_lista_livros.status = 1 $string_condicao_autor $string_condicao_genero ORDER BY data_cadastro DESC LIMIT 6";
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
				$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$ultimos['id_livro']." AND usuario_id=".$_SESSION['id']);
				$resultado_marcacao = $pesquisar_marcacões->pesquisar();
				$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
				
				if($array_marcacao['tipo'] == 1)
				{
					$botões = ' 
								<button id = "Resultado'.$ultimos['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
								</ul>';
				}
				else if($array_marcacao['tipo'] == 2)
				{
					$botões = ' 
							<button id = "Resultado'.$ultimos['id_livro'].'" value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-sm">Já Li</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Já li</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
							</ul>';
				}
				else if($array_marcacao['tipo'] == 3)
				{
					$botões = ' 
							<button id = "Resultado'.$ultimos['id_livro'].'" value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Já Li</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Estou lendo</a></li>
							</ul>';
				}
				else
				{
					$botões = '
								<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
								</ul>';
				}
				$ct++;
				$id_ultima[] = $ultimos['id_lista_livros'];
				$return.= '
					<form>
						<section class="panel panel-default">
							<section class="panel panel-body">  
								<section class="row">
									<section class="col-md-5">
										<center>
											<section class = "bs-component" style = "maxheight: 177px; width:120px;"> 
												<a href="?url=livro "class = "thumbnail">
													<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
												</a>	
											</section>
										</center>
									</section>
									<section class="col-md-7">								
										<a href="?url=livro"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
										<a href="?url=livros_autores"> <h4>'.utf8_encode($ultimos['Autor']).' </h4></a>
										<a href="?url=livros_editora"> <h5>'.utf8_encode($ultimos['Editora']).' </h5></a>
										<a href="?url=perfil_usuario&cod='.$ultimos['id_usuario'].'"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
									</section>
								</section>
								<section class="row">
									<center>
										<section>
											<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" onClick="SolicitarLivro('.$aspas.''.$ultimos["id_lista_livros"].''.$aspas.','.$aspas.''.$ultimos['id_usuario'].''.$aspas.')">Solicitar Livro</button>
											<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
											<section class = "btn-group">
												'.$botões.'
											</section>
											<a href="?url=pesquisa&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_solicitar_livro" value = "Veja +"/></a>
										</section>
									</center>
								</section>
							</section>
						</section>
					</form>';
			}

			$lista_livros = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1],'primeiro' => "oi");
			
			echo json_encode($lista_livros);
			
		}
	}

?>