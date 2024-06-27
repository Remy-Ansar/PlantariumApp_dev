<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627145531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plants (id INT AUTO_INCREMENT NOT NULL, user_plants_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A5AEDC1662E9934F (user_plants_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_infos (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(200) NOT NULL, last_name VARCHAR(200) NOT NULL, level VARCHAR(100) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, user_infos_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9B4C7A8CA (user_infos_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC1662E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B4C7A8CA FOREIGN KEY (user_infos_id) REFERENCES user_infos (id)');
        $this->addSql('DROP INDEX IDX_C0FCC72B98333A1E ON user_plants');
        $this->addSql('ALTER TABLE user_plants DROP users_id_id');
        $this->addSql('ALTER TABLE user_plants ADD CONSTRAINT FK_C0FCC72BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_plants DROP FOREIGN KEY FK_C0FCC72BA76ED395');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC1662E9934F');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B4C7A8CA');
        $this->addSql('DROP TABLE plants');
        $this->addSql('DROP TABLE user_infos');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE user_plants ADD users_id_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_C0FCC72B98333A1E ON user_plants (users_id_id)');
    }
}
