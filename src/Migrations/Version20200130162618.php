<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200130162618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE qualification (selected_uuid UUID NOT NULL, fragment_id INT NOT NULL, PRIMARY KEY(selected_uuid, fragment_id))');
        $this->addSql('CREATE INDEX IDX_B712F0CE596BD57E ON qualification (fragment_id)');
        $this->addSql('CREATE UNIQUE INDEX qualification_unique ON qualification (selected_uuid, fragment_id)');
        $this->addSql('ALTER TABLE qualification ADD CONSTRAINT FK_B712F0CE596BD57E FOREIGN KEY (fragment_id) REFERENCES fragment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE qualification');
    }
}
