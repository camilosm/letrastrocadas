/** * Função para criar um objeto XMLHTTPRequest */ 
function CriaRequest()
{
	try
	{ 
		request = new XMLHttpRequest(); 
	}
	catch (IEAtual)
	{ 
		try
		{
			request = new ActiveXObject("Msxml2.XMLHTTP"); 
		}
		catch(IEAntigo)
		{
			try
			{
				request = new ActiveXObject("Microsoft.XMLHTTP"); 
			}
			catch(falha)
			{
				request = false;
			}
		} 
	} 
	if (!request) alert("Seu Navegador não suporta Ajax!");
	else return request; 
}

$(document).ready(function(){
	$('#acoes > li').click(function(){
		var acao= $(this).attr("name");
		var id = $(this).attr("id");
		var result = document.getElementById("Resultado"+id);
		var tabela = document.getElementById("Resultado"+id).value;
		var xmlreq = CriaRequest();
		// Iniciar uma requisição
		xmlreq.open("GET", "ajax/acoes_livros.php?acao="+acao+"&id="+id+"&tabela="+tabela, true); 
		// Atribui uma função para ser executada sempre que houver uma mudança de ado
		xmlreq.onreadystatechange = function()
		{
			// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4) 
			if (xmlreq.readyState == 4)
			{ 
				// Verifica se o arquivo foi encontrado com sucesso
				if (xmlreq.status == 200)
				{ 
					var texto = xmlreq.responseText;
					$('button#Resultado'+id).text(texto).attr({
						title:texto
					});
				}
				else
				{ 
					$("#Resultado"+id).innerHTML = "Erro: " + xmlreq.statusText;
				}
			} 
		};
		xmlreq.send(null);
	});
})

