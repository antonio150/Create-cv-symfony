<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522092053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list_language (id INT AUTO_INCREMENT NOT NULL, id_language_id INT DEFAULT NULL, note_language INT DEFAULT NULL, created_at DATE DEFAULT NULL, updated_at DATE DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_AAB642D59AE37703 (id_language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_language ADD CONSTRAINT FK_AAB642D59AE37703 FOREIGN KEY (id_language_id) REFERENCES language (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE list_language');
    }
}
