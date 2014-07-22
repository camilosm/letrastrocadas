<?php
        
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		session_start();
		
		$id = $_SESSION['id'];
		
		$id_outro_usu = $_GET['cod'];
		
		if ($id == $id_outro_usu)
		{		
		
			/* Pesquisa de dados Básicos usuário */
			
		    $pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,email,foto,idade,avaliacoes_negativas,avaliacoes_positivas,uf,cidade,genero_favorito", " id_usuario = $id");
		    $resul_pesquisa = $pesquisa_dados->pesquisar();
		    $pesq = mysql_fetch_assoc($resul_pesquisa);
			
		    $nome = $pesq['nome'];
		    $foto = $pesq['foto'];
		    $idade = $pesq['idade'];
		    $genero_favorito = $pesq['genero_favorito'];
		    $uf = $pesq['uf'];
		    $cidade = $pesq['cidade'];	
		    $avaliacoes_negativas = $pesq['avaliacoes_negativas'];
		    $avaliacoes_positivas = $pesq['avaliacoes_positivas'];
		    $id_p = $pesq['id_usuario'];
		    $email_p = $pesq['email'];
			
			/* Pesquisa de livros que o usuário disponibilizou */ 
			
			$pesquisa_dados_lista_livros = new Pesquisar("tbl_usuario usu JOIN tbl_livro liv JOIN tbl_lista_livros list_liv ON list_liv.livro_id = id_livro AND list_liv.usuario_id = id_usuario","imagem_livros,liv.nome,id_lista_livros","id_usuario = $id GROUP BY id_lista_livros");
			$resul_pesquisa_lista_livros = $pesquisa_dados_lista_livros->pesquisar();
			$pesq_lista_livro = mysql_fetch_assoc($resul_pesquisa_lista_livros);
		    
			$imagem_lista_livro = $pesq_lista_livro['imagem_livros'];
			$nome_livro_lista_livro = $pesq_lista_livro['liv.nome'];
			$id_lista_livro = $pesq_lista_livro['id_lista_livros'];
			
			/* Pesquisa de livros marcados como quero ler, lidos, lendo */

			$pesquisa_dados_marcacao = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro","tipo,id_livro,imagem_livros,tbl_livro.nome","usuario_id = $id");
			$resul_pesquisa_marcacao = $pesquisa_dados_marcacao->pesquisar();
			$pesq_marcacao = mysql_fetch_assoc($resul_pesquisa_marcacao);
		    
			$imagem_marcacao = $pesq_marcacao['imagem_livros'];
			$nome_livro_marcacao = $pesq_marcacao['tbl_livro.nome'];
			$id_livro_marcacao = $pesq_marcacao['id_livro'];			
			$tipo_marcacao = $pesq_marcacao['tipo'];
			
			
		}
		else if($id != $id_outro_usu)
		{
		    $pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,email,foto,idade,avaliacoes_negativas,avaliacoes_positivas,uf,cidade,genero_favorito", " id_usuario = $id_outro_usu");
		    $resul_pesquisa = $pesquisa_dados->pesquisar();
		    $pesq = mysql_fetch_array($resul_pesquisa);
		    
		    $nome = $pesq['nome'];
		    $foto = $pesq['foto'];
		    $idade = $pesq['idade'];
		    $genero_favorito = $pesq['genero_favorito'];
		    $uf = $pesq['uf'];
		    $cidade = $pesq['cidade'];	
		    $avaliacoes_negativas = $pesq['avaliacoes_negativas'];
		    $avaliacoes_positivas = $pesq['avaliacoes_positivas'];
		    $id_p = $pesq['id_usuario'];
		    $email_p = $pesq['email'];		
			
			/* Pesquisa de livros que o usuário disponibilizou */ 
			
			$pesquisa_dados_lista_livros = new Pesquisar("tbl_usuario usu JOIN tbl_livro liv JOIN tbl_lista_livros list_liv ON list_liv.livro_id = id_livro AND list_liv.usuario_id = id_usuario","imagem_livros,liv.nome,id_lista_livros","id_usuario = $id_outro_usu GROUP BY id_lista_livros");
			$resul_pesquisa_lista_livros = $pesquisa_dados_lista_livros->pesquisar();
			$pesq_lista_livro = mysql_fetch_assoc($resul_pesquisa_lista_livros);
		    
			$imagem_lista_livro = $pesq_lista_livro['imagem_livros'];
			$nome_livro_lista_livro = $pesq_lista_livro['liv.nome'];
			$id_lista_livro = $pesq_lista_livro['id_lista_livros'];
			
			/* Pesquisa de livros marcados como quero ler, lidos, lendo */

			$pesquisa_dados_marcacao = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," tipo,id_livro,imagem_livros,tbl_livro.nome"," usuario_id = $id_outro_usu");
			$resul_pesquisa_marcacao = $pesquisa_dados_marcacao->pesquisar();
			$pesq_marcacao = mysql_fetch_assoc($resul_pesquisa_marcacao);
		    
			$imagem_marcacao = $pesq_marcacao['imagem_livros'];
			$nome_livro_marcacao = $pesq_marcacao['nome'];
			$id_livro_marcacao = $pesq_marcacao['id_livro'];			
			$tipo_marcacao = $pesq_marcacao['tipo'];
		}
		else
		{
		    $pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,email,foto,idade,avaliacoes_negativas,avaliacoes_positivas,uf,cidade,genero_favorito", " id_usuario = $id");
		    $resul_pesquisa = $pesquisa_dados->pesquisar();
		    $pesq = mysql_fetch_array($resul_pesquisa);
		    
		    $nome = $pesq['nome'];
		    $foto = $pesq['foto'];
		    $idade = $pesq['idade'];
		    $genero_favorito = $pesq['genero_favorito'];
		    $uf = $pesq['uf'];
		    $cidade = $pesq['cidade'];	
		    $avaliacoes_negativas = $pesq['avaliacoes_negativas'];
		    $avaliacoes_positivas = $pesq['avaliacoes_positivas'];
		    $id_p = $pesq['id_usuario'];
		    $email_p = $pesq['email'];		
			
			/* Pesquisa de livros marcados como quero ler, lidos, lendo */

			$pesquisa_dados_marcacao = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro","tipo,id_livro,imagem_livros,tbl_livro.nome","usuario_id = $id");
			$resul_pesquisa_marcacao = $pesquisa_dados_marcacao->pesquisar();
			$pesq_marcacao = mysql_fetch_assoc($resul_pesquisa_marcacao);
		    
			$imagem_marcacao = $pesq_marcacao['imagem_livros'];
			$nome_livro_marcacao = $pesq_marcacao['tbl_livro.nome'];
			$id_livro_marcacao = $pesq_marcacao['id_livro'];			
			$tipo_marcacao = $pesq_marcacao['tipo'];
			
			/* Pesquisa de livros que o usuário disponibilizou */ 
			
			$pesquisa_dados_lista_livros = new Pesquisar("tbl_usuario usu JOIN tbl_livro liv JOIN tbl_lista_livros list_liv ON list_liv.livro_id = id_livro AND list_liv.usuario_id = id_usuario","imagem_livros,liv.nome,id_lista_livros","id_usuario = $id_outro_usu GROUP BY id_lista_livros");
			$resul_pesquisa_lista_livros = $pesquisa_dados_lista_livros->pesquisar();
			$pesq_lista_livro = mysql_fetch_assoc($resul_pesquisa_lista_livros);
		    
			$imagem_lista_livro = $pesq_lista_livro['imagem_livros'];
			$nome_livro_lista_livro = $pesq_lista_livro['liv.nome'];
			$id_lista_livro = $pesq_lista_livro['id_lista_livros'];
		}

		

?>

<article id = "body_perfil_usuario">
            <section class="panel panel-default" style="width: 65%; position: relative; left: 5%">

	

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
                  <td id = "generos_fav_usuario" colspan = "4" ><b> Gênero favorito: &nbsp;</b> <?php echo utf8_encode($genero_favorito); ?></td>
            </tr>
            <tr>
		          <td colspan="5">
				       <ul class="nav nav-tabs" style="margin-bottom: 15px;">
					  <li class="active"><a href="#livrosdisponiveis" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Livros Disponiveis</a></li>
					  <li><a href="#jali" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Já li</a></li>
					  <li><a href="#queroler" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Quero Ler</a></li>
					  <li><a href="#lendo" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Lendo </a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
					  <div class="tab-pane fade active in" id="livrosdisponiveis">
		 <?php
				if ($resul_pesquisa_lista_livros != 0){
					while($pesq_lista_livro = mysql_fetch_assoc($resul_pesquisa_lista_livros))
						{
						echo
							'<img src ="'.$imagem_lista_livro.'" alt = "'.$nome_livro_lista_livro.'" height = "177px" width = "120px">';
						}
				}
				else
				{
					echo 'Nenhum livro está disponível';
				}
		?>
					  </div>
					  <div class="tab-pane fade" id="jali">
		 <?php
				if ($resul_pesquisa_marcacao != 0 AND $tipo_marcacao == 2){
					while($pesq_marcacao = mysql_fetch_assoc($resul_pesquisa_marcacao))
						{
					if ($tipo_marcacao == 2)
					{
						echo
							'<img src ="'.$imagem_marcacao.'" alt = "'.$nome_livro_marcacao.'" height = "177px" width = "120px">';
						}
					}
				}
				else
				{
					echo 'Nenhum livro está disponível';
				}
		?>
					  </div>
					  <div class="tab-pane fade" id="queroler">
		 <?php
				if ($resul_pesquisa_marcacao != 0 AND $tipo_marcacao == 1){
					while($pesq_marcacao = mysql_fetch_assoc($resul_pesquisa_marcacao))
						{
					if ($tipo_marcacao == 1)
					{
						echo
							'<img src ="'.$imagem_marcacao.'" alt = "'.$nome_livro_marcacao.'" height = "177px" width = "120px">';
						}
					}
				}
				else
				{
					echo 'Nenhum livro está disponível';
				}
		?>
					  </div>
					<div class="tab-pane fade" id="lendo">
		 <?php
				if ($resul_pesquisa_marcacao != 0 AND $tipo_marcacao == 3){
					while($pesq_marcacao = mysql_fetch_assoc($resul_pesquisa_marcacao))
						{
					if ($tipo_marcacao == 3)
					{
						echo
							'<img src ="'.$imagem_marcacao.'" alt = "'.$nome_livro_marcacao.'" height = "177px" width = "120px">';
						}
					}
				}
				else
				{
					echo 'Nenhum livro está disponível';
				}
		?>
					</div>					  
					</div>
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
			<?php
				if ($id != $id_p)
				{
				echo 
				    '<section style = "position:relative; left:50%; width:23%"> 
				    	   <a href = "?url=denunciar_usuario&cod='.$id_outro_usu.'"> Denunciar usuário </a>
				    </section>' ;
				}
			?>
			</section>
			</section>

		
		

</article>