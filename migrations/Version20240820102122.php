<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820102122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_plants_warnings (user_plants_id INT NOT NULL, warnings_id INT NOT NULL, INDEX IDX_8578BF3B62E9934F (user_plants_id), INDEX IDX_8578BF3B7EC71F19 (warnings_id), PRIMARY KEY(user_plants_id, warnings_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_plants_warnings ADD CONSTRAINT FK_8578BF3B62E9934F FOREIGN KEY (user_plants_id) REFERENCES user_plants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_plants_warnings ADD CONSTRAINT FK_8578BF3B7EC71F19 FOREIGN KEY (warnings_id) REFERENCES warnings (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_plants_warnings DROP FOREIGN KEY FK_8578BF3B62E9934F');
        $this->addSql('ALTER TABLE user_plants_warnings DROP FOREIGN KEY FK_8578BF3B7EC71F19');
        $this->addSql('DROP TABLE user_plants_warnings');
    }
}
