<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820123836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plant_detail_warnings (plant_detail_id INT NOT NULL, warnings_id INT NOT NULL, INDEX IDX_CE38F8C95D9C9023 (plant_detail_id), INDEX IDX_CE38F8C97EC71F19 (warnings_id), PRIMARY KEY(plant_detail_id, warnings_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plant_detail_warnings ADD CONSTRAINT FK_CE38F8C95D9C9023 FOREIGN KEY (plant_detail_id) REFERENCES plant_detail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant_detail_warnings ADD CONSTRAINT FK_CE38F8C97EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plant_detail_warnings DROP FOREIGN KEY FK_CE38F8C95D9C9023');
        $this->addSql('ALTER TABLE plant_detail_warnings DROP FOREIGN KEY FK_CE38F8C97EC71F19');
        $this->addSql('DROP TABLE plant_detail_warnings');
    }
}
