<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529142533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE center_of_interest DROP FOREIGN KEY FK_5FE515885AEA4428');
        $this->addSql('DROP INDEX IDX_5FE515885AEA4428 ON center_of_interest');
        $this->addSql('ALTER TABLE center_of_interest DROP curriculum_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, brochure_filename VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE center_of_interest ADD curriculum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE center_of_interest ADD CONSTRAINT FK_5FE515885AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_5FE515885AEA4428 ON center_of_interest (curriculum_id)');
    }
}
