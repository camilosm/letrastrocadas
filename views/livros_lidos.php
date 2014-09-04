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
		$campos = "id_marcacao,imagem_livros,livro.nome AS Livro,autor.nome AS Autor,editora.nome As Editora, livro.sinopse As sinopse";
		$tabelas = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_marcacao = 2 AND id_editora = editora_id AND id_autor = autor_id AND id_livro = livro_id";
		$pesquisar_livros = new Pesquisar($tabelas,$campos,"id_marcacao > ".$codigo." AND usuario_id =".$_SESSION['id']." LIMIT 7");
		$resultado = $pesquisar_livros->pesquisar();
		
		$pesquisar_quantidade = new Pesquisar($tabelas,"COUNT(id_marcacao) As quantidade","usuario_id =".$_SESSION['id']);
		$resultado_quantidade = $pesquisar_quantidade->pesquisar();
		
		$pesquisa_quantidade=mysql_fetch_array($resultado_quantidade);
		$quantidade = $pesquisa_quantidade['quantidade'];
		
		$id =array();
		$nome = array();
		$imagem = array();
		$editora = array();
		$autor = array();
		$sinopse = array();
		
		while($pesquisa=mysql_fetch_array($resultado))
		{
			$id[] = $pesquisa['id_marcacao'];
			$nome[] = $pesquisa['Livro'];
			$imagem[] = $pesquisa['imagem_livros'];
			$editora[] = $pesquisa['Editora'];
			$autor[] = $pesquisa['Autor'];
			$sinopse[] = $pesquisa['sinopse'];
		}
	}
	else
	{	
		//Emite um alerta (não tá funcioando ¬¬) pois eles não tem acesso a essa página
		echo "
			<script type='text/javascript'>
				alert('Você não tem permissão para acessar essa página');
			</script>";
		
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


<article style = "width:80%;  margin-left:10%;">
     <section class="panel panel-default" >
        <section class="panel-heading">Livros lidos</section>
		
             <section class="panel-body">
			    <section class = "row">
					<section class = "col-lg-4" style = "width: auto;">	
					<section class = "bs-component"> 
							<a class = "thumbnail">
								<img src = "<?php echo $imagem[0];?>" alt = "<?php echo $nome[0];?>" height = "177px" width = "120px"/> 
							</a>
					</section>
					</section>
					<section class = "col-lg-4">
							<a> <h3> <?php echo utf8_encode($nome[0]); ?> </h3> </a>				  
							<a> <h4> <?php echo utf8_encode($autor[0]); ?> </h4></a>
						    <a> <h5> <?php echo utf8_encode($editora[0]); ?> </h5></a>
							<form method="post" action="?url=alterar_livro_usuario&cod=<?php echo $id[0];?>">
							<input type="submit" class="btn btn-primary btn-sm" name="alterarlivro" value="Alterar Livro"/>
							</form>
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
                        <li class="next"><a href="?url=livros_lidos&livro= <?php 
																					if(!$quantidade < 7)
																					echo $id[6];
																				?>">Próximo →</a></li>
                   </ul>
				   
             </section>
			 
       </section>

	   
	  
</article>