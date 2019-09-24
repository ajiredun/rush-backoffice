<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190923201234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, last_modified_by_id INT NOT NULL, layout_id INT NOT NULL, route VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, last_modified_at DATETIME NOT NULL, published TINYINT(1) NOT NULL, roles JSON NOT NULL, seo_title VARCHAR(255) DEFAULT NULL, seo_meta_description VARCHAR(255) DEFAULT NULL, seo_allow_robot TINYINT(1) NOT NULL, seo_author VARCHAR(255) DEFAULT NULL, seo_keywords VARCHAR(255) DEFAULT NULL, INDEX IDX_140AB620F703974A (last_modified_by_id), INDEX IDX_140AB6208C22AA1A (layout_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620F703974A FOREIGN KEY (last_modified_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6208C22AA1A FOREIGN KEY (layout_id) REFERENCES layout (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE page');
    }
}
