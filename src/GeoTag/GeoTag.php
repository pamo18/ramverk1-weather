<?php

namespace Pamo\GeoTag;

use Pamo\MultiCurl\MultiCurl;

/**
 * GeoTag
 */
class GeoTag
{
    /**
     * @var object $multiCurl tool.
     * @var string $baseAddress for the API.
     * @var string $apiKey for authentication.
     * @var array $allData to store Geotag data.
     */
    private $multiCurl;
    private $baseAddress;
    private $apiKey;
    private $allData;



    /**
     * Geotag current place
     *
     * @param string $baseAddress for the API.
     * @param string $apiKey for authentication.
     *
     */
    public function init()
    {
        $this->multiCurl = new MultiCurl();
        $filename = ANAX_INSTALL_PATH . "/config/api.php";
        $api =  file_exists($filename) ? require $filename : null;
        $this->baseAddress = $api ? $api["url"]["opencagedata"] : getenv("API_URL_OPENCAGEDATA");
        $this->apiKey = $api ? $api["key"]["opencagedata"] : getenv("API_KEY_OPENCAGEDATA");
        $this->allData = [];
    }



    /**
     * Valide an IP Address.
     *
     * @param string $ipAddress is the IP Address to validate.
     *
     * @return object
     */
    public function getAllData(string $search = null) : array
    {
        $url = ["$this->baseAddress/geocode/v1/json?q=" . urlencode($search) . "&key=$this->apiKey"];
        $data = $this->multiCurl->get($url);
        $data = count($data) > 0 ? $data[0] : null;

        if ($data && array_key_exists("results", $data) && !empty($data["results"][0])) {
            $this->allData = $data["results"][0];
        }

        return $this->allData;
    }
}
