# Station management task

### Structure

I've used `laravel` & `react` as main backend and front-end frameworks, Data will be stored in `mariadb` as main database. 

`stations` would be indexed into `elasticsearch` for geo queries.
 
`nginx` is the server which will serve the application.

### Run

For executing the application simply run `./run.sh` it will run following containers:

  - nginx
  - redis
  - php-fpm
  - elasticsearch
  - mariadb
  - docker-in-docker
  - workspace
  - phpmyadmin
  
Or you can simply navigate to `laradock` folder and run following command to run containers, migrate the database, and 
compile front-end components:

```bash
# Create valid .env file
cp .env.docker .env
# then you need to navigate to laradock folder

# Run containers
docker-compose up -d nginx mariadb phpmyadmin redis workspace elasticsearch

# Run composer install and migrate the database  
docker-compose exec workspace bash -c "composer install"
docker-compose exec workspace bash -c "php artisan optimize"
docker-compose exec workspace bash -c "php artisan migrate"

# Install npm and prepare for production
docker-compose exec workspace bash -c "npm install"
docker-compose exec workspace bash -c "npm run prod"
```

### Seeding the database

In the `laradock` folder execute the following command:

```bash
docker-compose exec workspace bash -c "php artisan migrate:fresh && php artisan db:seed --class=FakeDatabaseSeeder"
```

As you can see the above command first runs migrations (`php artisan migrate:fresh`) and then seeds some fake data
into the database (`php artisan db:seed --class=FakeDatabaseSeeder`) which you can run them separately.

### Test

To run the unit tests in the `laradock` folder simply execute the following command:

```bash
docker-compose exec workspace bash -c "php ./vendor/phpunit/phpunit/phpunit"
```

>Note: it takes about 22 seconds to complete tests, because it needs to put sleep before tests which are related to `elasticsearch` 
> in order to make sure everything is stored there successfully.

### Run commands

To execute any other commands, it needs to Enter the `workspace` container 

```bash
docker-compose exec workspace bash
```
 
