<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200130182721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT FK_1040514BA977936C');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT FK_1040514B727ACA70');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT FK_1040514BA977936C FOREIGN KEY (tree_root) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT FK_1040514B727ACA70 FOREIGN KEY (parent_id) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fragment DROP CONSTRAINT fk_cbad15eca977936c');
        $this->addSql('ALTER TABLE fragment DROP CONSTRAINT fk_cbad15ec727aca70');
        $this->addSql('DROP INDEX idx_cbad15ec727aca70');
        $this->addSql('DROP INDEX idx_cbad15eca977936c');
        $this->addSql('ALTER TABLE fragment DROP tree_root');
        $this->addSql('ALTER TABLE fragment DROP parent_id');
        $this->addSql('ALTER TABLE fragment DROP code');
        $this->addSql('ALTER TABLE fragment DROP lft');
        $this->addSql('ALTER TABLE fragment DROP lvl');
        $this->addSql('ALTER TABLE fragment DROP rgt');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fragment ADD tree_root INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fragment ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fragment ADD code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fragment ADD lft INT NOT NULL');
        $this->addSql('ALTER TABLE fragment ADD lvl INT NOT NULL');
        $this->addSql('ALTER TABLE fragment ADD rgt INT NOT NULL');
        $this->addSql('ALTER TABLE fragment ADD CONSTRAINT fk_cbad15eca977936c FOREIGN KEY (tree_root) REFERENCES fragment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fragment ADD CONSTRAINT fk_cbad15ec727aca70 FOREIGN KEY (parent_id) REFERENCES fragment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_cbad15ec727aca70 ON fragment (parent_id)');
        $this->addSql('CREATE INDEX idx_cbad15eca977936c ON fragment (tree_root)');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT fk_1040514ba977936c');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT fk_1040514b727aca70');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT fk_1040514ba977936c FOREIGN KEY (tree_root) REFERENCES fragment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT fk_1040514b727aca70 FOREIGN KEY (parent_id) REFERENCES fragment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
