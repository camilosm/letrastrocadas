SELECT livro.nome AS NomeLivro, imagem_livros AS imagem_livro, 
autor.nome AS AutorNome, 
editora.nome AS EditoraNome, usuario.nome AS UsuarioNome, 
ft_livro.primeira_foto AS PrimeiraFoto,
ft_livro.segunda_foto AS SegundaFoto, 
ft_livro.terceira_foto AS TerceiraFoto
FROM tbl_livro livro JOIN tbl_autor autor JOIN tbl_editora editora
JOIN tbl_usuario usuario JOIN tbl_lista_livros lista
JOIN tbl_fotos_livros ft_livro
ON livro.editora_id = id_editora
AND livro.autor_id = id_autor
AND lista.livro_id = id_livro
AND lista.usuario_id = id_usuario
AND ft_livro.lista_livro_id = id_lista_livros
WHERE livro.nome LIKE '%%' OR
autor.nome LIKE '%%' OR
usuario.nome LIKE '%%' OR
editora.nome LIKE '%%'
ORDER BY livro.nome;

SELECT lista.id_lista_livros,
livro.nome AS NomeLivro, 
autor.nome AS NomeAutor, 
editora.nome AS NomeEditora,
categoria.nome AS NomeCategoria,
primeira_foto,
segunda_foto,
terceira_foto,
usuario.nome AS NomeUsuario
FROM tbl_lista_livros lista
LEFT JOIN tbl_livro livro
ON lista.livro_id = id_livro
LEFT JOIN tbl_fotos_livros
ON lista_livro_id = id_lista_livros
LEFT JOIN tbl_usuario usuario
ON usuario_id = id_usuario
LEFT JOIN tbl_editora editora 
ON editora_id = id_editora
LEFT JOIN tbl_autor autor 
ON autor_id = id_autor
LEFT JOIN tbl_categoria categoria
ON categoria_id = id_categoria
WHERE livro.nome LIKE '%%'
OR autor.nome LIKE '%%'
OR editora.nome LIKE '%%'
OR usuario.nome LIKE '%%'
GROUP BY livro.nome ASC;

/* Para pegar a quantidade de usuários */

SELECT COUNT(id_usuario) AS Numero_Usuarios FROM tbl_usuario;

/* Para pegar a quantidade de usuário cadastrados recentemente */

SELECT COUNT(id_usuario) AS Numero_Usuarios_Cadastrados_Recentemente
FROM tbl_usuario WHERE data_criacao = DATE(NOW());

SELECT nome, email, idade, creditos, limite_troca, 
qt_livros_solicitados, qt_livros_solicitados, 
genero_favorito, uf, cidade, data_criacao FROM tbl_usuario
WHERE DATE_FORMAT(data_criacao, '%m-%d') <= DATE_FORMAT(NOW(),'%m-%d') 
ORDER BY data_criacao ASC;

/* Livro mais trocados */

SELECT nome, quantidade 
FROM tbl_livro JOIN tbl_livros_trocados
ON livro_id = id_livro 
ORDER BY quantidade DESC;

SELECT nome, quantidade 
FROM tbl_livro JOIN tbl_livros_trocados
ON livro_id = id_livro 
ORDER BY quantidade ASC;

/* Gêneros favoritos */ 

SELECT genero_favorito AS Nome_Genero,
COUNT(*) AS NumeroDePessoasQueGostam
FROM tbl_usuario 
GROUP BY genero_favorito;

/* Autores favoritos */

SELECT autor.nome, COUNT(*) 
FROM tbl_autor autor JOIN tbl_livros_trocados 
JOIN tbl_livro
ON livro_id = id_livro
AND autor_id = id_autor
GROUP BY AUTOR.NOME
ORDER BY COUNT(livro_id) DESC

/* Editoras favoritas */

SELECT editora.nome, COUNT(*)
FROM tbl_editora editora  JOIN tbl_livros_trocados
JOIN tbl_livro 
ON livro_id = id_livro
AND editora_id = id_editora
GROUP BY editora.nome
ORDER BY COUNT(livro_id) DESC;

/* Denúncias pendentes */

SELECT usuario.nome, usuario.email, den.motivo, den.status, 
den.id_denuncias, COUNT(*) as Numero_Denuncias
FROM tbl_usuario usuario JOIN tbl_denuncias den
ON usuario_denunciado_id = id_usuario
GROUP BY id_denuncias;

/* Numero de denuncias por usuário */

SELECT nome, COUNT(*) as Numero_Denuncias 
FROM tbl_usuario JOIN tbl_denuncias 
ON usuario_denunciado_id = id_usuario
GROUP BY id_usuario
ORDER BY COUNT(*) DESC;

/* Motivos de denuncia mais frequentes */

SELECT motivo, COUNT(*) AS Quantidade
FROM tbl_denuncias
GROUP BY motivo
ORDER BY COUNT(*) DESC;

/* Usuários mais bem avaliados */ 

SELECT nome, avaliacoes_positivas
FROM tbl_usuario 
GROUP BY id_usuario ;

/* Usuários mais mal avaliados */ 

SELECT nome, avaliacoes_negativas
FROM tbl_usuario 
GROUP BY id_usuario ;
















