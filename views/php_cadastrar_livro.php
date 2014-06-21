<?php 
	// Nem vou comentar isso aqui por que vai ser mais fácil exlcuir tudo e começar do zero do que tentar concertar
	if(isset($_POST['cadastrarLivro']))
	{
		include("class_editar_caracteres.php");
		include("classes/class_insert.php");
		
		include ("classes/upload.class.php");		    // inclusão da classe
		$up = new upload();			    // instância do objeto
		$up->pasta     = "content/imagens/livros_gerais"; 	            // pasta de destino 
		$up->nome      = $_FILES['file']['name'];   // nome da imagem enviada do form
		$up->tmp_name  = $_FILES['file']['tmp_name'];// arquivo temporário
		$up->img_marca = "teste.png";		     // caminho da imagem que será marca d'agua (.png)
		$up->largura   = "120";			     // máxima largura para a nova foto
		$up->altura    = "177";			     // máxima altura para a nova foto
		$destino = $up->uploadArquivo();			     // execução do método
		if($destino == "Tamanho ou formato da imagem não suportado(Aceitamos somente JPG)")
		{
			echo $destino;
		}
		else
		{
		
			$nome = $_POST['nome'];
			$edicao = $_POST['edicao'];
			$isbn = $_POST['isbn'];
			$cmbEditora = $_POST['cmbEditora'];
			$cmbAutor = $_POST['cmbAutor'];
			$cmbGenero = $_POST['cmbGenero'];
			$sinopse = $_POST['sinopse'];
			$numero_paginas = $_POST['numero_paginas'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
			
			$editar_edicao = new EditarCaracteres($edicao);
			$edicao = $editar_edicao->sanitizeString($_POST['edicao']);
			
			$editar_isbn = new EditarCaracteres($isbn);
			$isbn = $editar_isbn->sanitizeString($_POST['isbn']);
			
			$editar_cmbEditora = new EditarCaracteres($cmbEditora);
			$cmbEditora = $editar_cmbEditora->sanitizeString($_POST['cmbEditora']);
			
			$editar_cmbAutor = new EditarCaracteres($cmbAutor);
			$cmbAutor = $editar_cmbAutor->sanitizeString($_POST['cmbAutor']);
			
			$editar_cmbGenero = new EditarCaracteres($cmbGenero);
			$cmbGenero = $editar_cmbGenero->sanitizeString($_POST['cmbGenero']);
			
			$editar_sinopse = new EditarCaracteres($sinopse);
			$sinopse = $editar_sinopse->sanitizeString($_POST['sinopse']);
			
			$editar_numero_paginas = new EditarCaracteres($numero_paginas);
			$numero_paginas = $editar_numero_paginas->sanitizeString($_POST['numero_paginas']);
			
			$valores = "NULL,'".$nome."','content/imagens/livros_gerais/".$destino."',".$edicao.",".$isbn.",'".$sinopse."',1,0,0,0,".$numero_paginas.",".$cmbEditora.",".$cmbAutor.",".$cmbGenero."";
			$cadastrar_livro = new Inserir("tbl_livro",$valores);
			$res = $cadastrar_livro->inserir();
			if($res)
			{
				echo "Livro cadastrado com sucesso";
			}
			else
			{
				echo "Erro ao cadastrar o livro no banco de dados";
			}
		}
	}
 
?>