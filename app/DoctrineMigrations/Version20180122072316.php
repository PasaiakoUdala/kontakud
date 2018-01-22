<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180122072316 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Actions DROP FOREIGN KEY Actions_ibfk_1');
        $this->addSql('ALTER TABLE Atentions DROP FOREIGN KEY Atentions_ibfk_1');
        $this->addSql('CREATE TABLE kanala (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, content_changed_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tramite (id INT AUTO_INCREMENT NOT NULL, isResolved TINYINT(1) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, content_changed_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mota (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, content_changed_by VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_DA6591E35E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arreta (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, fetxa DATETIME NOT NULL, nan VARCHAR(255) NOT NULL, remitente VARCHAR(255) DEFAULT NULL, genero VARCHAR(255) DEFAULT NULL, adina VARCHAR(255) DEFAULT NULL, nazionalitatea VARCHAR(255) DEFAULT NULL, hizkuntza VARCHAR(255) DEFAULT NULL, barrutia VARCHAR(255) DEFAULT NULL, administrazioa VARCHAR(255) DEFAULT NULL, oharra LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, content_changed_by VARCHAR(255) DEFAULT NULL, INDEX IDX_FB44213A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arreta ADD CONSTRAINT FK_FB44213A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE Actions');
        $this->addSql('DROP TABLE Atentions');
        $this->addSql('DROP TABLE Types');
        $this->addSql('DROP TABLE fos_user');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Actions (id INT AUTO_INCREMENT NOT NULL, ini DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, result TINYINT(1) DEFAULT \'0\' NOT NULL, notes TEXT DEFAULT NULL COLLATE utf8_general_ci, code VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, AtentionId INT DEFAULT NULL, INDEX AtentionId (AtentionId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Atentions (id INT AUTO_INCREMENT NOT NULL, ini DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, result TINYINT(1) DEFAULT \'0\' NOT NULL, notes TEXT DEFAULT NULL COLLATE utf8_general_ci, language VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, gender VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, TypeId INT DEFAULT NULL, INDEX TypeId (TypeId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_general_ci, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, email_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL COLLATE utf8_unicode_ci, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Actions ADD CONSTRAINT Actions_ibfk_1 FOREIGN KEY (AtentionId) REFERENCES Atentions (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE Atentions ADD CONSTRAINT Atentions_ibfk_1 FOREIGN KEY (TypeId) REFERENCES Types (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('DROP TABLE kanala');
        $this->addSql('DROP TABLE tramite');
        $this->addSql('DROP TABLE mota');
        $this->addSql('DROP TABLE arreta');
    }
}
