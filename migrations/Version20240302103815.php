<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302103815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, m2 DOUBLE PRECISION NOT NULL, jardin TINYINT(1) NOT NULL, garage TINYINT(1) NOT NULL, commune VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, INDEX IDX_F65593E5A76ED395 (user_id), INDEX IDX_F65593E5C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, annonce_id INT DEFAULT NULL, datetime DATETIME NOT NULL, INDEX IDX_B09C8CBBA76ED395 (user_id), INDEX IDX_B09C8CBB3414710B (agent_id), INDEX IDX_B09C8CBB8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB3414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE contact ADD user_id INT DEFAULT NULL, DROP nom, DROP email');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638A76ED395 ON contact (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C54C8C93');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBBA76ED395');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB3414710B');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB8805AB2F');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE visite');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A76ED395');
        $this->addSql('DROP INDEX IDX_4C62E638A76ED395 ON contact');
        $this->addSql('ALTER TABLE contact ADD nom VARCHAR(30) NOT NULL, ADD email VARCHAR(100) NOT NULL, DROP user_id');
    }
}
