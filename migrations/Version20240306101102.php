<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306101102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5D44F05E5');
        $this->addSql('DROP INDEX IDX_F65593E5D44F05E5 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP images_id, DROP image');
        $this->addSql('ALTER TABLE images ADD annonce_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, DROP name');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A8805AB2F ON images (annonce_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE annonce ADD images_id INT DEFAULT NULL, ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5D44F05E5 FOREIGN KEY (images_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5D44F05E5 ON annonce (images_id)');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8805AB2F');
        $this->addSql('DROP INDEX IDX_E01FBE6A8805AB2F ON images');
        $this->addSql('ALTER TABLE images ADD name VARCHAR(500) NOT NULL, DROP annonce_id, DROP nom');
    }
}
