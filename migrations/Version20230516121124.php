<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516121124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_field_information DROP FOREIGN KEY FK_1E81CFD94848E76E');
        $this->addSql('DROP INDEX IDX_1E81CFD94848E76E ON custom_field_information');
        $this->addSql('ALTER TABLE custom_field_information ADD personal_informatio_id INT NOT NULL, DROP field_name, CHANGE personal_information_id field_name_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD99F33B976 FOREIGN KEY (field_name_id) REFERENCES personal_information (id)');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD927BF378A FOREIGN KEY (personal_informatio_id) REFERENCES personal_information (id)');
        $this->addSql('CREATE INDEX IDX_1E81CFD99F33B976 ON custom_field_information (field_name_id)');
        $this->addSql('CREATE INDEX IDX_1E81CFD927BF378A ON custom_field_information (personal_informatio_id)');
        $this->addSql('ALTER TABLE personal_information ADD photo VARCHAR(100) DEFAULT NULL, ADD path VARCHAR(100) DEFAULT NULL, ADD position VARCHAR(100) DEFAULT NULL, ADD datenaiss DATETIME NOT NULL, ADD lieudenaiss VARCHAR(100) NOT NULL, ADD driver_license VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_field_information DROP FOREIGN KEY FK_1E81CFD99F33B976');
        $this->addSql('ALTER TABLE custom_field_information DROP FOREIGN KEY FK_1E81CFD927BF378A');
        $this->addSql('DROP INDEX IDX_1E81CFD99F33B976 ON custom_field_information');
        $this->addSql('DROP INDEX IDX_1E81CFD927BF378A ON custom_field_information');
        $this->addSql('ALTER TABLE custom_field_information ADD field_name VARCHAR(255) DEFAULT NULL, DROP personal_informatio_id, CHANGE field_name_id personal_information_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD94848E76E FOREIGN KEY (personal_information_id) REFERENCES personal_information (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1E81CFD94848E76E ON custom_field_information (personal_information_id)');
        $this->addSql('ALTER TABLE personal_information DROP photo, DROP path, DROP position, DROP datenaiss, DROP lieudenaiss, DROP driver_license');
    }
}
