<?php

namespace Pamo\Weather;

use Pamo\MultiCurl\MultiCurl;

/**
 * IP validator
 */
class Weather
{
    /**
     * @var array $data to store weather data.
     * @var object $multiCurl tool.
     * @var array $api all available API's.
     * @var string $baseAddress for the API.
     * @var string $apiKey for authentication.
     * @var array $config for API url.
     */
    private $data;
    private $multiCurl;
    private $api;
    private $baseAddress;
    private $apiKey;
    private $forecastConfig;
    private $historyConfig;



    /**
     * Geotag current IP
     *
     * @param string $baseAddress for the API.
     * @param string $apiKey for authentication.
     *
     */
    public function init(string $baseAddress = null, string $apiKey = null)
    {
        $this->data = [];
        $this->multiCurl = new MultiCurl();
        $this->api = require ANAX_INSTALL_PATH . "/config/api.php";
        $this->baseAddress = $baseAddress ?? $this->api["url"]["weather"];
        $this->apiKey = $apiKey ?? $this->api["key"]["weather"];
        $this->forecastConfig = [
            "exclude" => "exclude=[currently,minutely,hourly,alerts,flags]",
            "units" => "&units=si"
        ];
        $this->historyConfig = [
            "exclude" => "exclude=[minutely,hourly,currently,flags]",
            "units" => "&units=si"
        ];
    }



    /**
     * Get data with curl.
     *
     * @param string $lattitude for location.
     * @param string $longitude for location.
     * @param string $type for weather forecast or weather history.
     *
     * @return array
     */
    public function getAllData(string $lattitude = null, string $longitude = null, string $type = "forecast") : array
    {
        $forecastConfig = implode("", $this->forecastConfig);
        $historyConfig = implode("", $this->historyConfig);
        $apiRequest = [];
        $day = time();

        if ($type === "forecast") {
            $apiRequest[] = "$this->baseAddress/forecast/$this->apiKey/$lattitude,$longitude?$forecastConfig";
        } else if ($type === "history") {
            for ($i = 1; $i <= 30; $i++) {
                $day -= 86400;
                $apiRequest[] = "$this->baseAddress/forecast/$this->apiKey/$lattitude,$longitude,$day?$historyConfig";
            }
        }

        if ($apiRequest) {
            $data = $this->multiCurl->get($apiRequest);

            if ($data) {
                foreach ($data as $row) {
                    if (array_key_exists("daily", $row) && array_key_exists("data", $row["daily"])) {
                        array_walk($row["daily"]["data"], array('self', 'build'));
                    }
                }
            }
        }

        return $this->data;
    }



    /**
     * Build weather array.
     *
     * @param string $value
     * @param string $key
     *
     */
    public function build($data)
    {
        if (array_key_exists("time", $data)) {
            $time = date('d M Y', $data["time"]);
            $data["time"] = $time;
            $this->data[$time] = $data;
        }
    }
}
