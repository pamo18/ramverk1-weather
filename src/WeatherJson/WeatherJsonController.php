<?php

namespace Pamo\WeatherJson;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class WeatherJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->base = "weather-json";
        $this->title = "Weather";
        $this->ipValidator = $this->di->get("ip-validate");
        $this->ipGeoTager = $this->di->get("ip-geotag");
        $this->geoTager = $this->di->get("geotag");
        $this->weather = $this->di->get("weather");
    }



    /**
     * @return object
     */
    public function indexAction() : array
    {
        $request = $this->di->get("request");

        switch (true) {
            case $request->getPost("search", null):
                $search = $request->getPost("search");
                break;
            case $request->getGet("search", null):
                $search = $request->getGet("search");
                break;
            case $request->getGet("test-search", null):
                $search = $request->getGet("test-search");
                break;
            case $this->ipGeoTager->getClientIP($request->getPost("test", null)) !== "unknown":
                $search = $this->ipGeoTager->getClientIP();
                break;
        }

        if (isset($search)) {
            $validIP = $search ? $this->ipValidator->isValid($search) : null;
            $geoTag = $validIP ? $this->ipGeoTager->getAllDataSorted($search) : $this->geoTager->getAllData($search);

            if ($geoTag && array_key_exists("Latitude", $geoTag) && array_key_exists("Longitude", $geoTag)) {
                $lattitude = $geoTag["Latitude"];
                $longitude = $geoTag["Longitude"];
            } else if ($geoTag && count(explode(",", $search)) === 2) {
                $location = explode(",", $search);
                $lattitude = $location[0];
                $longitude = $location[1];
            } else if (array_key_exists("geometry", $geoTag)) {
                $lattitude = $geoTag["geometry"]["lat"];
                $longitude = $geoTag["geometry"]["lng"];
            }

            if (isset($lattitude) && isset($longitude)) {
                if ($request->getPost("do-weather-history-json") || $request->getGet("type") === "history") {
                    $type = "history";
                } else {
                    $type = "forecast";
                }
                $weather = $this->weather->getAllData($lattitude, $longitude, $type);
                $map = "https://www.openstreetmap.org/?mlat=$lattitude&mlon=$longitude#map=14/$lattitude/$longitude";
            }

            if ($geoTag) {
                switch ($geoTag) {
                    case array_key_exists("Country code", $geoTag):
                        $countryCode = strtolower($geoTag["Country code"]);
                        $countryName = $geoTag["Country name"];
                        $regionName = $geoTag["Region name"];
                        $city = $geoTag["City"];
                        break;
                    case array_key_exists("components", $geoTag) && array_key_exists("country_code", $geoTag["components"]):
                        $countryCode = $geoTag["components"]["country_code"];
                        $countryName = $geoTag["components"]["country"];
                        if (array_key_exists("state", $geoTag["components"])) {
                            $regionName = $geoTag["components"]["state"];
                        }
                        if (array_key_exists("city", $geoTag["components"])) {
                            $city = $geoTag["components"]["city"];
                        } else if (array_key_exists("village", $geoTag["components"])) {
                            $city = $geoTag["components"]["village"];
                        }
                        break;
                }
            }

            $data = [
                "title" => $this->title,
                "search" => $search,
                "latitude" => isset($lattitude) ? $lattitude : null,
                "Longitude" => isset($longitude) ? $longitude : null,
                "countryCode" => isset($countryCode) ? $countryCode : null,
                "countryName" => isset($countryName) ? $countryName : null,
                "regionName" => isset($regionName) ? $regionName : null,
                "city" => isset($city) ? $city : null,
                "map" => isset($map) ? $map : null,
                "weather" => isset($weather) ? $weather : null
            ];
        } else {
            $data = [
                "title" => $this->title,
                "message" => "Post an ip address to the route /weather-json"
            ];
        }

        return [$data];
    }



    /**
     * This sample method dumps the content of $di.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpDiActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->di->getServices());
        return __METHOD__ . "<p>\$di contains: $services";
    }



    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        // Deal with the request and send an actual response, or not.
        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
        return;
    }
}
