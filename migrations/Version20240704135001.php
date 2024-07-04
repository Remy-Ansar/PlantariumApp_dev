<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704135001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_NAME_CATEGORY ON categories (Name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_NAME_COLORS ON colors (Name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_NAME_FAMILY ON families (Name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_NAME_SPECIES ON species (Name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_NAME_CATEGORY ON categories');
        $this->addSql('DROP INDEX UNIQ_NAME_COLORS ON colors');
        $this->addSql('DROP INDEX UNIQ_NAME_FAMILY ON families');
        $this->addSql('DROP INDEX UNIQ_NAME_SPECIES ON species');
    }
}
