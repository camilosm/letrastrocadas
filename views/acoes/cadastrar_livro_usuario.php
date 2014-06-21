<?php

	//if(isset($_POST['confirmaLivroUsuario']))
	//{
		//include("classes/class_banco.php");
		//include("classes/class_insert.php");
		//include("class_editar_caracteres.php");
		
		include("../classes/class_banco.php");
		include("../classes/class_insert.php");
		include("../class_editar_caracteres.php");
	
		$bd = new Banco();
		session_start();
		
		$id = 1;
		$ano = $_POST['ano'];
		$estado = $_POST['estado'];
		$imagem1 = $_SESSION['imagem1'];
		$imagem2 = $_SESSION['imagem2'];
		$imagem3 = $_SESSION['imagem3'];
		
		//Desfazer a minha gambiarra érr quer dizer meu recurso técnico
		/*unset ($_POST['livro']);
		unset ($_POST['edicao']);
		unset ($_POST['isbn']);
		unset ($_POST['ano']);
		unset ($_POST['estado']);
		unset ($_POST['imagem1']);
		unset ($_POST['imagem2']);
		unset ($_POST['imagem3']);*/
		
		$editar_id = new EditarCaracteres($id);
		$id = $editar_id->sanitizeString($id);
		
		$editar_estado = new EditarCaracteres($estado);
		$estado = $editar_estado->sanitizeStringNome($estado);
		
		$editar_ano = new EditarCaracteres($ano);
		$ano = $editar_ano->sanitizeString($ano);
		
		$campos = "NULL,$id,".$_SESSION['id'].",'$ano','$estado'";	
		
		$cadastrar_livros = new Inserir("tbl_lista_livros",$campos);
		echo "OI";
		$resposta = $cadastrar_livros->inserir();
		
	//}
	//else
	//{
		//header("location: ?url=index");
	//}

?>