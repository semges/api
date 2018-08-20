<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180811142023 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) DEFAULT NULL, telephone1 VARCHAR(255) DEFAULT NULL, telephone2 VARCHAR(255) DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, online_registered TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_detail_program (contact_id INT NOT NULL, detail_program_id INT NOT NULL, INDEX IDX_86DF7991E7A1254A (contact_id), INDEX IDX_86DF799185A2B7DC (detail_program_id), PRIMARY KEY(contact_id, detail_program_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_commission (contact_id INT NOT NULL, commission_id INT NOT NULL, INDEX IDX_DBDC58CFE7A1254A (contact_id), INDEX IDX_DBDC58CF202D1EB2 (commission_id), PRIMARY KEY(contact_id, commission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_detail_program ADD CONSTRAINT FK_86DF7991E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_detail_program ADD CONSTRAINT FK_86DF799185A2B7DC FOREIGN KEY (detail_program_id) REFERENCES detail_program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_commission ADD CONSTRAINT FK_DBDC58CFE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_commission ADD CONSTRAINT FK_DBDC58CF202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participer ADD contact_id INT NOT NULL, ADD online_registered TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_EDBE16F8E7A1254A ON participer (contact_id)');
        $this->addSql('ALTER TABLE programme DROP anonyme1, DROP anonyme2, DROP anonyme3, DROP anonyme4, DROP anonyme5');
        $this->addSql('ALTER TABLE transaction_fin ADD contact_id INT NOT NULL, ADD payement_form SMALLINT NOT NULL, ADD ref_number VARCHAR(255) DEFAULT NULL, ADD auther_pay_method_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction_fin ADD CONSTRAINT FK_566A47F8E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_566A47F8E7A1254A ON transaction_fin (contact_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_detail_program DROP FOREIGN KEY FK_86DF7991E7A1254A');
        $this->addSql('ALTER TABLE contact_commission DROP FOREIGN KEY FK_DBDC58CFE7A1254A');
        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F8E7A1254A');
        $this->addSql('ALTER TABLE transaction_fin DROP FOREIGN KEY FK_566A47F8E7A1254A');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_detail_program');
        $this->addSql('DROP TABLE contact_commission');
        $this->addSql('DROP INDEX IDX_EDBE16F8E7A1254A ON participer');
        $this->addSql('ALTER TABLE participer DROP contact_id, DROP online_registered');
        $this->addSql('ALTER TABLE programme ADD anonyme1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme3 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme4 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme5 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('DROP INDEX IDX_566A47F8E7A1254A ON transaction_fin');
        $this->addSql('ALTER TABLE transaction_fin DROP contact_id, DROP payement_form, DROP ref_number, DROP auther_pay_method_name');
    }
}
