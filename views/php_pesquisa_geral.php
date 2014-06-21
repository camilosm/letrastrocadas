<?php

	session_start();
	$id = $_SESSION['id'];
	$conteudo_text = $_POST['conteudo_text'];
	
	include("classes/class_pesquisar.php");
	include("classes/class_banco.php");
	
	//Instancia e faz conexão com o banco de dados
	$banco = new Banco();
		
	$pesquisa_dados_autor = new Pesquisar("tbl_autor","*"," nome LIKE '%".$conteudo_text."%'");
	$resultado_dados_autor = $pesquisa_dados_autor->pesquisar();
	$dados_autor = mysql_fetch_array($resultado_dados_autor);
	
	$pesquisa_dados_editora = new Pesquisar("tbl_editora","*"," nome LIKE '%".$conteudo_text."%'");
	$resultado_dados_autor = $pesquisa_dados_autor->pesquisar();
	$dados_autor = mysql_fetch_array($resultado_dados_autor);
		
	$pesquisa_dados_livros = new Pesquisar("tbl_livro livro JOIN tbl_autor autor JOIN tbl_editora editora ON editora_id = id_editora",
	"livro.nome AS nome_livro, autor.nome AS nome_autor, editora.nome AS nome_editora",
	" livro.nome LIKE '%".$conteudo_text."%'");
	$resultado_dados_livros = $pesquisa_dados_livros->pesquisar();
	$dados_livros = mysql_fetch_array($resultado_dados_livros);
	
	$pesquisa_dados_usuarios = new Pesquisar("tbl_usuario","nome,avaliacoes_negativas,avaliacoes_positivas,cidade,uf"," nome LIKE '%".$conteudo_text."%'");
	$resultado_dados_usuarios = $pesquisa_dados_usuarios->pesquisar();
	$dados_livros = mysql_fetch_array($resultado_dados_livros);
	
	
	

/*SELECT livro.nome, autor.nome, editora.nome 
FROM tbl_livro livro JOIN tbl_autor autor JOIN tbl_editora editora ON editora_id = id_editora
AND autor_id = id_autor
WHERE livro.nome LIKE '% algo %' OR autor.nome LIKE '% algo %' OR editora.nome LIKE '% algo %';

SELECT livro.nome,autor.nome FROM tbl_livro livro JOIN tbl_autor autor;	*/
	
	

?>




















