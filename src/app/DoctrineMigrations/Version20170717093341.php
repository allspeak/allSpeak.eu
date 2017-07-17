<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170717093341 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE news_post (id INT AUTO_INCREMENT NOT NULL, it_text VARCHAR(600) DEFAULT NULL, en_text VARCHAR(600) DEFAULT NULL, link VARCHAR(600) DEFAULT NULL, ts DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE survey_sentence RENAME INDEX uniq_c19108f23b8ba7c7 TO UNIQ_C19108F2B37DB95E');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE news_post');
        $this->addSql('ALTER TABLE survey_sentence RENAME INDEX uniq_c19108f2b37db95e TO UNIQ_C19108F23B8BA7C7');
    }
}
