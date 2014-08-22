<?php
	session_start();
	header('Content-Type: application/json');
	if(isset($_FILES["file"]))
	{	
		
		$origem = $_FILES["file"]["tmp_name"];
		$nome = "tmp_profile_".$_SESSION["id"];
		$largura = 200;
		$pasta = "content/imagens/fotos_perfil/tmp/";
		include("../views/classes/class_upload.php");
		$caminho = $pasta."/".$nome;

		$upload = new Upload($_FILES['foto'], 200, 200, $pasta); 
		$upload->salvar($nome); 
		echo json_encode(array("caminho" => $caminho, "caminho_a" => $caminho));

	}
	
?>
