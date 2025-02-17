<?php

require __DIR__ . '/../vendor/autoload.php';

use OpenApi\Generator;

header('Content-Type: application/json');
echo json_encode(Generator::scan([__DIR__ . '/../src']));
