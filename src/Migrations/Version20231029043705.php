<?php

declare(strict_types=1);

namespace ./Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029043705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration inicial.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE IF NOT EXISTS `contato` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `tipo` TINYINT DEFAULT NULL,
                `descricao` VARCHAR(120) DEFAULT NULL,
                `idPessoa` INT UNSIGNED NOT NULL,
                INDEX `contato_FK` (`idPessoa`),
                CONSTRAINT `contato_FK` FOREIGN KEY (`idPessoa`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');

        $this->addSql('
            INSERT INTO `contato` (`tipo`, `descricao`, `idPessoa`) VALUES (1, \'descrito\', 1)
        ');

        $this->addSql('
            CREATE TABLE IF NOT EXISTS `pessoa` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `nome` VARCHAR(220) NOT NULL,
                `cpf` VARCHAR(14) NOT NULL,
                UNIQUE KEY `pessoa_un` (`cpf`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ');

        $this->addSql('
            INSERT INTO `pessoa` (`nome`, `cpf`) VALUES (\'Fernando\', \'090.909.159-58\')
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `contato`');
        $this->addSql('DROP TABLE IF EXISTS `pessoa`');
    }
}
