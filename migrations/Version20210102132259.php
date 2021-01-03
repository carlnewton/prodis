<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102132259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, flow_id INT NOT NULL, parent_step_id INT NOT NULL, step_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_36AC99F17EB60D1B (flow_id), INDEX IDX_36AC99F11FA6ADA (parent_step_id), INDEX IDX_36AC99F173B21E9C (step_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F17EB60D1B FOREIGN KEY (flow_id) REFERENCES flow (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F11FA6ADA FOREIGN KEY (parent_step_id) REFERENCES step (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F173B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C7EB60D1B');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C7EB60D1B FOREIGN KEY (flow_id) REFERENCES flow (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE link');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C7EB60D1B');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C7EB60D1B FOREIGN KEY (flow_id) REFERENCES flow (id)');
    }
}
