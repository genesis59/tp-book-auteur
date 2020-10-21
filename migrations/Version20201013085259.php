<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013085259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, editeur_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, published_at DATETIME NOT NULL, price NUMERIC(5, 2) NOT NULL, INDEX IDX_CBE5A3313375BD21 (editeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_auteur (book_id INT NOT NULL, auteur_id INT NOT NULL, INDEX IDX_2C8DBACD16A2B381 (book_id), INDEX IDX_2C8DBACD60BB6FE6 (auteur_id), PRIMARY KEY(book_id, auteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editeur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3313375BD21 FOREIGN KEY (editeur_id) REFERENCES editeur (id)');
        $this->addSql('ALTER TABLE book_auteur ADD CONSTRAINT FK_2C8DBACD16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_auteur ADD CONSTRAINT FK_2C8DBACD60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_auteur DROP FOREIGN KEY FK_2C8DBACD60BB6FE6');
        $this->addSql('ALTER TABLE book_auteur DROP FOREIGN KEY FK_2C8DBACD16A2B381');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3313375BD21');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_auteur');
        $this->addSql('DROP TABLE editeur');
    }
}
