# Cookly

A web application for sharing and discovering culinary recipes.

## About

This repository was created as a project for a university course. The purpose of this project is to demonstrate the skills and knowledge acquired during the course.

## Getting started

In order to start development, Docker and Docker Compose is needed. Running development environment can be done using the following command

```sh
docker compose up -d
```

Project uses Composer to enable namespaces in PHP, so it is needed to install Composer, which can be done by executing following command in running PHP container:

```sh
docker compose exec php sh -c XDEBUG_MODE=off composer install
```

That's it! Once the server is running, open your web browser and go to [http://localhost:8080](http://localhost:8080) to view the application.


## Authors

[@cocoshka](https://www.github.com/cocoshka)

## License

[MIT](https://choosealicense.com/licenses/mit/)
