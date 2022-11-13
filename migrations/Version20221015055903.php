<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221015055903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD stage_id INT DEFAULT NULL, ADD entreprise_id INT DEFAULT NULL, ADD rapport_id INT DEFAULT NULL, ADD presentation_id INT DEFAULT NULL, ADD attestation_stage_id INT DEFAULT NULL, ADD fiche_evaluation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D322445E FOREIGN KEY (attestation_stage_id) REFERENCES attestation_stage (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913830278 FOREIGN KEY (fiche_evaluation_id) REFERENCES fiche_evaluation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6492298D193 ON user (stage_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A4AEAFEA ON user (entreprise_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491DFBCC46 ON user (rapport_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AB627E8B ON user (presentation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D322445E ON user (attestation_stage_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64913830278 ON user (fiche_evaluation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492298D193');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A4AEAFEA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491DFBCC46');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AB627E8B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D322445E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913830278');
        $this->addSql('DROP INDEX UNIQ_8D93D6492298D193 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649A4AEAFEA ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6491DFBCC46 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649AB627E8B ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649D322445E ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D64913830278 ON user');
        $this->addSql('ALTER TABLE user DROP stage_id, DROP entreprise_id, DROP rapport_id, DROP presentation_id, DROP attestation_stage_id, DROP fiche_evaluation_id');
    }
}
