<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531084420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_language DROP INDEX UNIQ_AAB642D59AE37703, ADD INDEX IDX_AAB642D59AE37703 (id_language_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_language DROP INDEX IDX_AAB642D59AE37703, ADD UNIQUE INDEX UNIQ_AAB642D59AE37703 (id_language_id)');
    }
}
