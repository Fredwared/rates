### Requirements
 - Docker

#### Installation
 - From project directory run `docker-compose up -d`
 - Enter to app container named `rates_app` via `docker exec -it rates_app /bin/sh` and Run `composer install` this command installs all project dependencies
 - `cp .env.example .env` Create Environment file `.env` from `.env.example` Sample
 - Without exiting from container run `php artisan key:generate` to generate application key
 
 
By default, application uses `80` port you can change it in `docker-compose.yml` file.   
