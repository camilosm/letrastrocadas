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
	
?>

















