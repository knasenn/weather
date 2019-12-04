<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Style chooser.",
            "mount" => "ipweather",
            "handler" => "\Anax\ipweather\IpweatherController",
        ],
    ]
];
