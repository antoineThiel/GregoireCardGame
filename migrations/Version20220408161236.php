<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408161236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cemetery (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pool (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD pool_id INT DEFAULT NULL, ADD cemetery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D37B3406DF FOREIGN KEY (pool_id) REFERENCES pool (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3EC636C87 FOREIGN KEY (cemetery_id) REFERENCES cemetery (id)');
        $this->addSql('CREATE INDEX IDX_161498D37B3406DF ON card (pool_id)');
        $this->addSql('CREATE INDEX IDX_161498D3EC636C87 ON card (cemetery_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3EC636C87');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D37B3406DF');
        $this->addSql('DROP TABLE cemetery');
        $this->addSql('DROP TABLE pool');
        $this->addSql('DROP INDEX IDX_161498D37B3406DF ON card');
        $this->addSql('DROP INDEX IDX_161498D3EC636C87 ON card');
        $this->addSql('ALTER TABLE card DROP pool_id, DROP cemetery_id');
    }
}
