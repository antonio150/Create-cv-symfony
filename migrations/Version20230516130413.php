<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516130413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_field_information DROP FOREIGN KEY FK_1E81CFD927BF378A');
        $this->addSql('DROP INDEX IDX_1E81CFD927BF378A ON custom_field_information');
        $this->addSql('ALTER TABLE custom_field_information CHANGE personal_informatio_id personal_information_id INT NOT NULL');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD94848E76E FOREIGN KEY (personal_information_id) REFERENCES personal_information (id)');
        $this->addSql('CREATE INDEX IDX_1E81CFD94848E76E ON custom_field_information (personal_information_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_field_information DROP FOREIGN KEY FK_1E81CFD94848E76E');
        $this->addSql('DROP INDEX IDX_1E81CFD94848E76E ON custom_field_information');
        $this->addSql('ALTER TABLE custom_field_information CHANGE personal_information_id personal_informatio_id INT NOT NULL');
        $this->addSql('ALTER TABLE custom_field_information ADD CONSTRAINT FK_1E81CFD927BF378A FOREIGN KEY (personal_informatio_id) REFERENCES personal_information (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1E81CFD927BF378A ON custom_field_information (personal_informatio_id)');
    }
}
