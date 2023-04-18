<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418114912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professional_training ADD curriculum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE professional_training ADD CONSTRAINT FK_469450325AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum (id)');
        $this->addSql('CREATE INDEX IDX_469450325AEA4428 ON professional_training (curriculum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professional_training DROP FOREIGN KEY FK_469450325AEA4428');
        $this->addSql('DROP INDEX IDX_469450325AEA4428 ON professional_training');
        $this->addSql('ALTER TABLE professional_training DROP curriculum_id');
    }
}
