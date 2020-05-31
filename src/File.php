<?php
namespace Mediashare\CloudFile;
Class File {
    private $utils;
    public function __construct(Utils $utils) {
        $this->utils = $utils;
    }

    /**
     * Upload new file in volume
     *
     * @param string $filePath
     * @param array|null $metadata
     * @return array
     */
    public function upload(string $filePath, ?array $metadata = null) {
        $url = "/upload";
        if ($metadata):$data = $metadata;endif;
        $data['file'] = curl_file_create($filePath);
        $response = $this->utils->request($url, $data);
        return $response;
    }

    /**
     * List all files from volume
     *
     * @param integer|null $page
     * @return array
     */
    public function list(?int $page = 1) {
        $url = "/list/".$page;
        $response = $this->utils->request($url, null);
        return $response;
    }

    /**
     * Search file(s) in volume
     *
     * @param string $query
     * @return array
     */
    public function search(string $query) {
        $url = "/search?".$query;
        $response = $this->utils->request($url, null);
        return $response;
    }

    /**
     * Get file informations
     *
     * @param string $id
     * @return array
     */
    public function info(string $id) {
        $url = "/info/".$id;
        $response = $this->utils->request($url, null);
        return $response;    
    }

    /**
     * Show file content
     *
     * @param string $id
     * @return string|array
     */
    public function show(string $id) {
        $url = "/show/".$id;
        $response = $this->utils->request($url, null);
        return $response;    
    }
    
    /**
     * Render file content
     *
     * @param string $id
     * @return string|array
     */
    public function render(string $id) {
        $url = "/render/".$id;
        $response = $this->utils->request($url, null);
        return $response;    
    }

    /**
     * Remove file from volume
     *
     * @param string $id
     * @return array
     */
    public function remove(string $id) {
        $url = "/remove/".$id;
        $response = $this->utils->request($url, null);
        return $response;    
    }
}