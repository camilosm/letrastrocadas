<?php
	
	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{ 	
			include("classes/class_banco.php");
			include("classes/class_pesquisar.php");
			
			$codigo_ultimo = $_GET['livro'];
			if(!empty($codigo_ultimo))
			{
				$codigo = $codigo_ultimo;
			}
			else
			{
				$codigo = "0";
			}
			
			$bd = new Banco();
			$campos = "id_lista_livros,imagem_livros,livro.nome AS Livro,autor.nome AS Autor,editora.nome As Editora, livro.sinopse As sinopse";
			$tabelas = "tbl_lista_livros lista INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id AND id_livro = livro_id";
			$pesquisar_livros = new Pesquisar($tabelas,$campos,"id_lista_livros > ".$codigo." AND usuario_id =".$_SESSION['id']." LIMIT 7");
			$resultado = $pesquisar_livros->pesquisar();
			
			$pesquisar_quantidade = new Pesquisar($tabelas,"COUNT(id_lista_livros) As quantidade","usuario_id =".$_SESSION['id']);
			$resultado_quantidade = $pesquisar_quantidade->pesquisar();
			
			$pesquisa_quantidade=mysql_fetch_array($resultado_quantidade);
			$quantidade = $pesquisa_quantidade['quantidade'];
			
			$id = array();
			$nome = array();
			$imagem = array();
			$editora = array();
			$autor = array();
			$sinopse = array();
			
			while($pesquisa=mysql_fetch_array($resultado))
			{
				$id[] = $pesquisa['id_lista_livros'];
				$nome[] = $pesquisa['Livro'];
				$imagem[] = $pesquisa['imagem_livros'];
				$editora[] = $pesquisa['Editora'];
				$autor[] = $pesquisa['Autor'];
				$sinopse[] = $pesquisa['sinopse'];
			}
		}
	else
	{	
		//Redireciona pra página principal
		if($_SESSION['nivel_acesso'] == 2)
		{
			header("location: ?url=home_admin");
		}
		else
		{
			header("location: ?url=home_visitante");
		}
	}
?>
<section id = "wrap">

     <section class="panel panel-default" style = "width:70%; height:60%; position:relative; left:15%;">
        <section class="panel-heading">Livros de <?php echo utf8_encode($editora[0]);?></section>
		
            <section class="panel-body">
			    <section class = "row">
					<section class = "col-lg-4" style = "width: auto;">	
					<section class = "bs-component"> 
							<a class = "thumbnail">
								<img src = "<?php echo $imagem[0];?>" alt = "<?php echo utf8_encode($nome[0]);?>" height = "177px" width = "120px"/> 
							</a>
					</section>
					</section>
					<section class = "col-lg-4">
							<a> <h3> <?php echo utf8_encode($nome[0]); ?> </h3> </a>				  
							<a> <h4> <?php echo utf8_encode($autor[0]); ?> </h4></a>
						    <a> <h5> <?php echo utf8_encode($editora[0]); ?> </h5></a>
							
					</section>
					<section class = "col-lg-4" style = "width:48%;">
						<textarea class="form-control" rows="9" readonly>
						<?php echo utf8_encode($sinopse[0]);?>
						</textarea>
					</section> 
					
				</section>
				<br>
				    <?php
					
						for($contador=0;$contador<=$quantidade-1;$contador++)
						{
							echo '<img src = "'.$imagem[$contador].'" alt = "'.$nome[$contador].'" height = "177px" width = "120px">'; 
						}
					
					?>
				   

                   <ul class="pager">
                        <li class="previous disabled"><a href="#">← Anterior</a></li>
                        <li class="next"><a href="?url=livros_editora&livro= <?php 
																					if(!$quantidade < 7)
																					echo $id[6];
																				?>">Próximo →</a></li>
                   </ul>
				   
             </section>
			 
       </section>

</section>
<br><br>