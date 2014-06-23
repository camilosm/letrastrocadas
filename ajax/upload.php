<?php
	session_start();
	header('Content-Type: application/json');
	if(isset($_FILES["file"]))
	{
		$origem = $_FILES["file"]["tmp_name"];
		$nome = "tmp_profile_".$_SESSION["id"];
		$largura = 200;
		$pasta = "content/imagens/fotos_perfil/tmp";
		include("../views/classes/class_upload.php");
		echo json_encode(array("caminho" => upload($origem,$nome, $largura, $pasta)));
	}
	
?>
