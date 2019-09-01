<?php
require_once 'vendor/autoload.php';

use Dflydev\DotAccessData\Data;

$data = new Data(json_decode(file_get_contents($argv[1]), true));
echo $data->get($argv[2]) . PHP_EOL;
