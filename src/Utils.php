<?php
namespace Mediashare\CloudFile;
use CloudflareBypass\CFCurlImpl;
use CloudflareBypass\Model\UAMOptions;
Class Utils {
    public function __construct(string $host, string $apikey = null) {
        $this->host = $host;
        $this->apikey = $apikey;
    }
    
    public function request(string $url, ?array $queries = []) {
        $url = rtrim($this->host, '/').$url;
        if ($this->apikey): $headers = ['apikey: '.$this->apikey];
        else: $headers = null; endif;
        
        $request = new Curl();
        if (empty($queries)):
            $response = $request->get($url, $headers);
        else:
            $response = $request->post($url, $queries, $headers);
        endif;
        $result = \json_decode($response, true);
        
        if ($result):
            return $result;
        else:
            return [
                'status' => 'error',
                'response' => $response
            ];
        endif;
    }
}

Class Curl {
    private $retry = 0;
    public function get(string $url, ?array $headers = null) {
        $result = $this->request($url, null, $headers);
        return $result;
    }
    public function post(string $url, ?array $arguments = null, ?array $headers = null) {
        $result = $this->request($url, $arguments, $headers);
        return $result;
    }
    public function download(string $url, string $destination, ?array $arguments = null, ?array $headers = null) {
        $result = $this->request($url, $arguments, $headers, true);
        $fp = \fopen($destination, 'w'); \fwrite($fp, $result); \fclose($fp);
        return $destination;
        
    }
    private function request(string $url, ?array $arguments = null, ?array $headers = null, ?bool $download = false) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        if ($download):
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        endif;
        curl_setopt($curl, CURLOPT_URL, $url);

        if ($arguments): // Post Request
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $arguments);
        endif;
        
        // Header
        $header = ["User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36"];
        if ($headers):
            $header = array_merge($headers, $header);
        endif;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        // CloudFlare ByPass
        $cfCurl = new CFCurlImpl();
        $cfOptions = new UAMOptions();
        $cfOptions->setVerbose(true);
        // $cfOptions->setDelay(5);

        try {
            $result = $cfCurl->exec($curl, $cfOptions);
        } catch (ErrorException $ex) {
            echo "Unknown error -> " . $ex->getMessage();
        }

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // Error(s)
        $error = curl_error($curl);
        $errno = curl_errno($curl);
        curl_close($curl);

        if (0 !== $errno) {
            $this->retry++;
            if ($this->retry > 5):
                // throw new \RuntimeException($error, $errno);
            else:
                $result = $this->request($url, $arguments, $headers);
            endif;
        }

        return $result;
    }
}