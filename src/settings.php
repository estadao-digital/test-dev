<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true, // define routes before handler middleware

		// Illuminate/Database settings
		'db' => [
			'driver' => 'sqlite',
            'database' => __DIR__ . '/../database/carrosaz.sqlite',
            'prefix' => ''
		],
    ],
];
