<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219170350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE qualification');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE qualification (selected_uuid UUID NOT NULL, fragment_id INT NOT NULL, selected_type VARCHAR(255) NOT NULL, PRIMARY KEY(selected_uuid, fragment_id))');
        $this->addSql('CREATE UNIQUE INDEX qualification_unique ON qualification (selected_uuid, fragment_id)');
        $this->addSql('CREATE INDEX idx_b712f0ce596bd57e ON qualification (fragment_id)');
        $this->addSql('COMMENT ON COLUMN qualification.selected_type IS \'Selected Type, for instance : narrative, character, etc.\'');
        $this->addSql('ALTER TABLE qualification ADD CONSTRAINT fk_b712f0ce596bd57e FOREIGN KEY (fragment_id) REFERENCES fragment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
