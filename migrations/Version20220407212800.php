<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407212800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deck DROP FOREIGN KEY FK_4FAC3637D139835A');
        $this->addSql('ALTER TABLE deck DROP FOREIGN KEY FK_4FAC3637EC636C87');
        $this->addSql('DROP INDEX UNIQ_4FAC3637D139835A ON deck');
        $this->addSql('DROP INDEX UNIQ_4FAC3637EC636C87 ON deck');
        $this->addSql('ALTER TABLE deck DROP current_pool_id, DROP cemetery_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deck ADD current_pool_id INT DEFAULT NULL, ADD cemetery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC3637D139835A FOREIGN KEY (current_pool_id) REFERENCES deck (id)');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC3637EC636C87 FOREIGN KEY (cemetery_id) REFERENCES deck (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FAC3637D139835A ON deck (current_pool_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FAC3637EC636C87 ON deck (cemetery_id)');
    }
}
