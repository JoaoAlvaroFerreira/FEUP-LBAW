# Lbaw2024

### Meetcamp

An event manager for social gatherings.

### Docker commands

As a group, we were unable to run the DockerHub image using the DRM database, and instead developed the project locally with a local database. To do so, assuming all the required software is already installed (PostgreSQL, Composer, PHP, etc.), we used the following commands:
`composer install`
`docker-compose up`
`php artisan db:seed`
`php artisan migrate:fresh`
`php artisan serve`

However, it should also be possible to run the project with the DRM database by using the following command:
`docker run -it -p 8000:80 -e DB_DATABASE="lbaw2024" -e DB_USERNAME="lbaw2024" -e DB_PASSWORD="FG416885" lbaw2024/lbaw2024`

### URL

The product can be accessed by running the source code locally, as mentioned previously, or by following the following URL while connected to FEUP's network: http://lbaw2024.lbaw-prod.fe.up.pt  

Some features that work perfectly in the local version somehow get a server error while on the FEUP production server. These include deleting events, buying tickets for events via PayPal and some of the formatting.

### Credentials

#### Administration Credentials

| Username | Password |
| -------- | -------- |
| adminuser@meetcamp.com| adminuser |

#### User Credentials

| Type          | Username  | Password |
| ------------- | --------- | -------- |
| basic account | ana@coutinho.com   | asasas |

### Group 24

* João Álvaro Cardoso Soares Ferreira, up201605592@fe.up.pt
* José Diogo da Cunha Moreira Trindade Martins, up201504761@fe.up.pt
* Mariana Monteiro e Neto, up201606791@fe.up.pt
