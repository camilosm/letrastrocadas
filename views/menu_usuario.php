 <!DOCTYPE HTML>
<html lang="pt-br">
    <head>
           <meta charset = "utf-8">
           <link rel="stylesheet" type="text/css" href="Content/estilo.css" >
		   <title> Letras Trocadas </title>
		   		   
			  <header> 
			            <nav class="navbar navbar-default">
                          <div class="navbar-header">
                              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                              </button>
                                <a class="navbar-brand" href="#">Home</a>
                          </div>
                          <div class="navbar-collapse collapse navbar-responsive-collapse">
                                <ul class="nav navbar-nav">
                                  <li class="active"><a href="#">Active</a></li>
                                  <li><a href="#">Link</a></li>
                                  <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Perfil <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="#"> Configurações de conta </a></li>
                                      <li><a href="#"> Alterar senha </a></li>
                                      <li><a href="#"> Alterar Dados </a></li>
                                    </ul>
                                  </li>
                                </ul>
                <form class="navbar-form navbar-left">
                                     <input type="text" class="form-control col-lg-8" placeholder="Pesquise um livro aqui!">
                </form>
                                <ul class="nav navbar-nav navbar-right">
                                  <li><a href="#">Link</a></li>
                                  <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="#">Action</a></li>
                                      <li><a href="#">Another action</a></li>
                                      <li><a href="#">Something else here</a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">Separated link</a></li>
                                    </ul>
                                  </li>
                                </ul>
                </div>
</nav>
						<!-- <nav id = "menu_usuario" class="navbar-header">
			             <input type = "text" name = "busca_livros" placeholder = "Pesquise um livro aqui!">
			            <input type = "submit" name = "botao_busca_dados" class = "botao" value = "Pesquisar">
						         
								 <ul>
								 
								       <li title = "Home" class = ""> <a href = "?home_usuario.php"> </a> </li>
								       <li title = "Ajuda" class = "ajuda"> <a href = ""> </a> </li> 
									   <li title = "Perfil" class = "perfil_usuario"> <a href = ""> </a> </li>
									   <li title = "Sair" class = "sair"> <a href = ""> </a> </li>
								 </ul>
								 
						</nav> -->
			  
			  </header>
			  
    </head>
	
	            <aside id = "sidebar_usu">
                      
					  <label> Notificações </label>
					  
					  <ul>
			               <!-- não esquecer de coloca o ícone pelo
						   css e colocar texto ao passar o mouse, por exemplo: "Solicitações de trocas aceitas" -->
						   
					       <li> <div id = "solicitacoes_aceitas" > </div></li> 
						   <li> <div id = "solicitacoes_trocas" ></div></li> <!-- Solicitações para troca -->
						   <li> <div id = "livro_chegou" ></div></li> <!-- Livro chegou! -->
						   <li> <div id = "voce_foi_avaliado"> </div></li> <!--Você foi avaliado-->	
                           <li> <div id = "moedas"> </div></li> <!-- moedas dos usuário -->				   
					  
					      <!-- dúvida: como faz para mostrar que há notificação igual o facebook faz? pesquisei um pouco
                           e parece beeem complexo. -->
					     
					  </ul>
					  
            </aside>
	
	
<body>
<?php
	                  //Verifica se ha alguma pagina selecionada
	                  if(isset($_GET["url"])){
	                  	//verifica se a pagina veio com extencao, se nao concatena a ext php.
	                  	$arquivo = $_GET["url"].(preg_match('/.php/i',$_GET["url"],$matches,PREG_OFFSET_CAPTURE) ? "" : ".php");		
	                  	//Tenta anexar a pagina, senao imprime a mensagem de pagina nao encontrada
	                  	if(!@include("/Views/".$arquivo))
	                  		echo "Pagina nao encontrada!";
	                  }
?>
</body>
   <footer id="rodape"> <!-- deixei com o mesmo nome do outro rodape porque acho que não fará diferença uma vez que são os mesmo -->
   
   	<nav>
	
      <section id = "redes_sociais">
		        <ul> <h3> Redes Socias </h3>
		        	 <li><a href = ""> Facebook </a></li>
		        	 <li><a href = ""> Twitter </a></li>  	 
		        </ul>
	  </section>
	  
      <section id = "dados_gerais">
		        <ul> <h3> Informações </h3>
		        	 <li><a href = ""> Dúvidas </a></li>
		        	 <li><a href = ""> Política de privacidade </a></li>
		        	 <li><a href = ""> Mapa do site </a></li>
		        	 <li><a href = ""> Termos de uso </a></li>
		        </ul>	
	  </section>
	  
	</nav>
	   
   </footer>
</html>