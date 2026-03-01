-- Migration: Módulo Aditivos
-- Criada em: 2026-03-01
-- Descrição: Cria tabelas para registrar aditivos e subetapas de obras (sem impacto financeiro)

CREATE TABLE IF NOT EXISTS additives (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    work_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pendente', 'finalizado') DEFAULT 'pendente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (work_id) REFERENCES works(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS sub_additives (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    additive_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pendente', 'finalizado') DEFAULT 'pendente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (additive_id) REFERENCES additives(id) ON DELETE CASCADE
);
