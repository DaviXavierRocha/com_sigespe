-- ========================================
-- SIGESPE - SISTEMA DE GESTÃO DE PESSOAL
-- 3º BEC - EXÉRCITO BRASILEIRO
-- CRIADO POR: 3º SGT DAVI ROCHA
-- ========================================

-- TABELA: COMPANHIA
CREATE TABLE IF NOT EXISTS `#__sigespe_companhia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `sigla` VARCHAR(20) NOT NULL,
  `ordenacao` INT(11) DEFAULT 0,
  `estado` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_sigla` (`sigla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABELA: SEÇÃO
CREATE TABLE IF NOT EXISTS `#__sigespe_secao` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `sigla` VARCHAR(20) NOT NULL,
  `companhia_id` INT(11) NOT NULL,
  `ordenacao` INT(11) DEFAULT 0,
  `estado` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_companhia` (`companhia_id`),
  CONSTRAINT `fk_secao_companhia` FOREIGN KEY (`companhia_id`) 
    REFERENCES `#__sigespe_companhia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABELA: CURSO
CREATE TABLE IF NOT EXISTS `#__sigespe_curso` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `tipo` ENUM('Civil','Militar') NOT NULL DEFAULT 'Civil',
  `nivel` VARCHAR(50) NOT NULL,
  `ordenacao` INT(11) DEFAULT 0,
  `estado` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABELA: MILITAR
CREATE TABLE IF NOT EXISTS `#__sigespe_militar` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_guerra` VARCHAR(100) NOT NULL,
  `posto_grad` VARCHAR(50) NOT NULL,
  `secao_id` INT(11) NOT NULL,
  `pronto_servico` TINYINT(1) DEFAULT 1,
  `foto` VARCHAR(255) DEFAULT NULL,
  `ordenacao` INT(11) DEFAULT 0,
  `estado` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_secao` (`secao_id`),
  KEY `idx_pronto` (`pronto_servico`),
  CONSTRAINT `fk_militar_secao` FOREIGN KEY (`secao_id`) 
    REFERENCES `#__sigespe_secao` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABELA: CARTEIRA
CREATE TABLE IF NOT EXISTS `#__sigespe_carteira` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `militar_id` INT(11) NOT NULL,
  `tipo` VARCHAR(50) NOT NULL,
  `numero` VARCHAR(50) NOT NULL,
  `validade` DATE DEFAULT NULL,
  `estado` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_militar` (`militar_id`),
  CONSTRAINT `fk_carteira_militar` FOREIGN KEY (`militar_id`) 
    REFERENCES `#__sigespe_militar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABELA: MILITAR X CURSOS (N:N)
CREATE TABLE IF NOT EXISTS `#__sigespe_militar_cursos` (
  `militar_id` INT(11) NOT NULL,
  `curso_id` INT(11) NOT NULL,
  PRIMARY KEY (`militar_id`, `curso_id`),
  KEY `idx_curso` (`curso_id`),
  CONSTRAINT `fk_mc_militar` FOREIGN KEY (`militar_id`) 
    REFERENCES `#__sigespe_militar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mc_curso` FOREIGN KEY (`curso_id`) 
    REFERENCES `#__sigespe_curso` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;