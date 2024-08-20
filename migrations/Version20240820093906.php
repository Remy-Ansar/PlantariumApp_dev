<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820093906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plants ADD watering_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC16FA0020F0 FOREIGN KEY (watering_id) REFERENCES watering (id)');
        $this->addSql('CREATE INDEX IDX_A5AEDC16FA0020F0 ON plants (watering_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC16FA0020F0');
        $this->addSql('DROP INDEX IDX_A5AEDC16FA0020F0 ON plants');
        $this->addSql('ALTER TABLE plants DROP watering_id');
    }
}
