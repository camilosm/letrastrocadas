<?php
 
		include("../fpdf/fpdf.php");
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$pesquisar_editoras_fav = new Pesquisar("tbl_editora editora JOIN tbl_livros_trocados JOIN tbl_livro ON livro_id = id_livro AND editora_id = id_editora","editora.nome, COUNT(*) AS NumeroLivrosEditores","1=1 GROUP BY editora.nome ORDER BY COUNT(livro_id) DESC");
		$resul_editoras_fav = $pesquisar_editoras_fav->pesquisar();
		
		$pdf = new FPDF();		
		$pdf->AddPage();
		$pdf->Image("../content/logo.jpg","170","15","30","22");
		$pdf->SetFont('helvetica','B','16');
		$pdf->Cell('180','40',utf8_decode('Relatório de Gêneros Favoritos'),0,0,'C');
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','B','10');
		$pdf->Cell('90','10','Nome',1,'','C');
		$pdf->Cell('90','10',utf8_decode('Número de livros trocados da editora'),1,'','C');		
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','',10);
		
		while($dados = mysql_fetch_assoc($resul_editoras_fav)){
		    $pdf->SetFont('helvetica','','10');
		    $pdf->Cell('90','10',utf8_decode($dados['nome']),1,'','C');
		    $pdf->Cell('90','10',$dados['NumeroLivrosEditores'],1,'','C');
		    $pdf->Ln();		
		}
				
		$pdf->Output();

?>