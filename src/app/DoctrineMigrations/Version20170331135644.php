<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170331135644 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE survey_answer (id INT AUTO_INCREMENT NOT NULL, ts DATETIME NOT NULL, gender VARCHAR(10) NOT NULL, birth_year SMALLINT DEFAULT NULL, diagnosis_year SMALLINT DEFAULT NULL, alsfrsr SMALLINT NOT NULL, verbal_score SMALLINT NOT NULL, diagnosis VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answers_sentences (answer_id INT NOT NULL, sentence_id INT NOT NULL, INDEX IDX_43BDBB2DAA334807 (answer_id), INDEX IDX_43BDBB2D27289490 (sentence_id), PRIMARY KEY(answer_id, sentence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey_sentence (id INT AUTO_INCREMENT NOT NULL, it_text VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C19108F23B8BA7C7 (it_text), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answers_sentences ADD CONSTRAINT FK_43BDBB2DAA334807 FOREIGN KEY (answer_id) REFERENCES survey_answer (id)');
        $this->addSql('ALTER TABLE answers_sentences ADD CONSTRAINT FK_43BDBB2D27289490 FOREIGN KEY (sentence_id) REFERENCES survey_sentence (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answers_sentences DROP FOREIGN KEY FK_43BDBB2DAA334807');
        $this->addSql('ALTER TABLE answers_sentences DROP FOREIGN KEY FK_43BDBB2D27289490');
        $this->addSql('DROP TABLE survey_answer');
        $this->addSql('DROP TABLE answers_sentences');
        $this->addSql('DROP TABLE survey_sentence');
    }
}
