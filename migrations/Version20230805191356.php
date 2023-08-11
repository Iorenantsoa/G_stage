<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805191356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, classe VARCHAR(50) DEFAULT NULL, annee_universitaire VARCHAR(70) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remarques (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(70) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5AB3C171A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, stage_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, rapport_id INT DEFAULT NULL, presentation_id INT DEFAULT NULL, attestation_stage_id INT DEFAULT NULL, fiche_evaluation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, niveau_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, image VARCHAR(255) DEFAULT NULL, note DOUBLE PRECISION DEFAULT NULL, check_remarque INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6492298D193 (stage_id), INDEX IDX_8D93D649A4AEAFEA (entreprise_id), UNIQUE INDEX UNIQ_8D93D6491DFBCC46 (rapport_id), UNIQUE INDEX UNIQ_8D93D649AB627E8B (presentation_id), UNIQUE INDEX UNIQ_8D93D649D322445E (attestation_stage_id), UNIQUE INDEX UNIQ_8D93D64913830278 (fiche_evaluation_id), INDEX IDX_8D93D649A76ED395 (user_id), INDEX IDX_8D93D649B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE remarques ADD CONSTRAINT FK_5AB3C171A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D322445E FOREIGN KEY (attestation_stage_id) REFERENCES attestation_stage (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913830278 FOREIGN KEY (fiche_evaluation_id) REFERENCES fiche_evaluation (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE attestation_stage ADD est_deploye TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD attestation_stage_validation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_evaluation ADD est_deploye TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD fiche_evaluation_validation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation ADD est_deploye TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD presentation_validation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD first_version_est_deploye TINYINT(1) DEFAULT NULL, ADD last_version_est_deploye TINYINT(1) DEFAULT NULL, ADD first_version_created_at DATETIME DEFAULT NULL, ADD first_version_updated_at DATETIME DEFAULT NULL, ADD last_version_created_at DATETIME DEFAULT NULL, ADD last_version_updated_at DATETIME DEFAULT NULL, ADD first_version_validation TINYINT(1) DEFAULT NULL, ADD last_version_validation TINYINT(1) DEFAULT NULL, CHANGE first_version first_version VARCHAR(255) DEFAULT NULL, CHANGE last_version last_version VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD numero_encadreur_ext VARCHAR(15) DEFAULT NULL, ADD email VARCHAR(100) DEFAULT NULL, ADD adresse_encadreur_ext VARCHAR(100) DEFAULT NULL, ADD a_fait_stage TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD encadre TINYINT(1) DEFAULT NULL, DROP note, CHANGE validation validation VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remarques DROP FOREIGN KEY FK_5AB3C171A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492298D193');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A4AEAFEA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491DFBCC46');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AB627E8B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D322445E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913830278');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B3E9C81');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE remarques');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE attestation_stage DROP est_deploye, DROP created_at, DROP updated_at, DROP attestation_stage_validation');
        $this->addSql('ALTER TABLE fiche_evaluation DROP est_deploye, DROP created_at, DROP updated_at, DROP fiche_evaluation_validation');
        $this->addSql('ALTER TABLE presentation DROP est_deploye, DROP created_at, DROP updated_at, DROP presentation_validation');
        $this->addSql('ALTER TABLE rapport DROP first_version_est_deploye, DROP last_version_est_deploye, DROP first_version_created_at, DROP first_version_updated_at, DROP last_version_created_at, DROP last_version_updated_at, DROP first_version_validation, DROP last_version_validation, CHANGE first_version first_version VARCHAR(255) NOT NULL, CHANGE last_version last_version VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE stage ADD note DOUBLE PRECISION DEFAULT NULL, DROP numero_encadreur_ext, DROP email, DROP adresse_encadreur_ext, DROP a_fait_stage, DROP created_at, DROP updated_at, DROP encadre, CHANGE validation validation TINYINT(1) DEFAULT NULL');
    }
}
