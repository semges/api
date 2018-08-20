<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180811130106 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commission_participant DROP FOREIGN KEY FK_FE1548C9D1C3019');
        $this->addSql('ALTER TABLE detail_program_participant DROP FOREIGN KEY FK_19CDE85B9D1C3019');
        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F89D1C3019');
        $this->addSql('ALTER TABLE transaction_fin DROP FOREIGN KEY FK_566A47F89D1C3019');
        $this->addSql('DROP TABLE commission_participant');
        $this->addSql('DROP TABLE detail_program_participant');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP INDEX IDX_EDBE16F89D1C3019 ON participer');
        $this->addSql('ALTER TABLE participer DROP participant_id');
        $this->addSql('DROP INDEX IDX_566A47F89D1C3019 ON transaction_fin');
        $this->addSql('ALTER TABLE transaction_fin DROP participant_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commission_participant (commission_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_FE1548C202D1EB2 (commission_id), INDEX IDX_FE1548C9D1C3019 (participant_id), PRIMARY KEY(commission_id, participant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_program_participant (detail_program_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_19CDE85B85A2B7DC (detail_program_id), INDEX IDX_19CDE85B9D1C3019 (participant_id), PRIMARY KEY(detail_program_id, participant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, nom_prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, telephone2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, adresse1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, adresse2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, mail VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, onlin_registered TINYINT(1) NOT NULL, anonyme1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme3 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme4 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme5 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme6 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme7 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme8 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme9 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme10 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commission_participant ADD CONSTRAINT FK_FE1548C202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commission_participant ADD CONSTRAINT FK_FE1548C9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_program_participant ADD CONSTRAINT FK_19CDE85B85A2B7DC FOREIGN KEY (detail_program_id) REFERENCES detail_program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_program_participant ADD CONSTRAINT FK_19CDE85B9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participer ADD participant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F89D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('CREATE INDEX IDX_EDBE16F89D1C3019 ON participer (participant_id)');
        $this->addSql('ALTER TABLE transaction_fin ADD participant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction_fin ADD CONSTRAINT FK_566A47F89D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('CREATE INDEX IDX_566A47F89D1C3019 ON transaction_fin (participant_id)');
    }
}
