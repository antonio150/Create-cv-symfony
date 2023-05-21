<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521115141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE center_of_interest (id INT AUTO_INCREMENT NOT NULL, curriculum_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5FE515885AEA4428 (curriculum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(15) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum (id INT AUTO_INCREMENT NOT NULL, personal_information_id INT DEFAULT NULL, INDEX IDX_7BE2A7C34848E76E (personal_information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE custom_field_information (id INT AUTO_INCREMENT NOT NULL, field_name_id INT DEFAULT NULL, personal_information_id INT NOT NULL, field_contents VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_1E81CFD99F33B976 (field_name_id), INDEX IDX_1E81CFD94848E76E (personal_information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, training VARCHAR(100) DEFAULT NULL, establishment VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, month_start INT NOT NULL, year_start INT NOT NULL, month_end INT NOT NULL, year_end INT NOT NULL, this_day TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, curriculum_id INT DEFAULT NULL, language VARCHAR(50) DEFAULT NULL, level INT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_D4DB71B55AEA4428 (curriculum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personal_information (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(100) DEFAULT NULL, path VARCHAR(100) DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, first_name VARCHAR(150) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, position VARCHAR(100) DEFAULT NULL, telephone VARCHAR(50) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(10) DEFAULT NULL, city VARCHAR(200) DEFAULT NULL, datenaiss DATETIME NOT NULL, lieudenaiss VARCHAR(100) NOT NULL, driver_license VARCHAR(100) DEFAULT NULL, sexe VARCHAR(15) DEFAULT NULL, nationality VARCHAR(30) DEFAULT NULL, marital_status VARCHAR(10) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional_experience (id INT AUTO_INCREMENT NOT NULL, curriculum_id INT DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, company VARCHAR(200) DEFAULT NULL, city VARCHAR(150) DEFAULT NULL, month_start INT DEFAULT NULL, year_start INT DEFAULT NULL, month_end INT DEFAULT NULL, year_end INT DEFAULT NULL, this_day TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_32FDB9BA5AEA4428 (curriculum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional_training (id INT AUTO_INCREMENT NOT NULL, curriculum_id INT DEFAULT NULL, training VARCHAR(255) DEFAULT NULL, establishment VARCHAR(255) DEFAULT NULL, city VARCHAR(150) DEFAULT NULL, month_start INT DEFAULT NULL, year_start INT DEFAULT NULL, month_end INT DEFAULT NULL, year_end INT DEFAULT NULL, this_day TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_469450325AEA4428 (curriculum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, curriculum_id INT DEFAULT NULL, skill VARCHAR(255) DEFAULT NULL, level INT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5E3DE4775AEA4428 (curriculum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE center_of_interest ADD CONSTRAINT FK_5FE515885AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id)');
        $this->addSql('ALTER TABLE curriculum ADD CONSTRAINT FK_7BE2A7C34848E76E FOREIGN KEY (personal_information_id) REFERENCES personal_information (id)');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD99F33B976 FOREIGN KEY (field_name_id) REFERENCES personal_information (id)');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD94848E76E FOREIGN KEY (personal_information_id) REFERENCES personal_information (id)');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B55AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id)');
        $this->addSql('ALTER TABLE professional_experience ADD CONSTRAINT FK_32FDB9BA5AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id)');
        $this->addSql('ALTER TABLE professional_training ADD CONSTRAINT FK_469450325AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4775AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id)');
        $this->addSql('ALTER TABLE utilisateur ADD contract_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B32576E0FD ON utilisateur (contract_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32576E0FD');
        $this->addSql('ALTER TABLE center_of_interest DROP FOREIGN KEY FK_5FE515885AEA4428');
        $this->addSql('ALTER TABLE language DROP FOREIGN KEY FK_D4DB71B55AEA4428');
        $this->addSql('ALTER TABLE professional_experience DROP FOREIGN KEY FK_32FDB9BA5AEA4428');
        $this->addSql('ALTER TABLE professional_training DROP FOREIGN KEY FK_469450325AEA4428');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4775AEA4428');
        $this->addSql('ALTER TABLE curriculum DROP FOREIGN KEY FK_7BE2A7C34848E76E');
        $this->addSql('ALTER TABLE custom_field_information DROP FOREIGN KEY FK_1E81CFD99F33B976');
        $this->addSql('ALTER TABLE custom_field_information DROP FOREIGN KEY FK_1E81CFD94848E76E');
        $this->addSql('DROP TABLE center_of_interest');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE curriculum');
        $this->addSql('DROP TABLE custom_field_information');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE personal_information');
        $this->addSql('DROP TABLE professional_experience');
        $this->addSql('DROP TABLE professional_training');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP INDEX IDX_1D1C63B32576E0FD ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD type VARCHAR(20) DEFAULT NULL, DROP contract_id');
    }
}
