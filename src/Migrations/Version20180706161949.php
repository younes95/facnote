<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180706161949 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ecriture (id INT AUTO_INCREMENT NOT NULL, id_journal_id INT DEFAULT NULL, id_societe_id INT NOT NULL, token_ecriture VARCHAR(255) NOT NULL, date_ecriture DATE DEFAULT NULL, libelle_ecriture VARCHAR(255) DEFAULT NULL, num_compte_ecriture VARCHAR(255) DEFAULT NULL, debit_ecriture NUMERIC(15, 2) DEFAULT NULL, credit_ecriture NUMERIC(15, 2) DEFAULT NULL, INDEX IDX_3098DEBE20408D5 (id_journal_id), INDEX IDX_3098DEB597DF5D4 (id_societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, libelle_exercice VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE journal (id INT AUTO_INCREMENT NOT NULL, libelle_journal VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ecriture ADD CONSTRAINT FK_3098DEBE20408D5 FOREIGN KEY (id_journal_id) REFERENCES journal (id)');
        $this->addSql('ALTER TABLE ecriture ADD CONSTRAINT FK_3098DEB597DF5D4 FOREIGN KEY (id_societe_id) REFERENCES societe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ecriture DROP FOREIGN KEY FK_3098DEBE20408D5');
        $this->addSql('DROP TABLE ecriture');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('DROP TABLE journal');
    }
}
