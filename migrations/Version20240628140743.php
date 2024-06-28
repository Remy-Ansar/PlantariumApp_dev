<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628140743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plants (id INT AUTO_INCREMENT NOT NULL, user_plants_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, specie VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_A5AEDC1662E9934F (user_plants_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_plants (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_C0FCC72BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC1662E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id)');
        $this->addSql('ALTER TABLE user_plants ADD CONSTRAINT FK_C0FCC72BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC1662E9934F');
        $this->addSql('ALTER TABLE user_plants DROP FOREIGN KEY FK_C0FCC72BA76ED395');
        $this->addSql('DROP TABLE plants');
        $this->addSql('DROP TABLE user_plants');
    }
}
