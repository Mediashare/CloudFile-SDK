<?php
namespace Mediashare\CloudFile;
use Mediashare\CloudFile\File;
use Mediashare\CloudFile\Utils;
Class Volume {
    public $utils;
    public function __construct(Utils $utils) {
        $this->utils = $utils;
        $this->file = new File($utils);
    }

    /**
     * Get volume informations
     *
     * @return array
     */
    public function info(): array {
        $url = "/volume";
        $response = $this->utils->request($url, []);
        return $response;
    }

    /**
     * Create new volume
     *
     * @param string $name
     * @param string $email
     * @param integer $size this variable represent volume size in Gb
     * @param string|null $cloudfile_password this variable is used for securisation of cloudfile server.
     * @return array
     */
    public function create(string $name, string $email, int $size, ?string $cloudfile_password = null): array {
        $url = "/volume/new";
        $response = $this->utils->request($url, [
            'name' => $name,
            'email' => $email,
            'size' => $size,
            'cloudfile_password' => $cloudfile_password
        ]);
        return $response;
    }

    /**
     * Edit volume informations
     *
     * @param array $queries [name, size, online, private]
     * @return array
     */
    public function edit(array $queries): array {
        $url = "/volume/edit";
        $response = $this->utils->request($url, $queries);
        return $response;
    }

    /**
     * Remove all files from volume
     *
     * @return array
     */
    public function clear(): array {
        $url = "/volume/clear";
        $response = $this->utils->request($url, []);
        return $response;
    }

    /**
     * Generate new ApiKey
     *
     * @return array
     */
    public function resetApiKey(): array {
        $url = "/volume/reset/apikey";
        $response = $this->utils->request($url, []);
        return $response;
    }

    /**
     * Delete volume & remove all files
     *
     * @return array
     */
    public function delete(): array {
        $url = "/volume/delete";
        $response = $this->utils->request($url, []);
        return $response;
    }
}