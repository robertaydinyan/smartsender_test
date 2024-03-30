<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328164425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_history (id INT AUTO_INCREMENT NOT NULL, channel_id INT NOT NULL, title VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, created_at DATE NOT NULL, type INT NOT NULL, INDEX IDX_B7324A4772F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_history ADD CONSTRAINT FK_B7324A4772F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message_history DROP FOREIGN KEY FK_B7324A4772F5A1AA');
        $this->addSql('DROP TABLE message_history');
    }
}
