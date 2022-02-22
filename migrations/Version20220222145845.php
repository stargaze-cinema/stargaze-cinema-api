<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220222145845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hall_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE producer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(32) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hall (id INT NOT NULL, name VARCHAR(16) NOT NULL, capacity SMALLINT NOT NULL, type VARCHAR(8) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, category_id INT NOT NULL, producer_id INT NOT NULL, title VARCHAR(64) NOT NULL, description VARCHAR(65535) DEFAULT NULL, poster VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, "year" SMALLINT NOT NULL, duration SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1D5EF26F12469DE2 ON movie (category_id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F89B658FE ON movie (producer_id)');
        $this->addSql('CREATE TABLE producer (id INT NOT NULL, name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE session (id INT NOT NULL, movie_id INT NOT NULL, hall_id INT NOT NULL, begin_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D48F93B6FC ON session (movie_id)');
        $this->addSql('CREATE INDEX IDX_D044D5D452AFCFD6 ON session (hall_id)');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, client_id INT NOT NULL, session_id INT NOT NULL, place SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA319EB6921 ON ticket (client_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3613FECDF ON ticket (session_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, name VARCHAR(32) NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(16) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F89B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D48F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D452AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA319EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE movie DROP CONSTRAINT FK_1D5EF26F12469DE2');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D452AFCFD6');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D48F93B6FC');
        $this->addSql('ALTER TABLE movie DROP CONSTRAINT FK_1D5EF26F89B658FE');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3613FECDF');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA319EB6921');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hall_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE producer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE session_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE producer');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE "user"');
    }
}
