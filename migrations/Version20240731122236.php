<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240731122236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diseases_plant_detail (diseases_id INT NOT NULL, plant_detail_id INT NOT NULL, INDEX IDX_422646BBE672F970 (diseases_id), INDEX IDX_422646BB5D9C9023 (plant_detail_id), PRIMARY KEY(diseases_id, plant_detail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diseases_plant_detail ADD CONSTRAINT FK_422646BBE672F970 FOREIGN KEY (diseases_id) REFERENCES diseases (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diseases_plant_detail ADD CONSTRAINT FK_422646BB5D9C9023 FOREIGN KEY (plant_detail_id) REFERENCES plant_detail (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diseases_plant_detail DROP FOREIGN KEY FK_422646BBE672F970');
        $this->addSql('ALTER TABLE diseases_plant_detail DROP FOREIGN KEY FK_422646BB5D9C9023');
        $this->addSql('DROP TABLE diseases_plant_detail');
    }
}
