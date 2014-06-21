<?php
	if(isset($_POST["caminho"]))
	{
		$ext =  end($_POST["caminho"].split('.'));
		$imagem = base64_encode(fopen ( $_POST["caminho"] , 'r',false));
		echo "data:image/".$ext.";base64,".$imagem;
		
	}
?>