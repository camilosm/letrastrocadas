<?php
	session_start();
	
	if(isset($_FILES["file"]))
	{
		$destino = $_FILES["file"]["tmp_name"];
		$nome = "tmp_profile_".$_SESSION["id"];
		$largura = 200;
		$pasta = "/content/imagens/fotos_perfil/tmp/";
		include("../views/classes/class_upload.php");
		upload($destino,$nome, $largura, $pasta);
		
		echo ($pasta."/".$nome);
		exit(false);
	}
	
?>
