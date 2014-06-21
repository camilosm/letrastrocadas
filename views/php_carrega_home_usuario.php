<?php

	// Conexão com o banco
	include("/classes/class_banco.php");

	// Dá include na classe de pesquisa
	include("/classes/class_pesquisar.php");

	// Instancia banco
	$bd = new Banco();

	//Instancia a classe Pesquisa
	$tabela = "tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_autor = autor_id ON editora_id = id_editora";
	$pesquisardestaques = new Pesquisar($tabela,"livro.nome,editora.nome,autor.nome,id_livro,","1=1");
	// Realiza a pesquisa e retorna para a variável resultado
	$resultado = $pesquisardestaques->pesquisar();
	
	$nome = new array();
	$editora = new array();
	$autor = new array();
	$id = new array();
	
	//Varre a pesquisa e passa valores para os arrays
	while($dados = mysql_fetch_row($resultado))
	{
		
		$nome[] = $dados[0];
		$editora[] = $dados[1];
		$autor[] = $dados[2];
		$id[] = $dados[3];
		
	}
?>