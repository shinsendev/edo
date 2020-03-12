<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312184912 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE narration');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE narration (narratable_uuid UUID NOT NULL, narrative_id INT NOT NULL, narratable_type INT NOT NULL, PRIMARY KEY(narrative_id, narratable_uuid))');
        $this->addSql('CREATE UNIQUE INDEX narration_unique ON narration (narratable_uuid, narrative_id)');
        $this->addSql('CREATE INDEX idx_1c9221dbcff28a84 ON narration (narrative_id)');
        $this->addSql('COMMENT ON COLUMN narration.narratable_type IS \'Selected Type, for instance : narrative 1, character 2, etc.\'');
        $this->addSql('ALTER TABLE narration ADD CONSTRAINT fk_1c9221dbcff28a84 FOREIGN KEY (narrative_id) REFERENCES narrative (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
