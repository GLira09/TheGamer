-- Criação do Banco de Dados
CREATE DATABASE the_gamer;
USE the_gamer;

-- Tabela de Jogos
CREATE TABLE Jogos (
    id_jogo INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(48) NOT NULL,
    desenvolvedor VARCHAR(48),
    distribuidor VARCHAR(48),
    dt_publicacao DATE,
    genero VARCHAR(48),
    preco FLOAT,
    tipo_jogo ENUM('digital', 'fisico') NOT NULL,
    estoque INT DEFAULT NULL
);

-- Tabela de Consoles
CREATE TABLE Consoles (
    id_console INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(48) NOT NULL,
    fabricante VARCHAR(48),
    dt_lancamento DATE,
    plataforma VARCHAR(16),
    preco FLOAT,
    estoque INT
);

-- Tabela de Plataformas
CREATE TABLE Plataformas (
    id_plataforma INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(20) UNIQUE NOT NULL
);

-- Tabela de Relacionamento Jogos_Plataformas
CREATE TABLE Jogos_Plataformas (
    id_jogo INT,
    id_plataforma INT,
    PRIMARY KEY (id_jogo, id_plataforma),
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo) ON DELETE CASCADE,
    FOREIGN KEY (id_plataforma) REFERENCES Plataformas(id_plataforma) ON DELETE CASCADE
);

-- Tabela de Usuários
CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(36) NOT NULL,
    email VARCHAR(36) UNIQUE NOT NULL,
    senha VARCHAR(36) NOT NULL,
    dt_nascimento DATE,
    dt_criacao DATE DEFAULT CURRENT_DATE
);

-- Tabela de Cartões
CREATE TABLE Cartoes (
    id_cartao INT PRIMARY KEY AUTO_INCREMENT,
    numero VARCHAR(16) NOT NULL,
    nome_cartao VARCHAR(15),
    dt_venc VARCHAR(5),
    nome_titular VARCHAR(32)
);

-- Tabela de Compras
CREATE TABLE Compras (
    id_compra INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_produto INT NOT NULL,
    tipo_produto ENUM('jogo', 'console') NOT NULL,
    id_cartao INT,
    quantidade INT DEFAULT 1,
    data_compra DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_cartao) REFERENCES Cartoes(id_cartao) ON DELETE SET NULL,
    CHECK (tipo_produto IN ('jogo', 'console'))
);
