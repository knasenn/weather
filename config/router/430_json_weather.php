<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Style chooser.",
            "mount" => "jsonweather",
            "handler" => "\Anax\jsonweather\JsonweatherController",
        ],
    ]
];
