<?php
/**
 * WeatherJson Controller
 */
return [
    "routes" => [
        [
            "info" => "Weather JSON Controller.",
            "mount" => "weather-json",
            "handler" => "\Pamo\WeatherJson\WeatherJsonController",
        ],
    ]
];
