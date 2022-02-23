<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223150721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE halls_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movies_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE producers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sessions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tickets_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, name VARCHAR(32) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE halls (id INT NOT NULL, name VARCHAR(16) NOT NULL, capacity SMALLINT NOT NULL, type VARCHAR(8) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movies (id INT NOT NULL, category_id INT NOT NULL, producer_id INT NOT NULL, title VARCHAR(64) NOT NULL, description VARCHAR(65535) DEFAULT NULL, poster VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, "year" SMALLINT NOT NULL, duration SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C61EED3012469DE2 ON movies (category_id)');
        $this->addSql('CREATE INDEX IDX_C61EED3089B658FE ON movies (producer_id)');
        $this->addSql('CREATE TABLE producers (id INT NOT NULL, name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sessions (id INT NOT NULL, movie_id INT NOT NULL, hall_id INT NOT NULL, begin_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9A609D138F93B6FC ON sessions (movie_id)');
        $this->addSql('CREATE INDEX IDX_9A609D1352AFCFD6 ON sessions (hall_id)');
        $this->addSql('CREATE TABLE tickets (id INT NOT NULL, client_id INT NOT NULL, session_id INT NOT NULL, place SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_54469DF419EB6921 ON tickets (client_id)');
        $this->addSql('CREATE INDEX IDX_54469DF4613FECDF ON tickets (session_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, name VARCHAR(32) NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(16) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED3012469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED3089B658FE FOREIGN KEY (producer_id) REFERENCES producers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D138F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D1352AFCFD6 FOREIGN KEY (hall_id) REFERENCES halls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF419EB6921 FOREIGN KEY (client_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4613FECDF FOREIGN KEY (session_id) REFERENCES sessions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE movies DROP CONSTRAINT FK_C61EED3012469DE2');
        $this->addSql('ALTER TABLE sessions DROP CONSTRAINT FK_9A609D1352AFCFD6');
        $this->addSql('ALTER TABLE sessions DROP CONSTRAINT FK_9A609D138F93B6FC');
        $this->addSql('ALTER TABLE movies DROP CONSTRAINT FK_C61EED3089B658FE');
        $this->addSql('ALTER TABLE tickets DROP CONSTRAINT FK_54469DF4613FECDF');
        $this->addSql('ALTER TABLE tickets DROP CONSTRAINT FK_54469DF419EB6921');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE halls_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movies_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE producers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sessions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tickets_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE halls');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE producers');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('DROP TABLE tickets');
        $this->addSql('DROP TABLE users');
    }
}
