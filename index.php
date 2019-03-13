<?php

$dev = "/test-dev";

include_once 'classes/Api.php';

$api = new Api();

$api->dev = $dev;

$api->route('carros');