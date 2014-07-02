<?php
	
		
		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		
		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();
		
		$conteudo_text =  $_POST['conteudo_text']; 	
		
		$pesquisa_dados = new Pesquisar("tbl_lista_livros lista
		  LEFT JOIN tbl_livro livro 
		  ON lista.livro_id = id_livro
		  lEFT JOIN tbl_fotos_livros
		  ON lista_livro_id = id_lista_livros
		  LEFT JOIN tbl_usuario usuario
		  ON usuario_id = id_usuario
		  LEFT JOIN tbl_editora editora 
		  ON editora_id = id_editora
		  LEFT JOIN tbl_autor autor 
		  ON autor_id = id_autor
		  LEFT JOIN tbl_categoria categoria
		  ON categoria_id = id_categoria",
		  "lista.id_lista_livros,
		  livro.nome AS NomeLivro, 
		  autor.nome AS NomeAutor, 
		  editora.nome AS NomeEditora,
		  categoria.nome AS NomeCategoria,
		  primeira_foto,
		  segunda_foto,
		  terceira_foto,
		  usuario.nome AS NomeUsuario",
		"livro.nome LIKE '%".$conteudo_text."%'
		  OR autor.nome LIKE '%".$conteudo_text."%'
		  OR editora.nome LIKE '%".$conteudo_text."%'
		  OR usuario.nome LIKE '%".$conteudo_text."%'
		  GROUP BY livro.nome
		  ORDER BY livro.nome");
		 
		$resultado_dados = $pesquisa_dados->pesquisar();
	
?>

<section id = "body_pesquisa">
	<section class="panel panel-default" style="width: 70%; margin-left: 15%;">
		<section class="panel-heading">
			<h4>Resultados</h4>
		</section>
		<section class="panel panel-body">
			<section class="row">
				<section class = "col-lg-6">
				<form method = "post" action = "?url=cadastra_livro_usuario">
				<?php 
				
						while($dados_pesq = mysql_fetch_assoc($resultado_dados))
						{
						echo  '<section class="panel panel-body">
						            <section class = "col-lg-4">	
						            	<section class = "bs-component" style = "height: 177px; width: 120px;"> 
						            		<a href="?url=livro" class = "thumbnail">
						            			<img src = "" alt = ""/> 
						            		</a>	
						            	</section>
						            	<section  class = "btn-group" style = "width: auto;">
						            		<input type = "submit" class="btn btn-primary btn-sm" name = "botao_solicitar_livro" value = "Solicitar Livro"/>
						            		<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro"/>															 
						            		<section class = "btn-group">
						            			<button type="button" class="btn btn-primary btn-sm">Eu...</button>
						            			<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						            				<ul class="dropdown-menu">
						            					<li><a href="">Quero ler</a></li>
						            					<li><a href="">Já li</a></li>
						            					<li><a href="">Estou lendo</a></li>
						            				</ul>	
						            		</section>
						            	</section>
						            </section>
						            <section class="col-lg-4">								
						            	<a href="?url=livro"> <h3>' .$dados_pesq['NomeLivro']. '</h3> </a>				  
						            	<a href="?url=livros_autores"> <h4>' .$dados_pesq['NomeAutor']. '</h4></a>
						            	<a href="?url=livros_editora"> <h5> ' .$dados_pesq['NomeEditora'].  '</h5></a>
						            </section>
								</section>';
						}
									
				?>

					
				</form>
				</section>
			<br>
			<section class="row">			
			</section>
                      <ul class="pager">
                        <li class="previous disabled"><a href="#">← Antigo</a></li>
                        <li class="next"><a href="#">Nova →</a></li>
                      </ul>
		</section>
	</section>
</section>