<?php

namespace Pamo\IPValidate;

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
 */
class IPValidateController implements ContainerInjectableInterface
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
        $this->base = "ip-validate";
        $this->title = "Validate IP Address";
        $this->ipValidator = $this->di->get("ip-validate");
    }



    /**
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $response = $this->di->get("response");

        if ($request->getPost("ip-address") || $request->getGet("test-ip")) {
            $ipAddress = $request->getPost("ip-address", $request->getGet("test-ip"));
            $validIP = $this->ipValidator->isValid($ipAddress);
            $type = $validIP ? $this->ipValidator->getType($ipAddress) : null;
            $domain = $validIP ? $this->ipValidator->getDomain($ipAddress) : null;

            return $response->redirect("$this->base?ip-address=$ipAddress&type=$type&domain=$domain");
        }

        $ipAddress = $request->getGet("ip-address", "");
        $validIP = $this->ipValidator->isValid($ipAddress);
        $data = [
            "title" => $this->title,
            "ipAddress" => $ipAddress,
            "status" => $validIP ? "valid" : "invalid",
            "type" => $validIP ? $request->getGet("type") : "unavailable",
            "domain" => $validIP ? $request->getGet("domain") : "unavailable"
        ];

        $page->add($this->base . "/index", $data);

        return $page->render();
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
