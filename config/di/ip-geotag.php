<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "ip-geotag" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Pamo\IPGeotag\IPGeotag();
                $obj->init();
                return $obj;
            }
        ],
    ],
];
