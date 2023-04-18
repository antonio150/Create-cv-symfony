<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418111301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE custom_field_information (id INT AUTO_INCREMENT NOT NULL, personal_information_id INT DEFAULT NULL, field_name VARCHAR(255) DEFAULT NULL, field_contents VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_1E81CFD94848E76E (personal_information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD94848E76E FOREIGN KEY (personal_information_id) REFERENCES personal_information (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE custom_field_information');
    }
}
