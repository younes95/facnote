<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180630124705 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE societe ADD id_utilisateur_gerant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE societe ADD CONSTRAINT FK_19653DBD1419CB08 FOREIGN KEY (id_utilisateur_gerant_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_19653DBD1419CB08 ON societe (id_utilisateur_gerant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE societe DROP FOREIGN KEY FK_19653DBD1419CB08');
        $this->addSql('DROP INDEX IDX_19653DBD1419CB08 ON societe');
        $this->addSql('ALTER TABLE societe DROP id_utilisateur_gerant_id');
    }
}
