<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522055254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professional_training ADD position VARCHAR(150) DEFAULT NULL, ADD employer VARCHAR(150) DEFAULT NULL, DROP training, DROP establishment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professional_training ADD training VARCHAR(255) DEFAULT NULL, ADD establishment VARCHAR(255) DEFAULT NULL, DROP position, DROP employer');
    }
}
