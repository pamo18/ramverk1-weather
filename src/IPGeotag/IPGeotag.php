<?php

namespace Pamo\IPGeotag;

/**
 * IP validator
 */
class IPGeotag
{
    /**
     * @var string $baseAddress for the API.
     * @var string $accessKey for authentication.
     * @var array $allData to store Geotag data.
     */
    private $baseAddress;
    private $accessKey;
    private $allData;



    /**
     * Geotag current IP
     *
     * @param string $baseAddress for the API.
     * @param string $accessKey for authentication.
     *
     */
    public function init(string $baseAddress = null, string $accessKey = null)
    {
        $api = require ANAX_INSTALL_PATH . "/config/api.php";
        $this->baseAddress = $baseAddress ?? $api["url"]["geoTag"];
        $this->accessKey = $accessKey ?? $api["key"]["geoTag"];
        $this->allData = [];
    }



    /**
     * Valide an IP Address.
     *
     * @param string $ipAddress is the IP Address to validate.
     *
     * @return object
     */
    public function getAllData(string $ipAddress = null) : object
    {
        $ipAddress = ($ipAddress ? $ipAddress : $this->clientIP);
        $data = file_get_contents(
            "$this->baseAddress/$ipAddress?access_key=$this->accessKey"
        );

        $dataJson = json_decode($data);

        return $dataJson;
    }



    /**
     * Valide an IP Address.
     *
     * @param string $ipAddress is the IP Address to validate.
     *
     * @return array
     */
    public function getAllDataSorted(string $ipAddress = null) : array
    {
        $ipAddress = ($ipAddress ? $ipAddress : $this->clientIP);
        $result = file_get_contents(
            "$this->baseAddress/$ipAddress?access_key=$this->accessKey"
        );

        $resultArray = json_decode($result, true);

        array_walk_recursive($resultArray, array('self', 'build'));

        return $this->allData;
    }



    /**
     * Build array with arrays, recursive
     *
     * @param string $value
     * @param string $key
     *
     */
    public function build($value, $key)
    {
        $key = str_replace("_", " ", $key);

        if ($value) {
            if (in_array($key, ["code", "name", "native"])) {
                $key = "Language " . $key;
            } else {
                $key = ucfirst($key);
            }
            $this->allData[$key] = $value;
        }
    }



    /**
     * Get client IP Address
     *
     * @return string
     */
    public function getClientIP($test = null) : string
    {
        if ($test) {
            return $test;
        } else {
            switch (true) {
                case (isset($_SERVER['HTTP_CLIENT_IP'])):
                    $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
                    break;
                case (isset($_SERVER['HTTP_X_FORWARDED_FOR'])):
                    $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    break;
                case (isset($_SERVER['HTTP_X_FORWARDED'])):
                    $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
                    break;
                case (isset($_SERVER['HTTP_FORWARDED_FOR'])):
                    $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
                    break;
                case (isset($_SERVER['HTTP_FORWARDED'])):
                    $ipAddress = $_SERVER['HTTP_FORWARDED'];
                    break;
                case (isset($_SERVER['REMOTE_ADDR'])):
                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                    break;
                default:
                    $ipAddress = 'unknown';
            }
        }

        return $ipAddress;
    }
}
