<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712082123 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE week (id INT AUTO_INCREMENT NOT NULL, week_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week_roster (week_id INT NOT NULL, roster_id INT NOT NULL, INDEX IDX_14C3D4AAC86F3B2F (week_id), INDEX IDX_14C3D4AA75404483 (roster_id), PRIMARY KEY(week_id, roster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE week_roster ADD CONSTRAINT FK_14C3D4AAC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE week_roster ADD CONSTRAINT FK_14C3D4AA75404483 FOREIGN KEY (roster_id) REFERENCES roster (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE week_roster DROP FOREIGN KEY FK_14C3D4AAC86F3B2F');
        $this->addSql('DROP TABLE week');
        $this->addSql('DROP TABLE week_roster');
    }
}
