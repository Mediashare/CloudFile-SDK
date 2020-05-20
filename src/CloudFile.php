<?php
namespace Mediashare\CloudFile;
use Mediashare\CloudFile\Utils;
use Mediashare\CloudFile\Volume;
Class CloudFile {
    private $host = "https://api.cloudfile.tech";
    private $apikey = null;
    protected $utils;

    /**
     * Construct configuration
     *
     * @param string $host CloudFile host server
     * @param string $apikey Volume apikey
     */
    public function __construct(string $host = null, string $apikey = null) {
        if ($host):$this->host = $host;endif;
        $this->apikey = $apikey;
        $this->utils = new Utils($this->host, $this->apikey);
    }

    /**
     * Get volume interactions
     *
     * @param string|null $apikey if you want use specific volume
     * @return Volume
     */
    public function volume(string $apikey = null): Volume {
    	if ($apikey):
    		$utils = new Utils($this->host, $apikey);
        	$volume = new Volume($utils);
        else: $volume = new Volume($this->utils); endif;
        return $volume;
    }

    /**
     * Get file(s) interactions
     *
     * @param string|null $apikey if you want use specific volume
     * @return File
     */
    public function file(string $apikey = null): File {
    	return $this->volume($apikey)->file();
    }

    /**
     * Get server statistiques
     *
     * @return array
     */
    public function stats(): array {
        $url = "/";
        $response = $this->utils->request($url, null);
        return $response;
    }

    /**
     * Get all public volumes
     *
     * @return array
     */
    public function volumes(): array {
        $url = "/volumes";
        $response = $this->utils->request($url, null);
        return $response;
    }
}