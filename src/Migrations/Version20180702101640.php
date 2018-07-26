<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180702101640 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE societe ADD id_type_societe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE societe ADD CONSTRAINT FK_19653DBD8AA60AE FOREIGN KEY (id_type_societe_id) REFERENCES type_societe (id)');
        $this->addSql('CREATE INDEX IDX_19653DBD8AA60AE ON societe (id_type_societe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE societe DROP FOREIGN KEY FK_19653DBD8AA60AE');
        $this->addSql('DROP INDEX IDX_19653DBD8AA60AE ON societe');
        $this->addSql('ALTER TABLE societe DROP id_type_societe_id');
    }
}
