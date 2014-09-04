<?php
    
	if(isset($_POST['alterarSenha']))
	{
	
		include("class_editar_caracteres.php");
		include("classes/class_update.php");
		include("classes/class_banco.php");
		
		$banco = new Banco();
		
		$id = $_SESSION['id'];
		$senhanova = $_POST['senhaNova'];
		
		$valores_alterar_senha = "senha ='".$senhanova."'";
		$condicao = "id_administrador = $id ";
		
		if(strlen($senhanova) < 8)
		{
			echo '<section class="alert alert-dismissable alert-warning">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>Ixi</strong> Essa senha tá muito curta, digita uma com, <strong>no mínimo</strong> 8 dígitos.
				</section>';
		}
		else
		{
			$alterar_senha = new Alterar("tbl_administrador", $valores_alterar_senha, $condicao);
			$resposta = $alterar_senha->alterar();
			
			 if($resposta)
			{
				echo '<section class="alert alert-dismissable alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>Eba!</strong> Senha alterada com sucesso o/
					</section>';
			}
			else
			{
				echo '<section class="alert alert-dismissable alert-warning">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>Aném</strong>, alguma coisa deu errado, tenta de novo aí.
					</section>';				
			}
		}
    }
?>