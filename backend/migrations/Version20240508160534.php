<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508160534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies CHANGE plot plot LONGTEXT NOT NULL, CHANGE wikipedia_url wikipedia_url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE movies_actors CHANGE star star TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE movies_actors RENAME INDEX movie_id TO IDX_A85722518F93B6FC');
        $this->addSql('ALTER TABLE movies_actors RENAME INDEX actor_id TO IDX_A857225110DAF24A');
        $this->addSql('ALTER TABLE movies_genres RENAME INDEX movie_id TO IDX_DF9737A28F93B6FC');
        $this->addSql('ALTER TABLE movies_genres RENAME INDEX genre_id TO IDX_DF9737A24296D31F');
        $this->addSql('ALTER TABLE movies_keywords CHANGE keyword keyword VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE movies_keywords RENAME INDEX movie_id TO IDX_422B1A668F93B6FC');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies CHANGE plot plot TEXT NOT NULL, CHANGE wikipedia_url wikipedia_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movies_keywords CHANGE keyword keyword VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movies_keywords RENAME INDEX idx_422b1a668f93b6fc TO movie_id');
        $this->addSql('ALTER TABLE movies_genres RENAME INDEX idx_df9737a28f93b6fc TO movie_id');
        $this->addSql('ALTER TABLE movies_genres RENAME INDEX idx_df9737a24296d31f TO genre_id');
        $this->addSql('ALTER TABLE movies_actors CHANGE star star TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE movies_actors RENAME INDEX idx_a85722518f93b6fc TO movie_id');
        $this->addSql('ALTER TABLE movies_actors RENAME INDEX idx_a857225110daf24a TO actor_id');
    }
}
