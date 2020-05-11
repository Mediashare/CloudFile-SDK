<?php
require "vendor/autoload.php";
$cloudfile = new \Mediashare\CloudFile\CloudFile(
    $host = "https://api.cloudfile.tech", 
    $apikey = "GwCSqOB8bcajlXoWYnQxK4NMiDdv6eR7"
);
$volume = $cloudfile->getVolume();
$information = $volume->info();
$files = $volume->file->list();
var_dump($files);
