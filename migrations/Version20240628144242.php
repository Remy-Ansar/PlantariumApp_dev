<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628144242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_plants (categories_id INT NOT NULL, plants_id INT NOT NULL, INDEX IDX_ADC7E22EA21214B7 (categories_id), INDEX IDX_ADC7E22E62091EAB (plants_id), PRIMARY KEY(categories_id, plants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colors_plants (colors_id INT NOT NULL, plants_id INT NOT NULL, INDEX IDX_A1D2C1A25C002039 (colors_id), INDEX IDX_A1D2C1A262091EAB (plants_id), PRIMARY KEY(colors_id, plants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE families (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons_plants (seasons_id INT NOT NULL, plants_id INT NOT NULL, INDEX IDX_D73DE5D216EB9F66 (seasons_id), INDEX IDX_D73DE5D262091EAB (plants_id), PRIMARY KEY(seasons_id, plants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_plants ADD CONSTRAINT FK_ADC7E22EA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_plants ADD CONSTRAINT FK_ADC7E22E62091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_plants ADD CONSTRAINT FK_A1D2C1A25C002039 FOREIGN KEY (colors_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_plants ADD CONSTRAINT FK_A1D2C1A262091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seasons_plants ADD CONSTRAINT FK_D73DE5D216EB9F66 FOREIGN KEY (seasons_id) REFERENCES seasons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seasons_plants ADD CONSTRAINT FK_D73DE5D262091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plants ADD families_id INT DEFAULT NULL, ADD species_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD enable TINYINT(1) NOT NULL, DROP specie');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC165DFECCD4 FOREIGN KEY (families_id) REFERENCES families (id)');
        $this->addSql('ALTER TABLE plants ADD CONSTRAINT FK_A5AEDC16B2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_A5AEDC165DFECCD4 ON plants (families_id)');
        $this->addSql('CREATE INDEX IDX_A5AEDC16B2A1D860 ON plants (species_id)');
        $this->addSql('ALTER TABLE user_plants ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC165DFECCD4');
        $this->addSql('ALTER TABLE plants DROP FOREIGN KEY FK_A5AEDC16B2A1D860');
        $this->addSql('ALTER TABLE categories_plants DROP FOREIGN KEY FK_ADC7E22EA21214B7');
        $this->addSql('ALTER TABLE categories_plants DROP FOREIGN KEY FK_ADC7E22E62091EAB');
        $this->addSql('ALTER TABLE colors_plants DROP FOREIGN KEY FK_A1D2C1A25C002039');
        $this->addSql('ALTER TABLE colors_plants DROP FOREIGN KEY FK_A1D2C1A262091EAB');
        $this->addSql('ALTER TABLE seasons_plants DROP FOREIGN KEY FK_D73DE5D216EB9F66');
        $this->addSql('ALTER TABLE seasons_plants DROP FOREIGN KEY FK_D73DE5D262091EAB');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_plants');
        $this->addSql('DROP TABLE colors');
        $this->addSql('DROP TABLE colors_plants');
        $this->addSql('DROP TABLE families');
        $this->addSql('DROP TABLE seasons');
        $this->addSql('DROP TABLE seasons_plants');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP INDEX IDX_A5AEDC165DFECCD4 ON plants');
        $this->addSql('DROP INDEX IDX_A5AEDC16B2A1D860 ON plants');
        $this->addSql('ALTER TABLE plants ADD specie VARCHAR(255) DEFAULT NULL, DROP families_id, DROP species_id, DROP created_at, DROP updated_at, DROP enable');
        $this->addSql('ALTER TABLE user_plants DROP created_at, DROP updated_at');
    }
}
