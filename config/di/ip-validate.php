<?php
/**
 * Configuration file for request service.
 */
return [
    // Services to add to the container.
    "services" => [
        "ip-validate" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Pamo\IPValidate\IPValidate();
                return $obj;
            }
        ],
    ],
];
