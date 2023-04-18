<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418074743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, user_type_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) DEFAULT NULL, first_name VARCHAR(50) DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, adresse VARCHAR(100) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, is_blocked TINYINT(1) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), INDEX IDX_1D1C63B39D419299 (user_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B39D419299 FOREIGN KEY (user_type_id) REFERENCES user_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B39D419299');
        $this->addSql('DROP TABLE user_type');
        $this->addSql('DROP TABLE utilisateur');
    }
}
