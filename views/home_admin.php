	<header>
		<?php  session_start(); @include('views/base/header_admin.php'); ?>
	</header>
	
	<body>
		
		<!--Tab Control-->
		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			<li class="active"><a href="#denuncias" data-toggle="tab">Denúncias</a></li>
			<li><a href="#listanegra" data-toggle="tab">Lista Negra</a></li>
			<li><a href="#relatorios" data-toggle="tab">Relátorios</a></li>

		</ul>
		
		<section class="panel-body">
			<section id="myTabContent" class="tab-content">
				<section class="tab-pane fade active in" id="denuncias">
					<section class="panel-body">
						
						<section class="panel-group" id="accordion">
							<section class="panel panel-default">
								<section class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
											Carolina Almeida
										</a>
									</h4>
								</section>
								<section id="collapse1" class="panel-collapse collapse in">
									<section class="panel-body">
										Enviou um livro com mais danos que o previsto em sua descrição.
									</section>
								</section>
							</section>
						</section>
					
						<section class="panel panel-default">
							<section class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
										Alexandre Marra
									</a>
								</h4>
							</section>
							<section id="collapseTwo" class="panel-collapse collapse">
								<section class="panel-body">
									Não enviou o livro
								</section>
							</section>
						</section>
					
					</section>
				</section>
				<section class="tab-pane fade" id="listanegra">		
					<section class="panel-body">
						<ul class="list-group">
							<li class="list-group-item">
								<span class="badge">3</span>
								Alexandre Marra
							</li>
							<li class="list-group-item">
								<span class="badge">2</span>
								Helber Ramalho
							</li>
							<li class="list-group-item">
								<span class="badge">3</span>
								João Silva
							</li>
						</ul>
					</section>
				</section>
				
				<section class="tab-pane fade" id="relatorios">
				</section>
			</section>
		</section>
		
	</body>
</html>