REST API Instructions
=========================

## Weather API

The weather API allows you to get the weather for an IP address, place or with latitude and longitude coordinates separated by a comma.

The weather results are returned in a JSON file.

The Weather API is available at [/weather-json](weather-json)

Use the follwoing query parameters:

#### Required

**search**<br>
name, ip address or latitude,longitude coordinates

example: [/weather-json?search=8.8.8.8](weather-json?search=8.8.8.8)

#### Optional

**type**<br>
forecast or history

example: [/weather-json?search=8.8.8.8&type=history](weather-json?search=8.8.8.8&type=history)


## Geotag IP API

The Geotag IP API allows you to geotag an IP address, if valid.

The geotag results are returned in a JSON file.

The Geotag IP API is available at [/ip-geotag-json](ip-geotag-json)

Use the follwoing query parameters:

#### Required

**ip-address**<br>
IP address to geotag.

example: [/ip-geotag-json?ip-address=8.8.8.8](ip-geotag-json?ip-address=8.8.8.8)

## Validate IP API

The Validate IP API allows you to validate an IP address and get it's type and domain name.

The validation results are returned in a JSON file.

The Validate IP API is available at [/ip-validate-json](ip-validate-json)

Use the follwoing query parameters:

#### Required

**ip-address**<br>
IP address to validate.

example: [/ip-validate-json?ip-address=8.8.8.8](ip-validate-json?ip-address=8.8.8.8)
