<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240903204032 extends AbstractMigration
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
        $this->addSql('CREATE TABLE diseases (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diseases_plant_detail (diseases_id INT NOT NULL, plant_detail_id INT NOT NULL, INDEX IDX_422646BBE672F970 (diseases_id), INDEX IDX_422646BB5D9C9023 (plant_detail_id), PRIMARY KEY(diseases_id, plant_detail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE families (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_NAME_FAMILY (Name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant_detail (id INT AUTO_INCREMENT NOT NULL, user_plants_id INT NOT NULL, plant_id INT DEFAULT NULL, health_status_id INT DEFAULT NULL, journal LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CD96AE1862E9934F (user_plants_id), INDEX IDX_CD96AE181D935652 (plant_id), INDEX IDX_CD96AE185A71AB2F (health_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant_detail_warnings (plant_detail_id INT NOT NULL, warnings_id INT NOT NULL, INDEX IDX_CE38F8C95D9C9023 (plant_detail_id), INDEX IDX_CE38F8C97EC71F19 (warnings_id), PRIMARY KEY(plant_detail_id, warnings_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant_detail_watering (id INT AUTO_INCREMENT NOT NULL, warnings_id INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, frequency INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_26FE83EA7EC71F19 (warnings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plants (id INT AUTO_INCREMENT NOT NULL, families_id INT DEFAULT NULL, species_id INT DEFAULT NULL, watering_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, INDEX IDX_A5AEDC165DFECCD4 (families_id), INDEX IDX_A5AEDC16B2A1D860 (species_id), INDEX IDX_A5AEDC16FA0020F0 (watering_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons_plants (seasons_id INT NOT NULL, plants_id INT NOT NULL, INDEX IDX_D73DE5D216EB9F66 (seasons_id), INDEX IDX_D73DE5D262091EAB (plants_id), PRIMARY KEY(seasons_id, plants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_NAME_SPECIES (Name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_infos (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(200) NOT NULL, last_name VARCHAR(200) NOT NULL, level VARCHAR(100) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_plants (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, plant_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C0FCC72BA76ED395 (user_id), INDEX IDX_C0FCC72B1D935652 (plant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_plants_warnings (user_plants_id INT NOT NULL, warnings_id INT NOT NULL, INDEX IDX_8578BF3B62E9934F (user_plants_id), INDEX IDX_8578BF3B7EC71F19 (warnings_id), PRIMARY KEY(user_plants_id, warnings_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, user_infos_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, cgu TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9B4C7A8CA (user_infos_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warnings (id INT AUTO_INCREMENT NOT NULL, weather_id INT DEFAULT NULL, name VARCHAR(200) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, INDEX IDX_6949E6128CE675E (weather_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watering (id INT AUTO_INCREMENT NOT NULL, warnings_id INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, frequency INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_818F9D317EC71F19 (warnings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_plants ADD CONSTRAINT FK_ADC7E22EA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_plants ADD CONSTRAINT FK_ADC7E22E62091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_plants ADD CONSTRAINT FK_A1D2C1A25C002039 FOREIGN KEY (colors_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_plants ADD CONSTRAINT FK_A1D2C1A262091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diseases_plant_detail ADD CONSTRAINT FK_422646BBE672F970 FOREIGN KEY (diseases_id) REFERENCES diseases (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diseases_plant_detail ADD CONSTRAINT FK_422646BB5D9C9023 FOREIGN KEY (plant_detail_id) REFERENCES plant_detail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE1862E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id)');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE181D935652 FOREIGN KEY (plant_id) REFERENCES plants (id)');
        $this->addSql('ALTER TABLE plant_detail ADD CONSTRAINT FK_CD96AE185A71AB2F FOREIGN KEY (health_status_id) REFERENCES health_status (id)');
        $this->addSql('ALTER TABLE plant_detail_warnings ADD CONSTRAINT FK_CE38F8C95D9C9023 FOREIGN KEY (plant_detail_id) REFERENCES plant_detail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant_detail_warnings ADD CONSTRAINT FK_CE38F8C97EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plant_detail_watering ADD CONSTRAINT FK_26FE83EA7EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id)');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC165DFECCD4 FOREIGN KEY (families_id) REFERENCES families (id)');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC16B2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC16FA0020F0 FOREIGN KEY (watering_id) REFERENCES watering (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE seasons_plants ADD CONSTRAINT FK_D73DE5D216EB9F66 FOREIGN KEY (seasons_id) REFERENCES seasons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seasons_plants ADD CONSTRAINT FK_D73DE5D262091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_plants ADD CONSTRAINT FK_C0FCC72BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_plants ADD CONSTRAINT FK_C0FCC72B1D935652 FOREIGN KEY (plant_id) REFERENCES plants (id)');
        $this->addSql('ALTER TABLE user_plants_warnings ADD CONSTRAINT FK_8578BF3B62E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_plants_warnings ADD CONSTRAINT FK_8578BF3B7EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B4C7A8CA FOREIGN KEY (user_infos_id) REFERENCES user_infos (id)');
        $this->addSql('ALTER TABLE warnings ADD CONSTRAINT FK_6949E6128CE675E FOREIGN KEY (weather_id) REFERENCES weather (id)');
        $this->addSql('ALTER TABLE watering ADD CONSTRAINT FK_818F9D317EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_plants DROP FOREIGN KEY FK_ADC7E22EA21214B7');
        $this->addSql('ALTER TABLE categories_plants DROP FOREIGN KEY FK_ADC7E22E62091EAB');
        $this->addSql('ALTER TABLE colors_plants DROP FOREIGN KEY FK_A1D2C1A25C002039');
        $this->addSql('ALTER TABLE colors_plants DROP FOREIGN KEY FK_A1D2C1A262091EAB');
        $this->addSql('ALTER TABLE diseases_plant_detail DROP FOREIGN KEY FK_422646BBE672F970');
        $this->addSql('ALTER TABLE diseases_plant_detail DROP FOREIGN KEY FK_422646BB5D9C9023');
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE1862E9934F');
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE181D935652');
        $this->addSql('ALTER TABLE plant_detail DROP FOREIGN KEY FK_CD96AE185A71AB2F');
        $this->addSql('ALTER TABLE plant_detail_warnings DROP FOREIGN KEY FK_CE38F8C95D9C9023');
        $this->addSql('ALTER TABLE plant_detail_warnings DROP FOREIGN KEY FK_CE38F8C97EC71F19');
        $this->addSql('ALTER TABLE plant_detail_watering DROP FOREIGN KEY FK_26FE83EA7EC71F19');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC165DFECCD4');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC16B2A1D860');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC16FA0020F0');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE seasons_plants DROP FOREIGN KEY FK_D73DE5D216EB9F66');
        $this->addSql('ALTER TABLE seasons_plants DROP FOREIGN KEY FK_D73DE5D262091EAB');
        $this->addSql('ALTER TABLE user_plants DROP FOREIGN KEY FK_C0FCC72BA76ED395');
        $this->addSql('ALTER TABLE user_plants DROP FOREIGN KEY FK_C0FCC72B1D935652');
        $this->addSql('ALTER TABLE user_plants_warnings DROP FOREIGN KEY FK_8578BF3B62E9934F');
        $this->addSql('ALTER TABLE user_plants_warnings DROP FOREIGN KEY FK_8578BF3B7EC71F19');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B4C7A8CA');
        $this->addSql('ALTER TABLE warnings DROP FOREIGN KEY FK_6949E6128CE675E');
        $this->addSql('ALTER TABLE watering DROP FOREIGN KEY FK_818F9D317EC71F19');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_plants');
        $this->addSql('DROP TABLE colors');
        $this->addSql('DROP TABLE colors_plants');
        $this->addSql('DROP TABLE diseases');
        $this->addSql('DROP TABLE diseases_plant_detail');
        $this->addSql('DROP TABLE families');
        $this->addSql('DROP TABLE health_status');
        $this->addSql('DROP TABLE plant_detail');
        $this->addSql('DROP TABLE plant_detail_warnings');
        $this->addSql('DROP TABLE plant_detail_watering');
        $this->addSql('DROP TABLE plants');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE seasons');
        $this->addSql('DROP TABLE seasons_plants');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP TABLE user_infos');
        $this->addSql('DROP TABLE user_plants');
        $this->addSql('DROP TABLE user_plants_warnings');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE warnings');
        $this->addSql('DROP TABLE watering');
        $this->addSql('DROP TABLE weather');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
