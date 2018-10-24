<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180811143636 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anonyme_field (id INT AUTO_INCREMENT NOT NULL, seminaire_id INT DEFAULT NULL, programme_id INT DEFAULT NULL, contact_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, valeur VARCHAR(255) DEFAULT NULL, INDEX IDX_BF1F07B3CEA14D8 (seminaire_id), INDEX IDX_BF1F07B362BB7AEE (programme_id), INDEX IDX_BF1F07B3E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anonyme_field ADD CONSTRAINT FK_BF1F07B3CEA14D8 FOREIGN KEY (seminaire_id) REFERENCES seminaire (id)');
        $this->addSql('ALTER TABLE anonyme_field ADD CONSTRAINT FK_BF1F07B362BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE anonyme_field ADD CONSTRAINT FK_BF1F07B3E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE anonyme_field');
    }
}
