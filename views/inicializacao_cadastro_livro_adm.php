<?php
	
	include ("classes/class_pesquisar.php");
	
	// Realiza as pesquisas para a gente poder preencher os combobox da página de cadastro livro do adm
	$pesquisar_editora = new Pesquisar("tbl_editora","*","1=1");
	$resultado_editora = $pesquisar_editora->pesquisar();
	
	$pesquisar_autor = new Pesquisar("tbl_autor","*","1=1");
	$resultado_autor = $pesquisar_autor->pesquisar();
	
	$pesquisar_genero = new Pesquisar("tbl_categoria","*","1=1");
	$resultado_genero = $pesquisar_genero->pesquisar();

?>