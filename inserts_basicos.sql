INSERT INTO tbl_estados VALUES (NULL, 'AC'),(NULL, 'Al'),(NULL, 'AP'),(NULL, 'AM'),(NULL, 'BA'),(NULL, 'CE'),(NULL, 'DF'),(NULL, 'ES'),(NULL, 'GO'),(NULL, 'MA'),(NULL, 'MT'),(NULL, 'MS'),(NULL, 'MG'),(NULL, 'PA'),(NULL, 'PB'),(NULL, 'PR'),(NULL, 'PE'),(NULL, 'PI'),(NULL, 'RJ'),(NULL, 'RN'),(NULL, 'RS'),(NULL, 'RO'),(NULL, 'RR'),(NULL, 'SC'),(NULL, 'SP'),(NULL, 'SE'),(NULL, 'TO');

INSERT INTO tbl_categoria VALUES(NULL, 'Romance'),(NULL,'Terror'),(NULL,'Suspense'),(NULL,'Fantasia'),(NULL,'Mitologia'),(NULL,'Policial'),(NULL,'Aventura'),(NULL,'Ficção Científica'),(NULL,'Drama');

SELECT * FROM tbl_categoria WHERE 1 = 1 GROUP BY nome ASC;