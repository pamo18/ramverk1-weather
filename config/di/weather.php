<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "weather" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Pamo\Weather\Weather();
                $obj->init();
                return $obj;
            }
        ],
    ],
];
