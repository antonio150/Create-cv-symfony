<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418110547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personal_information (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) DEFAULT NULL, first_name VARCHAR(150) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, profil_title VARCHAR(255) DEFAULT NULL, telephone VARCHAR(50) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(10) DEFAULT NULL, city VARCHAR(200) DEFAULT NULL, sexe VARCHAR(15) DEFAULT NULL, nationality VARCHAR(30) DEFAULT NULL, marital_status VARCHAR(10) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE personal_information');
    }
}
