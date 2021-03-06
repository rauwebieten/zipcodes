![Travis build status](https://travis-ci.org/rauwebieten/zipcodes.svg?branch=master) 
[![Maintainability](https://api.codeclimate.com/v1/badges/49ee352019084279acdf/maintainability)](https://codeclimate.com/github/rauwebieten/zipcodes/maintainability) 
[![StyleCI](https://github.styleci.io/repos/347468951/shield?branch=master)](https://github.styleci.io/repos/347468951?branch=master) 

# Zipcodes

A collection of country zipcodes (postal codes).

Currently supported:

- BE
- DE
- ES
- FR
- IT
- LU
- NL

All data is fetched from geonames.org and converted to PHP array files.

## Installation

install library

    composer require rauwebieten/zipcodes

## Usage

Get all zipcodes for a country (use the country's ISO code as parameter)

    $data = \RauweBieten\ZipCodes\ZipCodes::getData('BE');

You'll receive an array of zipcode entries:

    [
        [
                "country" => "DE"
                "zipcode" => "01945"
                "place" => "Schwarzbach"
                "latitude" => "51.45"
                "longitude" => "13.9333"
        ],
        ...
    ]

Use this data to populate your database.    
Do not use directly :)

## Contribute

Need some country zipcodes not supported yet? 

1. Leave a github issue 
   
1. or do pull request and use the builder like this, and follow the CLI instructions

        "bin/zipcodes"
