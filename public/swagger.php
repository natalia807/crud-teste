<?php
require __DIR__ . '/../vendor/autoload.php';

use OpenApi\Generator;

// Geração da documentação
$openapi = Generator::scan([__DIR__ . '/../src']); 

header('Content-Type: application/json');
echo json_encode($openapi, JSON_PRETTY_PRINT);
