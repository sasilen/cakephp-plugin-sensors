# Sensors plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require sasilen/sensors
```
## Configuration

Load required modules with routes
```
./bin/cake plugin load -r Highcharts
./bin/cake plugin load -r Sensors
```
Migrate database schema
```
./bin/cake migrations migrate -p Sensors
```
