<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213103049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE fiction (id SERIAL NOT NULL, title VARCHAR(255) DEFAULT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6F5709FDD17F50A6 ON fiction (uuid)');
        $this->addSql('ALTER TABLE narrative ADD fiction_id INT NOT NULL');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT FK_1040514BFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1040514BFF905AC2 ON narrative (fiction_id)');
        $this->addSql('ALTER TABLE fragment ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE fragment ALTER title DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT FK_1040514BFF905AC2');
        $this->addSql('DROP TABLE fiction');
        $this->addSql('ALTER TABLE fragment ALTER title TYPE TEXT');
        $this->addSql('ALTER TABLE fragment ALTER title DROP DEFAULT');
        $this->addSql('DROP INDEX IDX_1040514BFF905AC2');
        $this->addSql('ALTER TABLE narrative DROP fiction_id');
    }
}
