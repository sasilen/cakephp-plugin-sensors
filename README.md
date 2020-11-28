# Sensors plugin for CakePHP 4

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer config repositories.sensors git https://github.com/sasilen/cakephp-plugin-sensors.git
composer require sasilen/sensors
```
## Configuration

Load required modules with routes
```
./bin/cake plugin load Sasilen/Sensors
```
Migrate database schema
```
./bin/cake migrations migrate -p Sensors
```

## Triggers
If you want to update sensor_id automatically from the sensors list when sensor_value is inserted you can create these two trigger
```
CREATE TRIGGER sensor_values_sensor_id_updater
BEFORE UPDATE ON sensor_values
    FOR EACH ROW
          SET new.sensor_id = (select id from sensors where name=new.name);

CREATE TRIGGER sensor_values_sensor_id_inserter
BEFORE INSERT ON sensor_values
    FOR EACH ROW
          SET new.sensor_id = (select id from sensors where name=new.name);

FIX missing:
UPDATE sensor_values SET sensor_values.sensor_id = (SELECT sensors.id FROM sensors WHERE sensors.name = sensor_values.name ) WHERE sensor_values.sensor_id = '';
```
