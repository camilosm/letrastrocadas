<?php
	function upload($origem, $nome, $largura, $pasta){
		
		$img = imagecreatefromjpeg($origem);
		$x = imagesx($img);
		$y = imagesy($img);
		$altura = ($largura * $y) / $x;
		
		$novaImagem = imagecreatetruecolor($largura, $altura);
		imagecopyresampled($novaImagem, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
		
		$pastas = explode('/',$pasta);
		$caminho = "/wamp/www/Letras_Trocadas";
		
		foreach($pastas as $p)
		{
			$caminho .= "/".$p;
			$caminho;
			if(!is_dir($caminho))
			{
				mkdir($caminho);
				chmod("0777",$caminho);
			}			
		}
		$caminho = $caminho."/".$nome.".jpg";
		
		imagejpeg($novaImagem, $caminho);
		
		imagedestroy($img);
		imagedestroy($novaImagem);
		
		return $caminho;
		
	}
?>