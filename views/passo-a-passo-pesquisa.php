<?php
	
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

<article id  = "body_cadastra_livro_usu" style = "width:60%; margin-left: 20%;">
	<fieldset>
		<form  method="post" action=""  role="search "enctype="multipart/form-data">
			<legend>Pesquise o livro e clique em disponibilizar livro</legend>
			<section class="row">
				<section class="col-xs-9">
					<section class="form-group">
						<input type="text" name = "pesquisa" class="form-control" placeholder="Procurar">
					</section>
				</section>
				<section class="col-md-offset-11">
					<button type="submit" name = "pesquisar_livro" class="btn btn-default">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</section>
			</section>
		</form>
					
		<?php
		
			if(isset($_POST['pesquisar_livro']))
			{
				while($dados=mysql_fetch_assoc($resultado))
				{
					echo 
					'<br><br>
					<section class="row">
						<section class="col-md-6">
							<section class="thumbnail">
								<a href="?url=livro&&cod='.$dados['id_livro'].'" >
									<img src="'.$dados['imagem_livros'].'" alt="'.utf8_encode($dados['Livro']).'" width="20%">
									<p align="center">'.utf8_encode($dados['Livro']).'</p> 
								</a>
							</section>
						</section>
						<section class="col-md-6" style="height: 50%; margin-top:5%;">
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
</article>