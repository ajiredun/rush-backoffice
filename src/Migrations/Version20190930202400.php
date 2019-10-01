<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190930202400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE block (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, last_modified_by_id INT NOT NULL, created_at DATETIME NOT NULL, last_modified_at DATETIME NOT NULL, slot VARCHAR(255) NOT NULL, block_order INT NOT NULL, properties JSON NOT NULL, data JSON NOT NULL, roles JSON NOT NULL, INDEX IDX_831B9722C4663E4 (page_id), INDEX IDX_831B9722F703974A (last_modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B9722C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B9722F703974A FOREIGN KEY (last_modified_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE block');
    }
}
