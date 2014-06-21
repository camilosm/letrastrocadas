<?php
    
	if(isset($_POST['alterarSenha'])){
	
	    session_start();
		
		include("class_editar_caracteres.php");
		include("classes/class_update.php");
		
		
		$id = $_SESSION['id'];
		$senhanova = $_POST['senhaNova'];
		
		$valores_alterar_senha = "senha ='".$senhanova."'";
		$condicao = "id_usuario = $id ";
		
		$alterar_senha = new Alterar("tbl_usuario", $valores_alterar_senha, $condicao);
		$resposta = $alterar_senha->alterar();
		
		if($resposta)
		{
			$resultado =  "OK";
		}
		else
		{
			$resultado = "Erro";
		}
    }
?>