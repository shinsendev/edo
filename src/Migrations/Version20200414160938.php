<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414160938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE "position" DROP CONSTRAINT FK_462CE4F5A977936C');
        $this->addSql('ALTER TABLE "position" DROP CONSTRAINT FK_462CE4F5727ACA70');
        $this->addSql('ALTER TABLE "position" ADD narrative_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "position" ADD CONSTRAINT FK_462CE4F5CFF28A84 FOREIGN KEY (narrative_id) REFERENCES narrative (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "position" ADD CONSTRAINT FK_462CE4F5A977936C FOREIGN KEY (tree_root) REFERENCES position (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "position" ADD CONSTRAINT FK_462CE4F5727ACA70 FOREIGN KEY (parent_id) REFERENCES position (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_462CE4F5CFF28A84 ON "position" (narrative_id)');
        $this->addSql('ALTER TABLE narrative DROP CONSTRAINT fk_1040514bdd842e46');
        $this->addSql('DROP INDEX uniq_1040514bdd842e46');
        $this->addSql('ALTER TABLE narrative DROP position_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT FK_462CE4F5CFF28A84');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT fk_462ce4f5a977936c');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT fk_462ce4f5727aca70');
        $this->addSql('DROP INDEX UNIQ_462CE4F5CFF28A84');
        $this->addSql('ALTER TABLE position DROP narrative_id');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT fk_462ce4f5a977936c FOREIGN KEY (tree_root) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT fk_462ce4f5727aca70 FOREIGN KEY (parent_id) REFERENCES narrative (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE narrative ADD position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE narrative ADD CONSTRAINT fk_1040514bdd842e46 FOREIGN KEY (position_id) REFERENCES "position" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_1040514bdd842e46 ON narrative (position_id)');
    }
}
