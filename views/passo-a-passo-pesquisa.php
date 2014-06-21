<?php
	
	//Inicia a sessão
	session_start();
	
	
	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{ 
		if(isset($_POST['pesquisar_livro']))
		{
			include("classes/class_banco.php");
			include("class_editar_caracteres.php");
			include("classes/class_pesquisar.php");
			
			$bd = new Banco();
			
			$nome = $_POST['pesquisa'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = $editar_nome->sanitizeStringNome($_POST['pesquisa']);
			
			$campos = "id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
			$tabelas = "tbl_livro livro JOIN tbl_editora editora JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id";
			$pesquisar_livros = new Pesquisar($tabelas,$campos,"livro.nome like '%$nome%'");
			$resultado = $pesquisar_livros->pesquisar();		
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

<article id  = "body_cadastra_livro_usu" style = "width:60%;height:60%;position:relative;left:30%;">		
	<section class="navbar-form navbar-left" role="search">
		<fieldset>
			<form  method="post" action=""  enctype="multipart/form-data">
					<legend>Pesquise o livro e clique em disponibilizar livro</legend>
					<section class="form-group">
						<input type="text" name = "pesquisa" class="form-control" placeholder="Procurar">
					</section>
					<button type="submit" name = "pesquisar_livro" class="btn btn-default">
						<span class="glyphicon glyphicon-search"></span>
					</button>
			</form>
			<?php
				if(isset($_POST['pesquisar_livro']))
				{
					while($dados=mysql_fetch_array($resultado))
					{
						echo 
						'<section class="col-lg-10">
							<section class="thumbnail">
								<a href="?url=livro&&cod='.$dados['id_livro'].'" >
									<img src="content/imagens/livros_gerais/o_morro_dos_ventos_uivantes.jpg" alt="" width="35%">
									<p align="center">'.$dados['Livro'].'</p> 
								</a>
								<section style="margin-left:10%;">
									<form method="post" action="?url=passo-a-passo-dados-usuario&cod='.$dados['id_livro'].'">
										<input type = "submit" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" />
									</form>
									<section class = "btn-group">
										<button type="button" class="btn btn-primary btn-sm" disabled>Eu...</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" disabled><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>Quero ler</li>
											<li>Já li</li>
											<li>Estou lendo</li>
										</ul>	
									</section>
								</section>
							</section>
						</section>';
					}
				}
			?>
		</fieldset>
	</section>
</article>