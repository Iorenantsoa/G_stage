<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019180234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation_stage ADD est_deploye TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_evaluation ADD est_deploye TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation ADD est_deploye TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD first_version_est_deploye TINYINT(1) DEFAULT NULL, ADD last_version_est_deploye TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD a_fait_stage TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492298D193');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D322445E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913830278');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A4AEAFEA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491DFBCC46');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AB627E8B');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D322445E FOREIGN KEY (attestation_stage_id) REFERENCES attestation_stage (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913830278 FOREIGN KEY (fiche_evaluation_id) REFERENCES fiche_evaluation (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation_stage DROP est_deploye');
        $this->addSql('ALTER TABLE fiche_evaluation DROP est_deploye');
        $this->addSql('ALTER TABLE presentation DROP est_deploye');
        $this->addSql('ALTER TABLE rapport DROP first_version_est_deploye, DROP last_version_est_deploye');
        $this->addSql('ALTER TABLE stage DROP a_fait_stage');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492298D193');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A4AEAFEA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491DFBCC46');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AB627E8B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D322445E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913830278');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D322445E FOREIGN KEY (attestation_stage_id) REFERENCES attestation_stage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913830278 FOREIGN KEY (fiche_evaluation_id) REFERENCES fiche_evaluation (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
