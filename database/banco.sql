CREATE DATABASE IF NOT EXISTS fluxo_restaurante;

USE fluxo_restaurante;

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numeroMesa INT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'aguardando',
    itens JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT UNIQUE,
    cadeiras INT,
    status VARCHAR(20)
)