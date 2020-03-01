<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301201736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE fragment DROP title');
        $this->addSql('ALTER TABLE fragment ALTER content TYPE VARCHAR(1024)');
        $this->addSql('ALTER TABLE fragment ALTER content DROP DEFAULT');
        $this->addSql('ALTER TABLE fragment ALTER content SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fragment ADD title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE fragment ALTER content TYPE TEXT');
        $this->addSql('ALTER TABLE fragment ALTER content DROP DEFAULT');
        $this->addSql('ALTER TABLE fragment ALTER content DROP NOT NULL');
        $this->addSql('ALTER TABLE fragment ALTER content TYPE TEXT');
    }
}
