<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191119201903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE object_product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, last_modified_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, reference_no VARCHAR(255) NOT NULL, brief_description VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, last_modified_at DATETIME NOT NULL, image VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, image02 VARCHAR(255) DEFAULT NULL, image03 VARCHAR(255) DEFAULT NULL, image04 VARCHAR(255) DEFAULT NULL, image05 VARCHAR(255) DEFAULT NULL, image06 VARCHAR(255) DEFAULT NULL, image07 VARCHAR(255) DEFAULT NULL, image08 VARCHAR(255) DEFAULT NULL, image09 VARCHAR(255) DEFAULT NULL, attribute01 VARCHAR(255) DEFAULT NULL, attribute01value VARCHAR(255) DEFAULT NULL, attribute02 VARCHAR(255) DEFAULT NULL, attribute02value VARCHAR(255) DEFAULT NULL, attribute03 VARCHAR(255) DEFAULT NULL, attribute03value VARCHAR(255) DEFAULT NULL, attribute04 VARCHAR(255) DEFAULT NULL, attribute04value VARCHAR(255) DEFAULT NULL, attribute05 VARCHAR(255) DEFAULT NULL, attribute05value VARCHAR(255) DEFAULT NULL, question01 VARCHAR(255) DEFAULT NULL, question02 VARCHAR(255) DEFAULT NULL, question03 VARCHAR(255) DEFAULT NULL, question04 VARCHAR(255) DEFAULT NULL, question05 VARCHAR(255) DEFAULT NULL, display TINYINT(1) NOT NULL, sell_online TINYINT(1) NOT NULL, price VARCHAR(255) DEFAULT NULL, price_as_from TINYINT(1) NOT NULL, INDEX IDX_D304840D12469DE2 (category_id), INDEX IDX_D304840DF703974A (last_modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE object_product ADD CONSTRAINT FK_D304840D12469DE2 FOREIGN KEY (category_id) REFERENCES object_category (id)');
        $this->addSql('ALTER TABLE object_product ADD CONSTRAINT FK_D304840DF703974A FOREIGN KEY (last_modified_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE object_product');
    }
}
