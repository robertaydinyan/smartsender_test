<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328132944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE channel_customers (id INT AUTO_INCREMENT NOT NULL, channel_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_CD2EE51E72F5A1AA (channel_id), INDEX IDX_CD2EE51E9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE channel_customers ADD CONSTRAINT FK_CD2EE51E72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
        $this->addSql('ALTER TABLE channel_customers ADD CONSTRAINT FK_CD2EE51E9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel_customers DROP FOREIGN KEY FK_CD2EE51E72F5A1AA');
        $this->addSql('ALTER TABLE channel_customers DROP FOREIGN KEY FK_CD2EE51E9395C3F3');
        $this->addSql('DROP TABLE channel_customers');
    }
}
