<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408161632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cemetery ADD deck_id INT NOT NULL');
        $this->addSql('ALTER TABLE cemetery ADD CONSTRAINT FK_99E11326111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_99E11326111948DC ON cemetery (deck_id)');
        $this->addSql('ALTER TABLE pool ADD deck_id INT NOT NULL');
        $this->addSql('ALTER TABLE pool ADD CONSTRAINT FK_AF91A986111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF91A986111948DC ON pool (deck_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cemetery DROP FOREIGN KEY FK_99E11326111948DC');
        $this->addSql('DROP INDEX UNIQ_99E11326111948DC ON cemetery');
        $this->addSql('ALTER TABLE cemetery DROP deck_id');
        $this->addSql('ALTER TABLE pool DROP FOREIGN KEY FK_AF91A986111948DC');
        $this->addSql('DROP INDEX UNIQ_AF91A986111948DC ON pool');
        $this->addSql('ALTER TABLE pool DROP deck_id');
    }
}
