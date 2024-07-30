<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730124014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE health_status DROP FOREIGN KEY FK_EA8D99E672F970');
        $this->addSql('DROP INDEX IDX_EA8D99E672F970 ON health_status');
        $this->addSql('ALTER TABLE health_status DROP diseases_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE health_status ADD diseases_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE health_status ADD CONSTRAINT FK_EA8D99E672F970 FOREIGN KEY (diseases_id) REFERENCES diseases (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EA8D99E672F970 ON health_status (diseases_id)');
    }
}
