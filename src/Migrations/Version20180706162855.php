<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180706162855 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exercice ADD id_societe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74D597DF5D4 FOREIGN KEY (id_societe_id) REFERENCES societe (id)');
        $this->addSql('CREATE INDEX IDX_E418C74D597DF5D4 ON exercice (id_societe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74D597DF5D4');
        $this->addSql('DROP INDEX IDX_E418C74D597DF5D4 ON exercice');
        $this->addSql('ALTER TABLE exercice DROP id_societe_id');
    }
}
