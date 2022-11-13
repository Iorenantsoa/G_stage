<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020192049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation_stage ADD attestation_stage_validation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_evaluation ADD fiche_evaluation_validation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation ADD presentation_validation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD first_version_validation TINYINT(1) DEFAULT NULL, ADD last_version_validation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE stage DROP note');
        $this->addSql('ALTER TABLE user ADD note DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation_stage DROP attestation_stage_validation');
        $this->addSql('ALTER TABLE fiche_evaluation DROP fiche_evaluation_validation');
        $this->addSql('ALTER TABLE presentation DROP presentation_validation');
        $this->addSql('ALTER TABLE rapport DROP first_version_validation, DROP last_version_validation');
        $this->addSql('ALTER TABLE stage ADD note DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP note');
    }
}
