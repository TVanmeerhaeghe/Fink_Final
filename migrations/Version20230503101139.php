<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503101139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP INDEX UNIQ_42C849554C91BDE4, ADD INDEX IDX_42C849554C91BDE4 (salon_id)');
        $this->addSql('ALTER TABLE salon ADD reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salon ADD CONSTRAINT FK_F268F417B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_F268F417B83297E7 ON salon (reservation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP INDEX IDX_42C849554C91BDE4, ADD UNIQUE INDEX UNIQ_42C849554C91BDE4 (salon_id)');
        $this->addSql('ALTER TABLE salon DROP FOREIGN KEY FK_F268F417B83297E7');
        $this->addSql('DROP INDEX IDX_F268F417B83297E7 ON salon');
        $this->addSql('ALTER TABLE salon DROP reservation_id');
    }
}
