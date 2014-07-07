CREATE DATABASE letrastrocadas;

SHOW DATABASES;

USE letrastrocadas;

CREATE TABLE tbl_autor(

	id_autor INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(100) NOT NULL,
	PRIMARY KEY(id_autor)
	
);

CREATE TABLE tbl_editora(

	id_editora INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(100) NOT NULL,
	PRIMARY KEY(id_editora)
	
);

CREATE TABLE tbl_categoria(

	id_categoria INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(100) NOT NULL,
	PRIMARY KEY(id_categoria)
	
);

CREATE TABLE tbl_estados(

	id_estados INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome CHAR(2) NOT NULL,
	PRIMARY KEY(id_estados)

);

CREATE TABLE tbl_administrador(

	id_administrador INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(100) NOT NULL,
	nivel_acesso INT NOT NULL, /* Adm vai ser, por padrão, 2*/
	email VARCHAR(100) NOT NULL,
	senha VARCHAR(16) NOT NULL,
	PRIMARY KEY(id_administrador)
	
);

CREATE TABLE tbl_livro(

	id_livro INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(100) NOT NULL,
	imagem_livros VARCHAR(100) NOT NULL,
	edicao INT NOT NULL,
	isbn VARCHAR(17) NOT NULL,
	sinopse TEXT NOT NULL,
	status INT NULL, /* 1 = ativo, 2 = inativo e 3 = congelado */
	querem_ler BIGINT NULL,
	lendo BIGINT NULL,
	lido BIGINT NULL,
	numero_paginas BIGINT NOT NULL,
	editora_id INT UNSIGNED NOT NULL,
	autor_id INT UNSIGNED NOT NULL,
	categoria_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_livro),
	FOREIGN KEY(editora_id) REFERENCES tbl_editora(id_editora),
	FOREIGN KEY(autor_id) REFERENCES tbl_autor(id_autor),
	FOREIGN KEY(categoria_id) REFERENCES tbl_categoria(id_categoria)
	
);

CREATE TABLE tbl_usuario(

	id_usuario INT UNSIGNED AUTO_INCREMENT NOT NULL,
	nome VARCHAR(100) NULL,
	data_nasc DATE NULL,
	foto VARCHAR(100) NULL,
	email VARCHAR(100) NOT NULL,
	idade INT NULL,
	nivel_acesso INT NOT NULL,/* Usuários padrão tem nivel 1 */
	senha VARCHAR(16) NOT NULL,
	creditos INT NOT NULL,
	creditos_comprados_mes INT NULL, /*O usuário só vai poder comprar 2*/
	qt_livros_solicitados INT NOT NULL,
	qt_livros_solicitados INT NOT NULL,
	data_criacao DATE NOT NULL,
	trocas_realizadas_mes INT NOT NULL, 
	limite_troca INT NOT NULL,
	avaliacoes_negativas INT NOT NULL,
	avaliacoes_positivas INT NOT NULL,
	genero_favorito VARCHAR(50) NULL,
	status INT NOT NULL, /* 1 = ativo, 2 = inativo e 3 = banido */
	logradouro VARCHAR(100) NULL,
	numero INT NULL,
	cep CHAR(9) NULL,
	uf CHAR(2) NULL,
	complemento VARCHAR(100) NULL,
	cidade VARCHAR(100) NULL,
	bairro VARCHAR(100) NULL,
	PRIMARY KEY(id_usuario)
	
);

CREATE TABLE tbl_lendo(

	id_lendo INT UNSIGNED AUTO_INCREMENT NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	livro_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_lendo),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(livro_id) REFERENCES tbl_livro(id_livro)
	
);

CREATE TABLE tbl_leu(

	id_leu INT UNSIGNED AUTO_INCREMENT NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	livro_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_leu),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(livro_id) REFERENCES tbl_livro(id_livro)
	
);

CREATE TABLE tbl_amigo( /* Caras eu não sei se é assim que funciona mas pra mim é a forma mais prática*/ 

	id_amigo INT UNSIGNED AUTO_INCREMENT NOT NULL,
	usuario_id INT UNSIGNED NOT NULL, /* Id do usuário */ 
	amigo_id INT UNSIGNED NOT NULL, /* Id do amigo */ 
	PRIMARY KEY(id_amigo),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(amigo_id) REFERENCES tbl_usuario(id_usuario)
	
);

CREATE TABLE tbl_lista_desejo(

	id_lista_desejo INT UNSIGNED AUTO_INCREMENT NOT NULL,
	livro_id INT UNSIGNED NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_lista_desejo),
	FOREIGN KEY(livro_id) REFERENCES tbl_livro(id_livro),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario)
	
);

CREATE TABLE tbl_notificacoes(

	id_notificacoes INT UNSIGNED AUTO_INCREMENT NOT NULL,
	tipo INT NOT NULL, /* 1 = Trocas aceitas; 2= Trocas recusadas; 3 = Solicitações recebidas; 4 = Livro chegou; 5 = Livro em transporte */
	mensagem VARCHAR(50) NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	data_enviada DATETIME NOT NULL,
	visualizado CHAR(3) NOT NULL, /* true ou false (Escritos dessa forma mesmo) */
	PRIMARY KEY(id_notificacoes),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario)
	
);

/* ALTER TABLE tbl_notificacoes ADD visualizado CHAR(3) NOT NULL;
   ALTER TABLE tbl_notificacoes ADD tipo INT NOT NULL AFTER id_notificacoes;
   ALTER TABLE tbl_notificacoes CHANGE mensagem mensagem VARCHAR(50) NOT NULL; 
   ALTER TABLE tbl_notificacoes ADD data_enviada DATETIME NOT NULL AFTER usuario_id;*/

CREATE TABLE tbl_lista_banidos(

	id_lista_banidos INT UNSIGNED AUTO_INCREMENT NOT NULL,
	motivo VARCHAR(255) NOT NULL,
	penalidade VARCHAR(100) NOT NULL,
	data DATE NOT NULL,
	adiministrador_id INT UNSIGNED NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_lista_banidos),
	FOREIGN KEY(adiministrador_id) REFERENCES tbl_administrador(id_administrador),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario)
	
);

CREATE TABLE tbl_lista_livros(
	
	id_lista_livros INT UNSIGNED AUTO_INCREMENT NOT NULL,
	livro_id INT UNSIGNED NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	status INT NOT NULL, /* 1 = Disponivel, 2 = Trocado */
	data_cadastro DATETIME NOT NULL,
	ano CHAR(4) NOT NULL,
	estado VARCHAR(100) NOT NULL,
	PRIMARY KEY(id_lista_livros),
	FOREIGN KEY(livro_id) REFERENCES tbl_livro(id_livro),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario)
	
);

/* Ai pra mudar o banco sem precisar deletar ALTER TABLE tbl_lista_livros CHANGE data_cadastro data_cadastro DATETIME NOT NULL;*/

CREATE TABLE tbl_fotos_livros(

	id_fotos_livros INT UNSIGNED AUTO_INCREMENT NOT NULL,
	primeira_foto VARCHAR(100) NOT NULL,
	segunda_foto VARCHAR(100) NOT NULL,
	terceira_foto VARCHAR(100) NOT NULL,
	lista_livro_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_fotos_livros),
	FOREIGN KEY(lista_livro_id) REFERENCES tbl_lista_livros(id_lista_livros)
	
);

CREATE TABLE tbl_cambio(

	id_cambio INT UNSIGNED AUTO_INCREMENT NOT NULL,
	status INT NOT NULL, /* 1 = Em andamento(Esperando a cofirmação da entrega do livro); 2 = Livro já está em transporte; 3 = Feito; 4 = Livro não foi enviado dentro do prazo; 5 = Calote */
	data_operacao DATE NOT NULL,
	quantidade_livros INT NOT NULL,
	data_entrega DATE NULL,
	tipo INT NOT NULL, /* 1 = cambio e 2 = doação */
	pontuacao SMALLINT NOT NULL,
	cod_rastreamento VARCHAR(13) NULL,
	lista_livros_id INT UNSIGNED NOT NULL,
	usuario_disponibilizador INT UNSIGNED NOT NULL,
	usuario_resgate INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_cambio),
	FOREIGN KEY(usuario_disponibilizador) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(usuario_resgate) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(lista_livros_id) REFERENCES tbl_lista_livros(id_lista_livros)

);

/* ALTER TABLE tbl_cambio ADD status INT NOT NULL AFTER id_cambio; */

CREATE TABLE tbl_livros_trocados(

	id_livros_trocados INT UNSIGNED AUTO_INCREMENT NOT NULL,
	quantidade INT UNSIGNED NOT NULL,
	livro_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id_livros_trocados),
	FOREIGN KEY(livro_id) REFERENCES tbl_livro(id_livro)

);

CREATE TABLE tbl_avaliacao(

	id_avaliacao INT UNSIGNED AUTO_INCREMENT NOT NULL,
	livro_id INT UNSIGNED NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	avaliacao INT NOT NULL,
	PRIMARY KEY(id_avaliacao),
	FOREIGN KEY(usuario_id) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(livro_id) REFERENCES tbl_livro(id_livro)

);

CREATE TABLE tbl_solicitacao_troca(

	id_solicitacao INT UNSIGNED AUTO_INCREMENT NOT NULL,
	lista_id INT UNSIGNED NOT NULL,
	usuario_solicitador INT UNSIGNED NOT NULL,
	usuario_dono_lista INT UNSIGNED NOT NULL,
	aceito CHAR(3) NULL, /* Não e Sim*/ 
	data_solicitacao DATE NOT NULL,
	data_resposta DATE NULL,
	PRIMARY KEY(id_solicitacao),
	FOREIGN KEY(usuario_solicitador) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(usuario_dono_lista) REFERENCES tbl_usuario(id_usuario),
	FOREIGN KEY(lista_id) REFERENCES tbl_lista_livros(id_lista_livros)

);

/* ALTER TABLE tbl_denuncias ADD status INT NOT NULL; */

CREATE TABLE tbl_denuncias( 

	id_denuncias INT UNSIGNED AUTO_INCREMENT NOT NULL,
	usuario_denunciado_id INT UNSIGNED NOT NULL,
	motivo VARCHAR(255) NOT NULL,
	status INT NOT NULL,
	PRIMARY KEY(id_denuncias),
	FOREIGN KEY(usuario_denunciado_id) REFERENCES tbl_usuario(id_usuario)

);

CREATE TABLE tbl_motivos(

	id_motivo INT UNSIGNED AUTO_INCREMENT NOT NULL,
	descricao CHAR(2) NOT NULL,
	penalidade INT NOT NULL,
	PRIMARY KEY(id_motivo)

);
