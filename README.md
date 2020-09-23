
# continium-docker-php-mysql-compose-example

## What is Docker Compose
Compose is a tool for defining and running multi-container Docker applications.   
With Compose, you use a YAML file to configure your application’s services.   
Then, with a single command, you create and start all the services from your configuration.

Compose works in all environments: production, staging, development, testing, as well as CI workflows

## Requirements

```
Docker : https://docs.docker.com/engine/install/
Maven : https://maven.apache.org/ 
Java Jdk : https://www.oracle.com/tr/java/technologies/javase-downloads.html
```

## Docker install

*Ubuntu Bionic 18.04:*
```
$ Curl -fsSL https://get.docker.com -o get-docker.sh
$ sudo sh get-docker.sh
$ docker version

```
## Maven 3.6 install

*Ubuntu Bionic 18.04:*
```
$ sudo apt install maven
$ sudo sh get-docker.sh
$ mvn -version
```
## Java jdk 11 install

*Ubuntu Bionic 18.04:*
```
$ sudo add-apt-repository ppa:openjdk-r/ppa
$ sudo apt-get update
$ sudo apt install openjdk-11-jdk
```


### Docker File
```
 FROM php:7.2-apache

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN mkdir /app \
 && mkdir /app/continium-php-mysql-compose-demo \
 && mkdir /app/continium-php-mysql-compose-demo/www

COPY www/ /app/continium-php-mysql-compose-demo/www/

RUN cp -r /app/continium-php-mysql-compose-demo/www/* /var/www/html/.
```

### Docker Compose Yml
```
version: "3.2"
services:
  php:
    build: 
      context: .
    image: continium/firat-php-mysql-demo:1.0
    networks:
      - frontend
      - backend
    environment:
      - MYSQL_HOST=continium-mysql-app
      - MYSQL_USER=firatuser
      - MYSQL_PASSWORD=firatpass
      - MYSQL_DB=firat_db
    volumes:
      - ./www/:/var/www/html/
    ports:
      - "8880:80"
    container_name: continium-php-app
  mysql:
    image: mysql:5.7
    networks:
      - backend
    environment:
      - MYSQL_ROOT_PASSWORD=rootpassword
      - MYSQL_USER=firatuser
      - MYSQL_PASSWORD=firatpass 
      - MYSQL_DATABASE=firat_db
    volumes:
      - ./database/users.sql:/continium-entrypoint-initdb.d/users.sql
    container_name: continium-mysql-app
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:4.7
    depends_on:
      - mysql
    networks:
      - backend
    ports:
      - "8881:80"
    environment:
      - PMA_HOST=continium-mysql-app
      - PMA_PORT= 3306
    volumes:
      - /sessions
    container_name: continium-phpmyadmin-app
networks:
  frontend:
  backend:

```

### Start Multi-Container
```
 $ cd "Docker Project folder"
 $ Docker-compose up
```
### Start Test Project
```
 $ cd "Test Project folder"
 $ mvn test  

 if you get caracter problem error use this: 
 $ mvn -Dproject.build.sourceEncoding=UTF-8  clean test
```
