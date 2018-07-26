<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180706184809 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ecriture ADD id_exercice_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ecriture ADD CONSTRAINT FK_3098DEB91C6CF6F FOREIGN KEY (id_exercice_id) REFERENCES exercice (id)');
        $this->addSql('CREATE INDEX IDX_3098DEB91C6CF6F ON ecriture (id_exercice_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ecriture DROP FOREIGN KEY FK_3098DEB91C6CF6F');
        $this->addSql('DROP INDEX IDX_3098DEB91C6CF6F ON ecriture');
        $this->addSql('ALTER TABLE ecriture DROP id_exercice_id');
    }
}
