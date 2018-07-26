<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180715170848 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, id_civilite_id INT DEFAULT NULL, id_utilisateur_id INT DEFAULT NULL, id_societe_id INT DEFAULT NULL, nom_client VARCHAR(255) DEFAULT NULL, prenom_client VARCHAR(255) DEFAULT NULL, adresse_client LONGTEXT DEFAULT NULL, code_postal_client VARCHAR(10) DEFAULT NULL, ville_client VARCHAR(255) DEFAULT NULL, pays_client VARCHAR(255) DEFAULT NULL, tel_client VARCHAR(255) DEFAULT NULL, siret_client VARCHAR(255) DEFAULT NULL, mobile_client VARCHAR(255) DEFAULT NULL, email_client VARCHAR(255) DEFAULT NULL, numero_tva_client VARCHAR(255) DEFAULT NULL, notes_client LONGTEXT DEFAULT NULL, is_active_client TINYINT(1) DEFAULT NULL, INDEX IDX_C7440455210B8748 (id_civilite_id), INDEX IDX_C7440455C6EE5C49 (id_utilisateur_id), INDEX IDX_C7440455597DF5D4 (id_societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455210B8748 FOREIGN KEY (id_civilite_id) REFERENCES civilite (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455597DF5D4 FOREIGN KEY (id_societe_id) REFERENCES societe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE client');
    }
}
