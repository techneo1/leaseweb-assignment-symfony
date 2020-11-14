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

##### Building and bringing up the application
```
docker-compose up
```

##### Stopping the application 
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
