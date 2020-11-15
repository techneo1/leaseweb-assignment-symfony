# Dockerized Symfony API backend
A simple API backend using PHP symfony. 

## Current approach
Due to brevity, provided excel was converted to JSON using an online tool http://beautifytools.com. And, the same JSON is used for manipulation.

However, the ideal way would be reading the excel file and extracting it to PHP array for manipulation using popular PHP libraries like https://github.com/PHPOffice/PhpSpreadsheet.


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

## Tests

##### Running functional tests
```
php bin/phpunit tests/ApplicationAvailabilityFunctionalTest.php
```

## Static code analysis
```
vendor/bin/phpstan analyse src --level 5
```
Note: level 5 is good enough for PHP 7.4. However, set it to MAX, when using PHP 8.
