<script type="text/javascript">
	function Abrir(id)
	{
		$.ajax({
			
			url : "ajax/livros_disponibilizados.php?livro="+id,
			dataType : "json",
			success : function(data){
				document.getElementById('livro').innerHTML = data.section;
			},
			error : function(data){
			alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
			}
	
		});
		
	}
</script>
<?php
	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{
			include("classes/class_banco.php");
			include("classes/class_pesquisar.php");
			
			$bd = new Banco();
			$campos = "id_lista_livros,imagem_livros,livro.nome AS Livro,livro.id_livro as id_livro,autor.nome AS Autor,editora.nome As Editora, livro.sinopse As sinopse";
			$tabelas = "tbl_lista_livros lista INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id AND id_livro = livro_id";
			$pesquisar_livros = new Pesquisar($tabelas,$campos,"usuario_id =".$_SESSION['id']);
			$resultado = $pesquisar_livros->pesquisar();
			
			$pesquisar_quantidade = new Pesquisar($tabelas,"COUNT(id_lista_livros) As quantidade","usuario_id =".$_SESSION['id']);
			$resultado_quantidade = $pesquisar_quantidade->pesquisar();
			
			$pesquisa_quantidade=mysql_fetch_assoc($resultado_quantidade);
			$quantidade = $pesquisa_quantidade['quantidade'];
			
			$id =array();
			$nome = array();
			$id_livro = array();
			$imagem = array();
			$editora = array();
			$autor = array();
			$sinopse = array();
			
			while($pesquisa=mysql_fetch_assoc($resultado))
			{
				$id[] = $pesquisa['id_lista_livros'];
				$id_livro = $pesquisa['id_livro'];
				$nome[] = $pesquisa['Livro'];
				$imagem[] = $pesquisa['imagem_livros'];
				$editora[] = $pesquisa['Editora'];
				$autor[] = $pesquisa['Autor'];
				$sinopse[] = $pesquisa['sinopse'];
			}

			$aspas = "'";
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

<section id = "body_livros_lidos" style = "width:80%; margin-left:10%;">
     <section class="panel panel-default">
        <section class="panel-heading">Livros diponibilizados</section>
			<?php
				if($quantidade >= 1)
				{
			?>
            <section class="panel-body">
			    <section class = "row" id="livro">
					<section class = "col-lg-4" style = "width: auto;">	
						<section class = "bs-component"> 
								<a class = "thumbnail">
									<img src = "<?php echo $imagem[0];?>" alt = "<?php echo $nome[0];?>" height = "177px" width = "120px">
								</a>
						</section>
					</section>
					<section class = "col-lg-4">
							<a> <h3> <?php echo utf8_encode($nome[0]); ?> </h3> </a>				  
							<a> <h4> <?php echo utf8_encode($autor[0]); ?> </h4></a>
						    <a> <h5> <?php echo utf8_encode($editora[0]); ?> </h5></a>
							<form method="post" action="?url=alterar_livro_usuario&cod=<?php echo $id_livro[0];?>&lista=<?php echo $id[0] ;?>">
							<input type="submit" class="btn btn-primary btn-sm" name="alterarlivro" value="Alterar Livro"/>
							</form>
					</section>
					<section class = "col-lg-4" style = "width:48%;">
						<textarea class="form-control" rows="9" readonly>
						<?php echo $sinopse[0];?>
						</textarea>
					</section> 
				</section>
				<br>
				<section id = "imagens" style = "position:relative; left:3%;">
					<?php
						for($contador=0;$contador<=$quantidade-1;$contador++)
						{
							echo '
							<section class="col-lg-2">
								<a class = "thumbnail" onClick="Abrir('.$aspas.''.$id_livro[$contador].''.$aspas.')">
									<img src = "'.$imagem[$contador].'" alt = "'.$nome[$contador].'" height = "177px" width = "120px"/> 
								</a>
							</section>'; 
						}
					?>
				</section>
			</section>
			<?php
				}
				else
				{
			?>
			<section class="alert alert-dismissable alert-info">
				<strong>Você não adicionou nenhum livro a sua estante de livros lidos! Para adicionar é só pesquisar o livro, ir no botão "Eu..." e clicar em "Lido"!</strong>
			</section>
			<?php
				}
			?>
       </section>
</section>