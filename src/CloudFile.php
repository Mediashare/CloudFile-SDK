<?php
namespace Mediashare\CloudFile;

use Mediashare\CloudFile\Utils;
use Mediashare\CloudFile\Volume;

Class CloudFile {
    private $host = "https://api.cloudfile.tech";
    private $apikey;
    protected $utils;
    public function __construct(?string $host = null, string $apikey) {
        if ($host):$this->host = $host;endif;
        $this->apikey = $apikey;
        $this->utils = new Utils($this->host, $this->apikey);
    }
    public function getVolume() {
        $volume = new Volume($this->utils);
        return $volume;
    }
}