<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515161901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE email (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE input_param (id INT AUTO_INCREMENT NOT NULL, email_id INT NOT NULL, is_valid TINYINT(1) NOT NULL, return_method_result TINYINT(1) NOT NULL, original_value VARCHAR(1024) NOT NULL, processed_value VARCHAR(1024) NOT NULL, INDEX IDX_1C04B43DA832C1C9 (email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE input_param ADD CONSTRAINT FK_1C04B43DA832C1C9 FOREIGN KEY (email_id) REFERENCES email (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE input_param DROP FOREIGN KEY FK_1C04B43DA832C1C9');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE input_param');
    }
}
