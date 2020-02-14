<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200214143348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE "character" ADD birth_year INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "character" ADD death_year INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "character" DROP birthyear');
        $this->addSql('ALTER TABLE "character" DROP deathyear');
        $this->addSql('ALTER TABLE "character" RENAME COLUMN firstname TO first_name');
        $this->addSql('ALTER TABLE "character" RENAME COLUMN lastname TO last_name');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE character ADD birthyear INT DEFAULT NULL');
        $this->addSql('ALTER TABLE character ADD deathyear INT DEFAULT NULL');
        $this->addSql('ALTER TABLE character DROP birth_year');
        $this->addSql('ALTER TABLE character DROP death_year');
        $this->addSql('ALTER TABLE character RENAME COLUMN first_name TO firstname');
        $this->addSql('ALTER TABLE character RENAME COLUMN last_name TO lastname');
    }
}
