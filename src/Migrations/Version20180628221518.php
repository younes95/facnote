<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180628221518 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE droit DROP FOREIGN KEY FK_CB7AA751FB88E14F');
        $this->addSql('ALTER TABLE droit DROP FOREIGN KEY FK_CB7AA751FCF77503');
        $this->addSql('DROP INDEX IDX_CB7AA751FB88E14F ON droit');
        $this->addSql('DROP INDEX IDX_CB7AA751FCF77503 ON droit');
        $this->addSql('ALTER TABLE droit ADD utilisateur_id_id INT DEFAULT NULL, ADD societe_id_id INT DEFAULT NULL, DROP utilisateur_id, DROP societe_id');
        $this->addSql('ALTER TABLE droit ADD CONSTRAINT FK_CB7AA751B981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE droit ADD CONSTRAINT FK_CB7AA75115969199 FOREIGN KEY (societe_id_id) REFERENCES societe (id)');
        $this->addSql('CREATE INDEX IDX_CB7AA751B981C689 ON droit (utilisateur_id_id)');
        $this->addSql('CREATE INDEX IDX_CB7AA75115969199 ON droit (societe_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE droit DROP FOREIGN KEY FK_CB7AA751B981C689');
        $this->addSql('ALTER TABLE droit DROP FOREIGN KEY FK_CB7AA75115969199');
        $this->addSql('DROP INDEX IDX_CB7AA751B981C689 ON droit');
        $this->addSql('DROP INDEX IDX_CB7AA75115969199 ON droit');
        $this->addSql('ALTER TABLE droit ADD utilisateur_id INT DEFAULT NULL, ADD societe_id INT DEFAULT NULL, DROP utilisateur_id_id, DROP societe_id_id');
        $this->addSql('ALTER TABLE droit ADD CONSTRAINT FK_CB7AA751FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE droit ADD CONSTRAINT FK_CB7AA751FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
        $this->addSql('CREATE INDEX IDX_CB7AA751FB88E14F ON droit (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_CB7AA751FCF77503 ON droit (societe_id)');
    }
}
