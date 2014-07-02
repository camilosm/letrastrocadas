<?php

	$conteudo_text = $_POST['conteudo_text'];
	
	include("classes/class_pesquisar.php");
	include("classes/class_banco.php");
	
	//Instancia e faz conexão com o banco de dados
	$banco = new Banco();
		
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
      GROUP BY livro.nome");
	 
	$resultado_dados = $pesquisa_dados->pesquisar();
	$dados_pesq = mysql_fetch_assoc($resultado_dados);
	
?>

















