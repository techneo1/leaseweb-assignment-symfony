# Dockerized Symfony API backend
A simple API backend using PHP symfony. 

## Approach
##### Current implementation
Due to brevity, provided excel was converted to JSON using an online tool [beautifytools.com](http://beautifytools.com/excel-to-json-converter.php). And, the same JSON is used for manipulation, just to quick start.

##### Improvements
The ideal way would be to provide a screen to upload the excel file and extract the file content to PHP array for manipulation using popular PHP libraries like [PHPOffice/PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet).

## Tools used
* Ubuntu 18.04
* PHP 7.4
* Symfony 4.4
* Nginx 1.19.3 
* Excel to JSON convertor from [beautifytools.com](http://beautifytools.com/excel-to-json-converter.php)
* Docker
* Docker-compose

## Pre-requisites
* docker 
* docker-compose

## Demo
http://ec2-13-233-101-90.ap-south-1.compute.amazonaws.com/api/servers

## Getting started

After cloning the repo, run the following command from the project root folder

##### Build and run app in development mode
```
docker-compose up
```
##### Build and run app in production mode
```
docker-compose -f docker-compose.yaml -f docker-compose-prod.yaml up -d
```

##### Stop the app 
```
docker-compose down
```

## APIs

##### Get all the servers
[http://localhost/api/servers](http://localhost/api/servers)

##### Get filtered servers based upon user selection
[http://localhost/api/servers?ram=16&hdd=SATA2&location=San%20FranciscoSFO-12&storageMin=0&storageMax=7200](http://localhost/api/servers?ram=16&hdd=SATA2&location=San%20FranciscoSFO-12&storageMin=0&storageMax=7200)


## Running commands in docker
##### Starting a docker terminal
```
sudo docker exec -it leaseweb-assignment-symfony_app_1 /bin/sh
```
##### Running tests
```
./setup-phpunit.sh  # Run this for the first time

vendor/bin/simple-phpunit tests
```

##### Running static code analysis
```
vendor/bin/phpstan analyse src --level 5
```
Note: level 5 is good enough for Symfony 4.4. However, set it to "MAX" for Symfony 5, which implements typed props feature of PHP 7.4.
