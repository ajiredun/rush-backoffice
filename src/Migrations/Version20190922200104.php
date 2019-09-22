<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190922200104 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE layout (id INT AUTO_INCREMENT NOT NULL, visual_pack_id INT NOT NULL, code VARCHAR(255) NOT NULL, visual VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, structure LONGTEXT NOT NULL, slots JSON NOT NULL COMMENT \'(DC2Type:json_array)\', INDEX IDX_3A3A6BE21AD06DCA (visual_pack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visual_pack (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE layout ADD CONSTRAINT FK_3A3A6BE21AD06DCA FOREIGN KEY (visual_pack_id) REFERENCES visual_pack (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE layout DROP FOREIGN KEY FK_3A3A6BE21AD06DCA');
        $this->addSql('DROP TABLE layout');
        $this->addSql('DROP TABLE visual_pack');
    }
}
