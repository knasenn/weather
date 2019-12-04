<?php
/**
 * Configuration file to add as service in the Di container.
 */
return [

    // Services to add to the container.
    "services" => [
        "validator" => [
            "shared" => true,
            "callback" => function () {
                $validate = new \Aiur\Validate\Validate();
                //get api key from file
                $apikeys  = require __DIR__ . "/../apikeys.php";

                //Set apikey(create function in class)
                $validate->setKey($apikeys["ipstack"]);

                //Set url(create fuction in class)
                $validate->setUrl("http://api.ipstack.com");

                return $validate;
            }
        ],
    ],
];
