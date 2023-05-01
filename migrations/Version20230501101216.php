<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501101216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salon ADD propriétaire_id INT DEFAULT NULL, ADD email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE salon ADD CONSTRAINT FK_F268F417F917CCFC FOREIGN KEY (propriétaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F268F417F917CCFC ON salon (propriétaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salon DROP FOREIGN KEY FK_F268F417F917CCFC');
        $this->addSql('DROP INDEX IDX_F268F417F917CCFC ON salon');
        $this->addSql('ALTER TABLE salon DROP propriétaire_id, DROP email');
    }
}