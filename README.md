# Dockerized Symfony API backend
A simple API backend using PHP symfony. 

## Tools used
* Ubuntu 18.04
* PHP 7.4
* Symfony 4.4
* Nginx 1.19.3 
* Excel to JSON convertor (http://beautifytools.com/excel-to-json-converter.php)

## Pre-requisites
docker-compose

## Installation

After cloning the repo, run the following command from the project root folder

##### Building the docker images
```
docker-compose build
```

##### Bringing up the application
```
docker-compose up -d
```

Now visit http://localhost/ in the browser

##### Stopping the application 
```
docker-compose down
```
