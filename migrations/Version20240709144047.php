<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709144047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diseases (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health_status (id INT AUTO_INCREMENT NOT NULL, diseases_id INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_EA8D99E672F970 (diseases_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant_detail (id INT AUTO_INCREMENT NOT NULL, user_plants_id INT DEFAULT NULL, plant_id INT DEFAULT NULL, health_status_id INT DEFAULT NULL, journal LONGTEXT DEFAULT NULL, INDEX IDX_CD96AE1862E9934F (user_plants_id), INDEX IDX_CD96AE181D935652 (plant_id), INDEX IDX_CD96AE185A71AB2F (health_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE health_status ADD CONSTRAINT FK_EA8D99E672F970 FOREIGN KEY (diseases_id) REFERENCES diseases (id)');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE1862E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id)');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE181D935652 FOREIGN KEY (plant_id) REFERENCES plants (id)');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE185A71AB2F FOREIGN KEY (health_status_id) REFERENCES health_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE health_status DROP FOREIGN KEY FK_EA8D99E672F970');
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE1862E9934F');
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE181D935652');
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE185A71AB2F');
        $this->addSql('DROP TABLE diseases');
        $this->addSql('DROP TABLE health_status');
        $this->addSql('DROP TABLE plant_detail');
    }
}
