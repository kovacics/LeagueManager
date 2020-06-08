<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200608014457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE "match_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competitor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE standings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE standings_row_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "match" (id INT NOT NULL, home_competitor_id INT NOT NULL, away_competitor_id INT NOT NULL, season_id INT NOT NULL, start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status INT NOT NULL, winner_code INT DEFAULT NULL, home_score_final INT DEFAULT NULL, home_score_overtime INT DEFAULT NULL, home_score_period1 INT DEFAULT NULL, home_score_period2 INT DEFAULT NULL, home_score_period3 INT DEFAULT NULL, home_score_period4 INT DEFAULT NULL, away_score_final INT DEFAULT NULL, away_score_overtime INT DEFAULT NULL, away_score_period1 INT DEFAULT NULL, away_score_period2 INT DEFAULT NULL, away_score_period3 INT DEFAULT NULL, away_score_period4 INT DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A5BC505651A1490 ON "match" (home_competitor_id)');
        $this->addSql('CREATE INDEX IDX_7A5BC505CAED3FFD ON "match" (away_competitor_id)');
        $this->addSql('CREATE INDEX IDX_7A5BC5054EC001D1 ON "match" (season_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C1AC78BCF8 ON category (sport_id)');
        $this->addSql('CREATE TABLE competition (id INT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, rounds INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B50A2CB112469DE2 ON competition (category_id)');
        $this->addSql('CREATE TABLE competitor (id INT NOT NULL, sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, country_name VARCHAR(255) DEFAULT NULL, country_alpha2 VARCHAR(255) DEFAULT NULL, country_alpha3 VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E0D53BAAAC78BCF8 ON competitor (sport_id)');
        $this->addSql('CREATE TABLE season (id INT NOT NULL, competition_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0E45BA97B39D312 ON season (competition_id)');
        $this->addSql('CREATE TABLE sport (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE standings (id INT NOT NULL, season_id INT DEFAULT NULL, type VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_93670F674EC001D1 ON standings (season_id)');
        $this->addSql('CREATE TABLE standings_row (id INT NOT NULL, competitor_id INT NOT NULL, standings_id INT NOT NULL, matches INT NOT NULL, wins INT NOT NULL, losses INT NOT NULL, scores_for INT NOT NULL, scores_against INT NOT NULL, draws INT DEFAULT NULL, points INT DEFAULT NULL, percentage DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_274C583878A5D405 ON standings_row (competitor_id)');
        $this->addSql('CREATE INDEX IDX_274C58387F97F032 ON standings_row (standings_id)');
        $this->addSql('ALTER TABLE "match" ADD CONSTRAINT FK_7A5BC505651A1490 FOREIGN KEY (home_competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "match" ADD CONSTRAINT FK_7A5BC505CAED3FFD FOREIGN KEY (away_competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "match" ADD CONSTRAINT FK_7A5BC5054EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competitor ADD CONSTRAINT FK_E0D53BAAAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standings ADD CONSTRAINT FK_93670F674EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standings_row ADD CONSTRAINT FK_274C583878A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE standings_row ADD CONSTRAINT FK_274C58387F97F032 FOREIGN KEY (standings_id) REFERENCES standings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT FK_B50A2CB112469DE2');
        $this->addSql('ALTER TABLE season DROP CONSTRAINT FK_F0E45BA97B39D312');
        $this->addSql('ALTER TABLE "match" DROP CONSTRAINT FK_7A5BC505651A1490');
        $this->addSql('ALTER TABLE "match" DROP CONSTRAINT FK_7A5BC505CAED3FFD');
        $this->addSql('ALTER TABLE standings_row DROP CONSTRAINT FK_274C583878A5D405');
        $this->addSql('ALTER TABLE "match" DROP CONSTRAINT FK_7A5BC5054EC001D1');
        $this->addSql('ALTER TABLE standings DROP CONSTRAINT FK_93670F674EC001D1');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1AC78BCF8');
        $this->addSql('ALTER TABLE competitor DROP CONSTRAINT FK_E0D53BAAAC78BCF8');
        $this->addSql('ALTER TABLE standings_row DROP CONSTRAINT FK_274C58387F97F032');
        $this->addSql('DROP SEQUENCE "match_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competitor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE season_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE standings_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE standings_row_id_seq CASCADE');
        $this->addSql('DROP TABLE "match"');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE competitor');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE standings');
        $this->addSql('DROP TABLE standings_row');
    }
}
