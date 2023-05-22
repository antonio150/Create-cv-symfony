<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522115553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE center_of_interest ADD id_cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE center_of_interest ADD CONSTRAINT FK_5FE51588216158D2 FOREIGN KEY (id_cv_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_5FE51588216158D2 ON center_of_interest (id_cv_id)');
        $this->addSql('ALTER TABLE curriculum ADD id_profil_id INT DEFAULT NULL, ADD id_user_id INT DEFAULT NULL, ADD id_bas_de_page_id INT DEFAULT NULL, ADD id_training_id INT DEFAULT NULL, ADD deleted TINYINT(1) DEFAULT NULL, ADD created_at DATE DEFAULT NULL, ADD updated_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE curriculum ADD CONSTRAINT FK_7BE2A7C3A76B6C5F FOREIGN KEY (id_profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE curriculum ADD CONSTRAINT FK_7BE2A7C379F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE curriculum ADD CONSTRAINT FK_7BE2A7C3394DCB69 FOREIGN KEY (id_bas_de_page_id) REFERENCES bas_de_page (id)');
        $this->addSql('ALTER TABLE curriculum ADD CONSTRAINT FK_7BE2A7C3A6EF5526 FOREIGN KEY (id_training_id) REFERENCES professional_training (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BE2A7C3A76B6C5F ON curriculum (id_profil_id)');
        $this->addSql('CREATE INDEX IDX_7BE2A7C379F37AE5 ON curriculum (id_user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BE2A7C3394DCB69 ON curriculum (id_bas_de_page_id)');
        $this->addSql('CREATE INDEX IDX_7BE2A7C3A6EF5526 ON curriculum (id_training_id)');
        $this->addSql('ALTER TABLE formation ADD id_cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF216158D2 FOREIGN KEY (id_cv_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_404021BF216158D2 ON formation (id_cv_id)');
        $this->addSql('ALTER TABLE list_language ADD id_cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list_language ADD CONSTRAINT FK_AAB642D5216158D2 FOREIGN KEY (id_cv_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_AAB642D5216158D2 ON list_language (id_cv_id)');
        $this->addSql('ALTER TABLE professional_experience ADD id_cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE professional_experience ADD CONSTRAINT FK_32FDB9BA216158D2 FOREIGN KEY (id_cv_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_32FDB9BA216158D2 ON professional_experience (id_cv_id)');
        $this->addSql('ALTER TABLE reference ADD id_cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reference ADD CONSTRAINT FK_AEA34913216158D2 FOREIGN KEY (id_cv_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_AEA34913216158D2 ON reference (id_cv_id)');
        $this->addSql('ALTER TABLE skill ADD id_cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477216158D2 FOREIGN KEY (id_cv_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477216158D2 ON skill (id_cv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE center_of_interest DROP FOREIGN KEY FK_5FE51588216158D2');
        $this->addSql('DROP INDEX IDX_5FE51588216158D2 ON center_of_interest');
        $this->addSql('ALTER TABLE center_of_interest DROP id_cv_id');
        $this->addSql('ALTER TABLE curriculum DROP FOREIGN KEY FK_7BE2A7C3A76B6C5F');
        $this->addSql('ALTER TABLE curriculum DROP FOREIGN KEY FK_7BE2A7C379F37AE5');
        $this->addSql('ALTER TABLE curriculum DROP FOREIGN KEY FK_7BE2A7C3394DCB69');
        $this->addSql('ALTER TABLE curriculum DROP FOREIGN KEY FK_7BE2A7C3A6EF5526');
        $this->addSql('DROP INDEX UNIQ_7BE2A7C3A76B6C5F ON curriculum');
        $this->addSql('DROP INDEX IDX_7BE2A7C379F37AE5 ON curriculum');
        $this->addSql('DROP INDEX UNIQ_7BE2A7C3394DCB69 ON curriculum');
        $this->addSql('DROP INDEX IDX_7BE2A7C3A6EF5526 ON curriculum');
        $this->addSql('ALTER TABLE curriculum DROP id_profil_id, DROP id_user_id, DROP id_bas_de_page_id, DROP id_training_id, DROP deleted, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF216158D2');
        $this->addSql('DROP INDEX IDX_404021BF216158D2 ON formation');
        $this->addSql('ALTER TABLE formation DROP id_cv_id');
        $this->addSql('ALTER TABLE list_language DROP FOREIGN KEY FK_AAB642D5216158D2');
        $this->addSql('DROP INDEX IDX_AAB642D5216158D2 ON list_language');
        $this->addSql('ALTER TABLE list_language DROP id_cv_id');
        $this->addSql('ALTER TABLE professional_experience DROP FOREIGN KEY FK_32FDB9BA216158D2');
        $this->addSql('DROP INDEX IDX_32FDB9BA216158D2 ON professional_experience');
        $this->addSql('ALTER TABLE professional_experience DROP id_cv_id');
        $this->addSql('ALTER TABLE reference DROP FOREIGN KEY FK_AEA34913216158D2');
        $this->addSql('DROP INDEX IDX_AEA34913216158D2 ON reference');
        $this->addSql('ALTER TABLE reference DROP id_cv_id');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477216158D2');
        $this->addSql('DROP INDEX IDX_5E3DE477216158D2 ON skill');
        $this->addSql('ALTER TABLE skill DROP id_cv_id');
    }
}
