<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708150146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_NAME_CATEGORY (Name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_plants (categories_id INT NOT NULL, plants_id INT NOT NULL, INDEX IDX_ADC7E22EA21214B7 (categories_id), INDEX IDX_ADC7E22E62091EAB (plants_id), PRIMARY KEY(categories_id, plants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_NAME_COLORS (Name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colors_plants (colors_id INT NOT NULL, plants_id INT NOT NULL, INDEX IDX_A1D2C1A25C002039 (colors_id), INDEX IDX_A1D2C1A262091EAB (plants_id), PRIMARY KEY(colors_id, plants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE families (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_NAME_FAMILY (Name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plants (id INT AUTO_INCREMENT NOT NULL, user_plants_id INT DEFAULT NULL, families_id INT DEFAULT NULL, species_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, INDEX IDX_A5AEDC1662E9934F (user_plants_id), INDEX IDX_A5AEDC165DFECCD4 (families_id), INDEX IDX_A5AEDC16B2A1D860 (species_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons_plants (seasons_id INT NOT NULL, plants_id INT NOT NULL, INDEX IDX_D73DE5D216EB9F66 (seasons_id), INDEX IDX_D73DE5D262091EAB (plants_id), PRIMARY KEY(seasons_id, plants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_NAME_SPECIES (Name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_infos (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(200) NOT NULL, last_name VARCHAR(200) NOT NULL, level VARCHAR(100) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_plants (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C0FCC72BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, user_infos_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9B4C7A8CA (user_infos_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_plants ADD CONSTRAINT FK_ADC7E22EA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_plants ADD CONSTRAINT FK_ADC7E22E62091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_plants ADD CONSTRAINT FK_A1D2C1A25C002039 FOREIGN KEY (colors_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_plants ADD CONSTRAINT FK_A1D2C1A262091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC1662E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id)');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC165DFECCD4 FOREIGN KEY (families_id) REFERENCES families (id)');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC16B2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE seasons_plants ADD CONSTRAINT FK_D73DE5D216EB9F66 FOREIGN KEY (seasons_id) REFERENCES seasons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seasons_plants ADD CONSTRAINT FK_D73DE5D262091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_plants ADD CONSTRAINT FK_C0FCC72BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B4C7A8CA FOREIGN KEY (user_infos_id) REFERENCES user_infos (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_plants DROP FOREIGN KEY FK_ADC7E22EA21214B7');
        $this->addSql('ALTER TABLE categories_plants DROP FOREIGN KEY FK_ADC7E22E62091EAB');
        $this->addSql('ALTER TABLE colors_plants DROP FOREIGN KEY FK_A1D2C1A25C002039');
        $this->addSql('ALTER TABLE colors_plants DROP FOREIGN KEY FK_A1D2C1A262091EAB');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC1662E9934F');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC165DFECCD4');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC16B2A1D860');
        $this->addSql('ALTER TABLE seasons_plants DROP FOREIGN KEY FK_D73DE5D216EB9F66');
        $this->addSql('ALTER TABLE seasons_plants DROP FOREIGN KEY FK_D73DE5D262091EAB');
        $this->addSql('ALTER TABLE user_plants DROP FOREIGN KEY FK_C0FCC72BA76ED395');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B4C7A8CA');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_plants');
        $this->addSql('DROP TABLE colors');
        $this->addSql('DROP TABLE colors_plants');
        $this->addSql('DROP TABLE families');
        $this->addSql('DROP TABLE plants');
        $this->addSql('DROP TABLE seasons');
        $this->addSql('DROP TABLE seasons_plants');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP TABLE user_infos');
        $this->addSql('DROP TABLE user_plants');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
