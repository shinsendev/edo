<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414153128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE position (id SERIAL NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_462CE4F5D17F50A6 ON position (uuid)');
        $this->addSql('CREATE INDEX IDX_462CE4F5A977936C ON position (tree_root)');
        $this->addSql('CREATE INDEX IDX_462CE4F5727ACA70 ON position (parent_id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5A977936C FOREIGN KEY (tree_root) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5727ACA70 FOREIGN KEY (parent_id) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT fk_1040514ba977936c');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT fk_1040514b727aca70');
        $this->addSql('DROP INDEX idx_1040514b727aca70');
        $this->addSql('DROP INDEX idx_1040514ba977936c');
        $this->addSql('ALTER TABLE narrative ADD position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE narrative DROP tree_root');
        $this->addSql('ALTER TABLE narrative DROP parent_id');
        $this->addSql('ALTER TABLE narrative DROP lft');
        $this->addSql('ALTER TABLE narrative DROP lvl');
        $this->addSql('ALTER TABLE narrative DROP rgt');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT FK_1040514BDD842E46 FOREIGN KEY (position_id) REFERENCES position (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1040514BDD842E46 ON narrative (position_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT FK_1040514BDD842E46');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP INDEX UNIQ_1040514BDD842E46');
        $this->addSql('ALTER TABLE narrative ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE narrative ADD lft INT NOT NULL');
        $this->addSql('ALTER TABLE narrative ADD lvl INT NOT NULL');
        $this->addSql('ALTER TABLE narrative ADD rgt INT NOT NULL');
        $this->addSql('ALTER TABLE narrative RENAME COLUMN position_id TO tree_root');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT fk_1040514ba977936c FOREIGN KEY (tree_root) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT fk_1040514b727aca70 FOREIGN KEY (parent_id) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1040514b727aca70 ON narrative (parent_id)');
        $this->addSql('CREATE INDEX idx_1040514ba977936c ON narrative (tree_root)');
    }
}
