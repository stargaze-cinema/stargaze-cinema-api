<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220411133019 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE countries (id SERIAL NOT NULL, name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE country_movie (country_id INT NOT NULL, movie_id INT NOT NULL, PRIMARY KEY(country_id, movie_id))');
        $this->addSql('CREATE TABLE directors (id SERIAL NOT NULL, name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE director_movie (director_id INT NOT NULL, movie_id INT NOT NULL, PRIMARY KEY(director_id, movie_id))');
        $this->addSql('CREATE TABLE frames (id SERIAL NOT NULL, movie_id INT NOT NULL, image VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genres (id SERIAL NOT NULL, name VARCHAR(32) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre_movie (genre_id INT NOT NULL, movie_id INT NOT NULL, PRIMARY KEY(genre_id, movie_id))');
        $this->addSql('CREATE TABLE halls (id SERIAL NOT NULL, name VARCHAR(16) NOT NULL, capacity SMALLINT NOT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE languages (id SERIAL NOT NULL, name VARCHAR(64) NOT NULL, code VARCHAR(2) NOT NULL, native_name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movies (id SERIAL NOT NULL, language_id INT NOT NULL, title VARCHAR(64) NOT NULL, synopsis VARCHAR(65535) DEFAULT NULL, poster VARCHAR(255) DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, year SMALLINT NOT NULL, runtime SMALLINT NOT NULL, rating VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sessions (id SERIAL NOT NULL, movie_id INT NOT NULL, hall_id INT NOT NULL, begin_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tickets (id SERIAL NOT NULL, user_id INT NOT NULL, session_id INT NOT NULL, place SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, name VARCHAR(32) NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE INDEX country_movie_country_fkey ON country_movie (country_id)');
        $this->addSql('CREATE INDEX country_movie_movie_fkey ON country_movie (movie_id)');
        $this->addSql('CREATE INDEX director_movie_director_fkey ON director_movie (director_id)');
        $this->addSql('CREATE INDEX director_movie_movie_fkey ON director_movie (movie_id)');
        $this->addSql('CREATE INDEX frames_movie_fkey ON frames (movie_id)');
        $this->addSql('CREATE INDEX genre_movie_genre_fkey ON genre_movie (genre_id)');
        $this->addSql('CREATE INDEX genre_movie_movie_fkey ON genre_movie (movie_id)');
        $this->addSql('CREATE INDEX movies_language_fkey ON movies (language_id)');
        $this->addSql('CREATE INDEX sessions_movie_fkey ON sessions (movie_id)');
        $this->addSql('CREATE INDEX sessions_hall_fkey ON sessions (hall_id)');
        $this->addSql('CREATE INDEX tickets_user_fkey ON tickets (user_id)');
        $this->addSql('CREATE INDEX tickets_session_fkey ON tickets (session_id)');
        $this->addSql('CREATE UNIQUE INDEX users_email_key ON users (email)');

        $this->addSql('ALTER TABLE country_movie ADD CONSTRAINT country_movie_country_fkey FOREIGN KEY (country_id) REFERENCES countries (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE country_movie ADD CONSTRAINT country_movie_movie_fkey FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE director_movie ADD CONSTRAINT director_movie_director_fkey FOREIGN KEY (director_id) REFERENCES directors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE director_movie ADD CONSTRAINT director_movie_movie_fkey FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE frames ADD CONSTRAINT frames_movie_fkey FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genre_movie ADD CONSTRAINT genre_movie_genre_fkey FOREIGN KEY (genre_id) REFERENCES genres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genre_movie ADD CONSTRAINT genre_movie_movie_fkey FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT movies_language_fkey FOREIGN KEY (language_id) REFERENCES languages (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT sessions_movie_fkey FOREIGN KEY (movie_id) REFERENCES movies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT sessions_hall_fkey FOREIGN KEY (hall_id) REFERENCES halls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT tickets_user_fkey FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT tickets_session_fkey FOREIGN KEY (session_id) REFERENCES sessions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE country_movie');
        $this->addSql('DROP TABLE directors');
        $this->addSql('DROP TABLE director_movie');
        $this->addSql('DROP TABLE frames');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE genre_movie');
        $this->addSql('DROP TABLE halls');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('DROP TABLE tickets');
        $this->addSql('DROP TABLE users');
    }
}
