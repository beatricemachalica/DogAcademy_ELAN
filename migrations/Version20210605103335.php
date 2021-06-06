<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210605103335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_94FD157C6C6E55B5A625945B5126AC4843C3D9C3450FF010 ON maitre');
        $this->addSql('CREATE FULLTEXT INDEX IDX_94FD157C6C6E55B5A625945B5126AC4843C3D9C3 ON maitre (nom, prenom, mail, ville)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_94FD157C6C6E55B5A625945B5126AC4843C3D9C3 ON maitre');
        $this->addSql('CREATE FULLTEXT INDEX IDX_94FD157C6C6E55B5A625945B5126AC4843C3D9C3450FF010 ON maitre (nom, prenom, mail, ville, telephone)');
    }
}
