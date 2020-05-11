<?php
namespace Mediashare\CloudFile;
use Mediashare\CloudFile\Utils;
use Mediashare\CloudFile\Volume;
Class CloudFile {
    private $host = "https://api.cloudfile.tech";
    private $apikey;
    protected $utils;

    /**
     * Construct configuration
     *
     * @param string $host CloudFile host server
     * @param string $apikey Volume apikey
     */
    public function __construct(string $host = null, string $apikey) {
        if ($host):$this->host = $host;endif;
        $this->apikey = $apikey;
        $this->utils = new Utils($this->host, $this->apikey);
    }
    /**
     * Get volume
     *
     * @return Volume
     */
    public function getVolume(): Volume {
        $volume = new Volume($this->utils);
        return $volume;
    }
}