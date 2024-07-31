<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731141731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE185A71AB2F');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE185A71AB2F FOREIGN KEY (health_status_id) REFERENCES health_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE185A71AB2F');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE185A71AB2F FOREIGN KEY (health_status_id) REFERENCES user_plants (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
