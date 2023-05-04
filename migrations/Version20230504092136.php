<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504092136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande_salon (id INT AUTO_INCREMENT NOT NULL, propietaire_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(100) NOT NULL, telephone INT NOT NULL, description LONGTEXT DEFAULT NULL, ville VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, style VARCHAR(50) NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4B6773E42546783 (propietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_salon ADD CONSTRAINT FK_4B6773E42546783 FOREIGN KEY (propietaire_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_salon DROP FOREIGN KEY FK_4B6773E42546783');
        $this->addSql('DROP TABLE demande_salon');
    }
}
