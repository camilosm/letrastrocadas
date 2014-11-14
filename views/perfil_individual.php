<?php 
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		$id = $_SESSION['id'];	
		
		/* Pesquisa de dados Básicos usuário */
		
	    $pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,email,foto,idade,avaliacoes_negativas,avaliacoes_positivas,uf,cidade", " id_usuario = $id");
	    $resul_pesquisa = $pesquisa_dados->pesquisar();
	    $pesq = mysql_fetch_assoc($resul_pesquisa);
		
	    $nome = $pesq['nome'];
	    $foto = $pesq['foto'];
	    $idade = $pesq['idade'];
	    $uf = $pesq['uf'];
	    $cidade = $pesq['cidade'];	
	    $avaliacoes_negativas = $pesq['avaliacoes_negativas'];
	    $avaliacoes_positivas = $pesq['avaliacoes_positivas'];
	    $id_p = $pesq['id_usuario'];
	    $email_p = $pesq['email'];
		
		/* Pesquisa de livros que o usuário disponibilizou */ 
		
		$pesquisa_dados_lista_livros = new Pesquisar("tbl_usuario usu JOIN tbl_livro liv JOIN tbl_lista_livros list_liv ON list_liv.livro_id = id_livro AND list_liv.usuario_id = id_usuario","imagem_livros,liv.nome as Nome,id_lista_livros","id_usuario = $id GROUP BY id_lista_livros");
		$resul_pesquisa_lista_livros = $pesquisa_dados_lista_livros->pesquisar();
		
		/* Pesquisa de livros marcados como quero ler, lidos, lendo */

		$pesquisar_quero_ler = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 1 AND usuario_id = $id");
		$resul_quero_ler = $pesquisar_quero_ler->pesquisar();	

		$pesquisar_ja_li = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 2 AND usuario_id = $id");
		$resul_ja_li = $pesquisar_ja_li->pesquisar();

		$pesquisar_lendo = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 3 AND usuario_id = $id");
		$resul_lendo = $pesquisar_lendo->pesquisar();

		/* Pesquisa das preferências do usuário */

		$pesquisar_autor = new Pesquisar('tbl_autor','*','1=1 GROUP BY nome ASC');
		$resultado_autor = $pesquisar_autor->pesquisar();

		$pesquisa_generos_fav = new Pesquisar('tbl_generos_favoritos','*',"usuario_id = $id");
		$res_genero_fav = $pesquisa_generos_fav->pesquisar();

		$pesquisa_autor_fav = new Pesquisar('tbl_autores_favoritos','*',"usuario_id = $id");
		$res_autor_fav = $pesquisa_autor_fav->pesquisar();

		$pesquisa_generos_des = new Pesquisar('tbl_generos_desapreciados','*',"usuario_id = $id");
		$res_genero_des = $pesquisa_generos_des->pesquisar();

		$pesquisa_autor_des = new Pesquisar('tbl_autores_desapreciados','*',"usuario_id = $id");
		$res_autor_des = $pesquisa_autor_des->pesquisar();
?>

<article id = "body_perfil_usuario" style="width: 80%; margin-left: 10%">
	<section class="panel panel-default">
		<section class="panel-body">
			<table class="table table-striped table-hover" style = "table-layout:fixed">
				<tbody>
					<tr>
						<td id = "foto_usuario" rowspan = "3"> <img src = " <?php echo $foto; ?>" width="100%" ></td>
						<td id = "nome_usuario" colspan = "4"><b>Nome:&nbsp;</b> <?php echo utf8_encode($nome); ?> </td>
					</tr>
					<tr>
						<td id = "cidade_usuario" colspan = "2"><b> Cidade:&nbsp;</b> <?php echo utf8_encode($cidade); ?> </td>
						<td id = "uf_usuario"><b>UF:&nbsp;</b> <?php echo utf8_encode($uf); ?></td>
						<td id = "idade_usuario"> <b>Idade:&nbsp;</b> <?php  echo utf8_encode($idade);?> </td>
					</tr>
					<tr>
						<td colspan="5">
							<ul class="nav nav-tabs" style="margin-bottom: 15px;">
								<li class="active"><a href="#livrosdisponiveis" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Livros Disponibilidados </a></li>
								<li><a href="#jali" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Já li</a></li>
								<li><a href="#queroler" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Quero Ler</a></li>
								<li><a href="#lendo" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Lendo </a></li>
							</ul>
							<section id="myTabContent" class="tab-content">
								<section class="tab-pane fade active in" id="livrosdisponiveis" style="max-width:100%;overflow:auto;">
										<?php
											$qt = 0;		
											while($pesq_lista_livro = mysql_fetch_assoc($resul_pesquisa_lista_livros))
											{
												$qt++;
												echo '<img src ="'.$pesq_lista_livro['imagem_livros'].'" alt = "'.$pesq_lista_livro['nome'].'" height = "177px" width = "120px">';
											}
											if($qt == 0)
											{
												echo 'Nenhum livro adicionado';
											}
											
										?>
								</section>
								<section class="tab-pane fade" id="jali" style="max-width:100%;overflow:auto;">
									<?php
										$qt_ja_li = 0;	
										while($pesq_ja_li = mysql_fetch_assoc($resul_ja_li))
										{
											$qt_ja_li++;
											echo '<img src ="'.$pesq_ja_li['imagem_livros'].'" alt = "'.$pesq_ja_li['nome'].'" height = "177px" width = "120px">';
										}
										
										if($qt_ja_li == 0)
										{
											echo 'Nenhum livro adicionado';
										}
									?>
								</section>
								<section class="tab-pane fade" id="queroler" style="max-width:100%;overflow:auto;">
									<?php
										$qt_quero = 0;	
										while($pesq_quero_ler = mysql_fetch_assoc($resul_quero_ler))
										{
											$qt_quero++;
											echo '<img src ="'.$pesq_quero_ler['imagem_livros'].'" alt = "'.$pesq_quero_ler['nome'].'" height = "177px" width = "120px">';
										}

										if($qt_quero == 0)
										{
											echo 'Nenhum livro adicionado';
										}
										
									?>
								</section>
								<section class="tab-pane fade" id="lendo" style="max-width:100%;overflow:auto;">
									<?php
										$qt_lendo = 0;	
										while($pesq_lendo = mysql_fetch_assoc($resul_lendo))
										{
											$qt_lendo++;
											echo '<img src ="'.$pesq_lendo['imagem_livros'].'" alt = "'.$pesq_lendo['nome'].'" height = "177px" width = "120px">';
										}

										if($qt_lendo == 0)
										{
											echo 'Nenhum livro adicionado';
										}
									?>
								</section>					  
							</section>
						</td>
					</tr>
					<tr>
						</td>
							
						</td>
					</tr>
					<tr>
						<td colspan = "5"> 				             
							<section id = "avaliações" style = "position:relative; left:50%; width:30%;">
								<label> Avaliações: </label>
								&nbsp  
								<span class= "glyphicon glyphicon-thumbs-up"></span> <span class = "badge"> <?php echo $avaliacoes_positivas; ?> </span> 
								&nbsp
								<span class= "glyphicon glyphicon-thumbs-down"> </span> <span class = "badge"> <?php echo $avaliacoes_negativas; ?> </span>
							</section>
						</td>
					</tr>
				</tbody>
			</table>
		</section>
	</section>
</article>