<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191119200801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE object_category (id INT AUTO_INCREMENT NOT NULL, last_modified_by_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, last_modifed_at DATETIME NOT NULL, INDEX IDX_D09AF4A9F703974A (last_modified_by_id), INDEX IDX_D09AF4A912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE object_category ADD CONSTRAINT FK_D09AF4A9F703974A FOREIGN KEY (last_modified_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE object_category ADD CONSTRAINT FK_D09AF4A912469DE2 FOREIGN KEY (category_id) REFERENCES object_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE object_category DROP FOREIGN KEY FK_D09AF4A912469DE2');
        $this->addSql('DROP TABLE object_category');
    }
}
