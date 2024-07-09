<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709125802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_plants DROP FOREIGN KEY FK_C0FCC72B62091EAB');
        $this->addSql('DROP INDEX IDX_C0FCC72B62091EAB ON user_plants');
        $this->addSql('ALTER TABLE user_plants CHANGE plants_id plant_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_plants ADD CONSTRAINT FK_C0FCC72B1D935652 FOREIGN KEY (plant_id) REFERENCES plants (id)');
        $this->addSql('CREATE INDEX IDX_C0FCC72B1D935652 ON user_plants (plant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_plants DROP FOREIGN KEY FK_C0FCC72B1D935652');
        $this->addSql('DROP INDEX IDX_C0FCC72B1D935652 ON user_plants');
        $this->addSql('ALTER TABLE user_plants CHANGE plant_id plants_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_plants ADD CONSTRAINT FK_C0FCC72B62091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C0FCC72B62091EAB ON user_plants (plants_id)');
    }
}
