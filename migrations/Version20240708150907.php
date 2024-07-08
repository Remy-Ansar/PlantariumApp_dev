<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708150907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC1662E9934F');
        $this->addSql('DROP INDEX IDX_A5AEDC1662E9934F ON plants');
        $this->addSql('ALTER TABLE plants DROP user_plants_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plants ADD user_plants_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC1662E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A5AEDC1662E9934F ON plants (user_plants_id)');
    }
}
