-- Criação do banco de dados
CREATE DATABASE formas;
USE formas;

-- Criação da tabela unidade
CREATE TABLE unidade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    sigla VARCHAR(10) NOT NULL
);

-- Criação da tabela quadrado
CREATE TABLE quadrado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lado DECIMAL(10,2) NOT NULL,
    id_unidade INT NOT NULL,
    cor VARCHAR(7) NOT NULL,
    FOREIGN KEY (id_unidade) REFERENCES unidade(id)
);

-- Criação da tabela triangulo
CREATE TABLE triangulo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lado DECIMAL(10,2) NOT NULL, -- Base do triângulo
    altura DECIMAL(10,2) NOT NULL, -- Altura do triângulo
    id_unidade INT NOT NULL,
    cor VARCHAR(7) NOT NULL,
    FOREIGN KEY (id_unidade) REFERENCES unidade(id)
);

CREATE TABLE circulo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    raio DECIMAL(10,2) NOT NULL,
    id_unidade INT NOT NULL,
    cor VARCHAR(7) NOT NULL,
    FOREIGN KEY (id_unidade) REFERENCES unidade(id)
);

CREATE TABLE isosceles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    base DECIMAL(10,2) NOT NULL, -- Base do triângulo isósceles
    lado_igual DECIMAL(10,2) NOT NULL, -- Lado igual do triângulo isósceles
    id_unidade INT NOT NULL, -- Unidade de medida
    cor VARCHAR(7) NOT NULL, -- Cor do triângulo
    FOREIGN KEY (id_unidade) REFERENCES unidade(id)
);
-- Inserindo dados de exemplo na tabela unidade
INSERT INTO unidade (descricao, sigla) VALUES ('Centímetros', 'cm');
INSERT INTO unidade (descricao, sigla) VALUES ('Metros', 'm');
INSERT INTO unidade (descricao, sigla) VALUES ('Polegadas', 'in');
INSERT INTO unidade (descricao, sigla) VALUES ('Pixels', 'px');
