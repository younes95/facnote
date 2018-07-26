<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180629181216 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE droit ADD module_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE droit ADD CONSTRAINT FK_CB7AA7517648EE39 FOREIGN KEY (module_id_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_CB7AA7517648EE39 ON droit (module_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE droit DROP FOREIGN KEY FK_CB7AA7517648EE39');
        $this->addSql('DROP INDEX IDX_CB7AA7517648EE39 ON droit');
        $this->addSql('ALTER TABLE droit DROP module_id_id');
    }
}
