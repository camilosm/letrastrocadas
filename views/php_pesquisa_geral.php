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
	$dados_autor = mysql_fetch_assoc($resultado_dados_autor);
	
	$pesquisa_dados_editora = new Pesquisar("tbl_editora","*"," nome LIKE '%".$conteudo_text."%'");
	$resultado_dados_autor = $pesquisa_dados_autor->pesquisar();
	$dados_autor = mysql_fetch_assoc($resultado_dados_autor);
		
	$pesquisa_dados_livros = new Pesquisar("tbl_livro livro JOIN tbl_autor autor JOIN tbl_editora editora ON editora_id = id_editora",
	"livro.nome AS nome_livro, autor.nome AS nome_autor, editora.nome AS nome_editora",
	" livro.nome LIKE '%".$conteudo_text."%'");
	$resultado_dados_livros = $pesquisa_dados_livros->pesquisar();
	$dados_livros = mysql_fetch_assoc($resultado_dados_livros);
	
	$pesquisa_dados_usuarios = new Pesquisar("tbl_usuario","nome,avaliacoes_negativas,avaliacoes_positivas,cidade,uf"," nome LIKE '%".$conteudo_text."%'");
	$resultado_dados_usuarios = $pesquisa_dados_usuarios->pesquisar();
	$dados_livros = mysql_fetch_assoc($resultado_dados_livros);
	
	
	

/*SELECT livro.nome, autor.nome, editora.nome 
FROM tbl_livro livro JOIN tbl_autor autor JOIN tbl_editora editora ON editora_id = id_editora
AND autor_id = id_autor
WHERE livro.nome LIKE '% algo %' OR autor.nome LIKE '% algo %' OR editora.nome LIKE '% algo %';

SELECT livro.nome,autor.nome FROM tbl_livro livro JOIN tbl_autor autor;	*/
	
	

?>

SELECT livro.nome AS NomeLivro, imagem_livros AS imagem_livro, 
autor.nome AS AutorNome, 
editora.nome AS EditoraNome, usuario.nome AS UsuarioNome, 
ft_livro.primeira_foto AS PrimeiraFoto,
ft_livro.segunda_foto AS SegundaFoto, 
ft_livro.terceira_foto AS TerceiraFoto
FROM tbl_livro livro JOIN tbl_autor autor JOIN tbl_editora editora
JOIN tbl_usuario usuario JOIN tbl_lista_livros lista
JOIN tbl_fotos_livros ft_livro
ON livro.editora_id = id_editora
AND livro.autor_id = id_autor
AND lista.livro_id = id_livro
AND lista.usuario_id = id_usuario
AND ft_livro.lista_livro_id = id_lista_livros
WHERE livro.nome LIKE '%a%' OR
autor.nome LIKE '%%' OR
usuario.nome LIKE '%%' OR
editora.nome LIKE '%%'
ORDER BY livro.nome;


















