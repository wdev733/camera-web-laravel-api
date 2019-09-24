## Installation

Clone the project and navigate to project directory.

````
$ cd project_dir
````

Use Docker's ``composer-php7.2 image`` to mount the directories that we will need for your Laravel project and avoid the overhead of installing Composer globally:
````
$ docker run --rm -v $(pwd):/app prooph/composer:7.2 install
````
Create ``.env`` file for Laravel by copying the example file
````
$ cp .env.example .env
````

Now we just need to issue a single command to start all of the containers, create the volumes, and set up and connect the networks:
````
$ docker-compose up -d
````

Open the ``.env`` file and make sure the database settings are correct (they will already be correct if you are using the Docker Compose script)
````
$ nano .env
````
````
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=dashboard
DB_USERNAME=dashboard
DB_PASSWORD=secret
````
Set the application key for the Laravel application
````
$ docker-compose exec app php artisan key:generate

````
Run the database migrations
````
$ docker-compose exec app php artisan migrate
````

Run the database seeds
````
$ docker-compose exec app php artisan db:seed
````

Build the frontend assets
````
$ npm install
$ npm run dev
````


JWT configuration: secret key generation
````
$ docker-compose exec app php artisan jwt:secret 
````

Default admin user credentials
````
email: testadmin@test.com
passw: topsecret
````

Frontend is now available at:``http://localhost/``
Nova section is available at: ``http://localhost/nova``
