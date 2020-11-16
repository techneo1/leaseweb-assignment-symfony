# Dockerized Symfony API backend
A simple API backend using PHP symfony. 

## Approach
##### Current implementation
Due to brevity, provided excel was converted to JSON using an online tool http://beautifytools.com. And, the same JSON is used for manipulation for the quick start.

##### Improvements
The ideal way would be to provide a screen to upload the provided excel file and extract the file content to PHP array for manipulation using popular PHP libraries like https://github.com/PHPOffice/PhpSpreadsheet.

## Tools used
* Ubuntu 18.04
* PHP 7.4
* Symfony 4.4
* Nginx 1.19.3 
* Excel to JSON convertor (http://beautifytools.com/excel-to-json-converter.php)
* Docker
* Docker-compose

## Pre-requisites
* docker 
* docker-compose

## Getting started

After cloning the repo, run the following command from the project root folder

##### Build and run app for development
```
docker-compose up
```
##### Build and run app for production
```
docker-compose -f docker-compose.yaml -f docker-compose-prod.yaml up -d
```

##### Stop the app 
```
docker-compose down
```

## APIs

##### Get all the servers
```
https://localhost:8000/api/servers
```

##### Get filtered servers based upon user selection
```
https://localhost:8000/api/servers?ram=16&hdd=SATA2&location=San%20FranciscoSFO-12&storageMin=0&storageMax=7200
```

## Running commands in docker
##### Starting a docker terminal
```
sudo docker exec -it leaseweb-assignment-symfony_app_1 /bin/sh
```
##### Running tests
```
vendor/bin/simple-phpunit tests
```

##### Running static code analysis
```
vendor/bin/phpstan analyse src --level 5
```
Note: level 5 is good enough for Symfony 4.4. However, set it to "MAX" for Symfony 5, which implements typed props feature of PHP 7.4.
