# Stargaze Cinema API REST

RESTful API built with Symfony framework for the "Stargaze Cinema" project.

## Starting the application with Docker

1. Run `cp .env.example .env` in the terminal to create environment file.
2. Run `docker-compose up -d --build` to create containers and start the application.
3. Run `docker exec -it php sh` to enter Dockers' PHP console.
4. Run `composer install` to install dependencies.
5. Run `bin/console doctrine:database:create` to create database forthe application.
6. Run `bin/console doctrine:migrations:migrate` to add tables to the database.
7. Run `bin/console doctrine:fixtures:load` to seed the database.

-   Open `localhost:8000` in the browser to access the application.
-   Open `localhost:8080` in the browser to access PhpPgAdmin.
-   Open `localhost:8008` in the browser to access Swagger API Documentation.
-   Open `localhost:9001` in the browser to access MinIO Console.
