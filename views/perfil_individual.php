<?php
        
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		session_start();
		
		$id = $_SESSION['id'];	

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
					</ul>
					<div id="myTabContent" class="tab-content">
					  <div class="tab-pane fade active in" id="livrosdisponiveis">
				   <img src = "content/imagens/got1.jpg" alt = "got1" height = "177px" width = "120px">
				   <img src = "content/imagens/harry-potter-e-a-pedra-filosofal.jpg" alt = "harry_potter" height = "177px" width = "120px">
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
					  </div>
					  <div class="tab-pane fade" id="jali">
				   <img src = "content/imagens/pj1.jpg" alt = "percy_jackson" height = "177px" width = "120px">
				   <img src = "content/imagens/louco_aos_poucos.jpg" alt = "louco_aos_poucos" height = "177px" width = "120px">
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
					  </div>
					  <div class="tab-pane fade" id="queroler">
						<img src="" alt = "">
				   <img src = "content/imagens/50_tons_cinza.jpg" alt = "50tons" height = "177px" width = "120px">
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
						 <img src = "" alt = ""> 
					  </div>
					  
					</div>
				  </td>
				  			  
			</tr>
			<tr>
			      <td colspan = "5"> 				             
				       <section id = "avaliações" style = "position:relative; left:50%; width:20%;">
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