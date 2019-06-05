CREATE TABLE Jogador (
	id INTEGER AUTO_INCREMENT,
    nome varchar(50),
    rating INTEGER,
    PRIMARY KEY (id)
);

CREATE TABLE Tipo_de_partida (
	id INTEGER AUTO_INCREMENT,
    nome VARCHAR(50) UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE Controle_de_tempo (
	id INTEGER AUTO_INCREMENT,
    tempo_partida INTEGER,
    tem_incremento BOOLEAN,
    incremento INTEGER,
    id_tipo_de_partida INTEGER,
    PRIMARY KEY (id),
    FOREIGN KEY (id_tipo_de_partida) REFERENCES Tipo_de_partida(id)
);

CREATE TABLE Abertura (
	id INTEGER AUTO_INCREMENT,
    nome VARCHAR(50) UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE Partida (
	id INTEGER AUTO_INCREMENT,
    id_jogador_brancas INTEGER,
    id_jogador_negras INTEGER,
    data_da_partida DATETIME,
    id_jogador_vencedor INTEGER,
    id_controle_de_tempo INTEGER,
    id_abertura INTEGER,
    PRIMARY KEY (id),
    FOREIGN KEY (id_jogador_brancas) REFERENCES Jogador(id),
    FOREIGN KEY (id_jogador_negras) REFERENCES Jogador(id),
    FOREIGN KEY (id_jogador_vencedor) REFERENCES Jogador(id),
    FOREIGN KEY (id_abertura) REFERENCES Abertura(id),
	FOREIGN KEY (id_controle_de_tempo) REFERENCES Controle_de_tempo(id)
);

CREATE TABLE Momento_partida (
	id INTEGER AUTO_INCREMENT,
    nome VARCHAR(50) UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE Avaliacao_lance (
	id INTEGER AUTO_INCREMENT,
    nome VARCHAR(50) UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE Lance (
	id INTEGER AUTO_INCREMENT,
    id_jogador INTEGER,
    id_partida INTEGER,
    numero_lance INTEGER,
    id_avaliacao_lance INTEGER,
    mudanca_avaliacao CHAR,
    id_momento_partida INTEGER,
    PRIMARY KEY (id),
    FOREIGN KEY (id_jogador) REFERENCES Jogador(id),
    FOREIGN KEY (id_partida) REFERENCES Partida(id),
    FOREIGN KEY (id_avaliacao_lance) REFERENCES Avaliacao_lance(id),
    FOREIGN KEY (id_momento_partida) REFERENCES Momento_partida(id)
);

CREATE TABLE Variacao_rating (
	id INTEGER AUTO_INCREMENT,
    id_partida INTEGER,
    id_jogador INTEGER,
    variacao FLOAT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_jogador) REFERENCES Jogador(id),
    FOREIGN KEY (id_partida) REFERENCES Partida(id)
);