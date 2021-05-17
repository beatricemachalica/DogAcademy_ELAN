<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517092916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, libelle VARCHAR(55) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_E1BB1823BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chien (id INT AUTO_INCREMENT NOT NULL, maitre_id INT NOT NULL, nom VARCHAR(55) NOT NULL, INDEX IDX_13A4067ECF133C25 (maitre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(55) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maitre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(55) NOT NULL, mail VARCHAR(65) NOT NULL, prenom VARCHAR(55) NOT NULL, date_naissance DATE DEFAULT NULL, ville VARCHAR(55) NOT NULL, telephone VARCHAR(65) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, nb_place INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_D044D5D45200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_chien (session_id INT NOT NULL, chien_id INT NOT NULL, INDEX IDX_C8D9BEA8613FECDF (session_id), INDEX IDX_C8D9BEA8BFCF400E (chien_id), PRIMARY KEY(session_id, chien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE chien ADD CONSTRAINT FK_13A4067ECF133C25 FOREIGN KEY (maitre_id) REFERENCES maitre (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session_chien ADD CONSTRAINT FK_C8D9BEA8613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_chien ADD CONSTRAINT FK_C8D9BEA8BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823BCF5E72D');
        $this->addSql('ALTER TABLE session_chien DROP FOREIGN KEY FK_C8D9BEA8BFCF400E');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45200282E');
        $this->addSql('ALTER TABLE chien DROP FOREIGN KEY FK_13A4067ECF133C25');
        $this->addSql('ALTER TABLE session_chien DROP FOREIGN KEY FK_C8D9BEA8613FECDF');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE chien');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE maitre');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_chien');
    }
}
