<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221113152058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobby_personne (hobby_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_46360CAE322B2123 (hobby_id), INDEX IDX_46360CAEA21BD112 (personne_id), PRIMARY KEY(hobby_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, personne_id_id INT DEFAULT NULL, designation VARCHAR(60) NOT NULL, INDEX IDX_FBD8E0F86BA58F3E (personne_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, age SMALLINT NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hobby_personne ADD CONSTRAINT FK_46360CAE322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hobby_personne ADD CONSTRAINT FK_46360CAEA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F86BA58F3E FOREIGN KEY (personne_id_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hobby_personne DROP FOREIGN KEY FK_46360CAE322B2123');
        $this->addSql('ALTER TABLE hobby_personne DROP FOREIGN KEY FK_46360CAEA21BD112');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F86BA58F3E');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE hobby_personne');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
