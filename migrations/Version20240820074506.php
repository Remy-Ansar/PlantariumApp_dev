<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820074506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plant_detail_watering (id INT AUTO_INCREMENT NOT NULL, warnings_id INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, frequency INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_26FE83EA7EC71F19 (warnings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warnings (id INT AUTO_INCREMENT NOT NULL, weather_id INT DEFAULT NULL, name VARCHAR(200) NOT NULL, description LONGTEXT DEFAULT NULL, reminder TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, INDEX IDX_6949E6128CE675E (weather_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watering (id INT AUTO_INCREMENT NOT NULL, warnings_id INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, frequency INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_818F9D317EC71F19 (warnings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plant_detail_watering ADD CONSTRAINT FK_26FE83EA7EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id)');
        $this->addSql('ALTER TABLE warnings ADD CONSTRAINT FK_6949E6128CE675E FOREIGN KEY (weather_id) REFERENCES weather (id)');
        $this->addSql('ALTER TABLE watering ADD CONSTRAINT FK_818F9D317EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plant_detail_watering DROP FOREIGN KEY FK_26FE83EA7EC71F19');
        $this->addSql('ALTER TABLE warnings DROP FOREIGN KEY FK_6949E6128CE675E');
        $this->addSql('ALTER TABLE watering DROP FOREIGN KEY FK_818F9D317EC71F19');
        $this->addSql('DROP TABLE plant_detail_watering');
        $this->addSql('DROP TABLE warnings');
        $this->addSql('DROP TABLE watering');
        $this->addSql('DROP TABLE weather');
    }
}
