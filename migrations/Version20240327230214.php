<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327230214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relations between customer, channel_customers, and channel tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE channel_customers ADD CONSTRAINT FK_channel_customers_customer_id FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE channel_customers ADD CONSTRAINT FK_channel_customers_channel_id FOREIGN KEY (channel_id) REFERENCES channel (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE channel_customers DROP FOREIGN KEY FK_channel_customers_customer_id');
        $this->addSql('ALTER TABLE channel_customers DROP FOREIGN KEY FK_channel_customers_channel_id');
    }
}
