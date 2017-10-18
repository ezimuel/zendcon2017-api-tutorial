<?php
require __DIR__ . '/../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

$uuid4 = Uuid::uuid4();
printf("Uuid4: %s\n", $uuid4->toString());
