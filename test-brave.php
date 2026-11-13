<?php

require __DIR__ . '/vendor/autoload.php';

use Spatie\Browsershot\Browsershot;

Browsershot::html('<html><body><h1>Hitek Marketing Studio</h1></body></html>')
    ->setChromePath('/usr/bin/brave-browser')
    ->noSandbox()
    ->windowSize(1080, 1080)
    ->save(__DIR__ . '/brave-test.png');

echo "PNG generated successfully.";
