<?php

namespace Pamo\IPValidate;

/**
 * IP validator
 */
class IPValidate
{
    /**
     * @var string $ipV4 type.
     * @var string $ipV6 type.
     */
    private $ipV4 = FILTER_FLAG_IPV4;
    private $ipV6 = FILTER_FLAG_IPV6;



    /**
     * Valide an IP Address.
     *
     * @param string $ipAddress to validate.
     *
     * @return bool
     */
    public function isValid(string $ipAddress) : bool
    {
        return filter_var($ipAddress, FILTER_VALIDATE_IP);
    }



    /**
     * Get an IP Address type.
     *
     * @param string $ipAddress to get type for.
     *
     * @return string
     */
    public function getType(string $ipAddress) : string
    {
        $type = "";

        switch ($ipAddress) {
            case (filter_var($ipAddress, FILTER_VALIDATE_IP, $this->ipV4)):
                $type = "IPv4";
                break;
            case (filter_var($ipAddress, FILTER_VALIDATE_IP, $this->ipV6)):
                $type = "IPv6";
                break;
        }

        return $type;
    }



    /**
     * Get IP Address Domain name if exists and IP is valid.
     *
     * @param string $ipAddress IP Address to get the domain name for.
     *
     * @return string
     */
    public function getDomain(string $ipAddress) : string
    {
        $domain = gethostbyaddr($ipAddress);

        return ($domain != $ipAddress ? $domain : "unavailable");
    }
}
