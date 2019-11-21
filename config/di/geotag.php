<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "geotag" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Pamo\GeoTag\GeoTag();
                $obj->init();
                return $obj;
            }
        ],
    ],
];
