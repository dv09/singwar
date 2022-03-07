<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307132149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, key_sing VARCHAR(1) NOT NULL, value_sing INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, plaintiff_id INT NOT NULL, defendant_id INT NOT NULL, plaintiffsing VARCHAR(3) NOT NULL, defendant_sing VARCHAR(3) NOT NULL, INDEX IDX_E98F2859A83635E6 (plaintiff_id), INDEX IDX_E98F28599960FFFB (defendant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trail (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, winner_id INT NOT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_B268858F2576E0FD (contract_id), INDEX IDX_B268858F5DFCD4B8 (winner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859A83635E6 FOREIGN KEY (plaintiff_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28599960FFFB FOREIGN KEY (defendant_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE trail ADD CONSTRAINT FK_B268858F2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE trail ADD CONSTRAINT FK_B268858F5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES party (id)');

        $this->addSql('insert into actor(name, key_sing, value_sing) values("King","K",5)');
        $this->addSql('insert into actor(name, key_sing, value_sing) values("Notary","N",2)');
        $this->addSql('insert into actor(name, key_sing, value_sing) values("Validator","V",1)');

        $this->addSql('insert into party(name) values("Plaintiff")');
        $this->addSql('insert into party(name) values("Defendant")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('delete from actor');
        $this->addSql('delete from party');

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trail DROP FOREIGN KEY FK_B268858F2576E0FD');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859A83635E6');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28599960FFFB');
        $this->addSql('ALTER TABLE trail DROP FOREIGN KEY FK_B268858F5DFCD4B8');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE trail');
    }
}
