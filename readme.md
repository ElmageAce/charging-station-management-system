# Station management task

### Structure

I've used `laravel` & `react` as main backend and front-end frameworks, Data will be stored in `mariadb` as main database. 

`stations` would be indexed into `elasticsearch` for geo queries.
 
`nginx` is the server which will serve the application.

### Run

For executing the application simply run `docker-compose up -d`.

Then you may navigate to `localhost` in your web browser to load the application front-end.

#### Setup

After first run it needs to setup environment (such as run composer install, migrations, create elasticsearch index,
 install npm, and compile js components) It needs to run following commands:

```bash
# Run composer install and migrate the database
docker-compose exec core bash -c "composer install"
docker-compose exec core bash -c "php artisan migrate"
docker-compose exec core bash -c "php artisan elastic:create-index App\\\\Elastic\\\\Configurators\\\\StationConfigurator"
```

### Seeding the database

Execute the following command:

```bash
docker-compose exec core bash -c "php artisan migrate:fresh && php artisan db:seed --class=FakeDatabaseSeeder"
```

As you can see the above command first runs migrations (`php artisan migrate:fresh`) and then seeds some fake data
into the database (`php artisan db:seed --class=FakeDatabaseSeeder`) which you can run them separately.

> Note: before seeding the database please make sure if the index of stations has been created in `elasticsearch`, then run the `db:seed` command.

### Elasticsearch

In this project, the `elasticsearch` has been used for geo-queries (to find stations which are in a certain distance from
 a given point), so it needs to create an index for stations, the `laravel scout` and `elasticsearch` will do the rest.

>Since I have used `babenkoivan/scout-elasticsearch-driver` as the driver for connecting the `laravel scout` and
> the `elasticsearch` you may find the full documentation [here](https://packagist.org/packages/babenkoivan/scout-elasticsearch-driver) via packagist.

#### Create index
Execute the following command:

```bash
docker-compose exec core bash -c "php artisan elastic:create-index App\\\\Elastic\\\\Configurators\\\\StationConfigurator"
```

#### Drop index
Execute the following command:

```bash
docker-compose exec core bash -c "php artisan elastic:drop-index App\\\\Elastic\\\\Configurators\\\\StationConfigurator"
```

### Test

Simply execute the following command:

```bash
docker-compose exec core bash -c "php ./vendor/phpunit/phpunit/phpunit"
```

>Note: it takes about 22 seconds to complete tests, because it needs to put sleep before tests which are related to `elasticsearch` 
> in order to make sure everything is stored there successfully.
