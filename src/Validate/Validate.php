<?php

namespace Aiur\Validate;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * To ease rendering a page consisting of several views.
 */
class Validate implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $url;
    private $apikey;



    /**
     * Set the view to be used for the layout.
     *
     * @param array $view configuration to create up the view.
     *
     * @return $this
     */
    public function setUrl($urlen)
    {
        $this->url = $urlen;
    }


    /**
     * Set the view to be used for the layout.
     *
     * @param array $view configuration to create up the view.
     *
     * @return $this
     */
    public function setKey($keyz)
    {
        $this->apikey = $keyz;
    }


    /**
     * Set the view to be used for the layout.
     *
     * @param array $view configuration to create up the view.
     *
     * @return $this
     */
    public function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ipval = "IP is a valid IPv6 address";
            return $ipval;
        } elseif (filter_var($ip, FILTER_VALIDATE_IP)) {
            $ipval = "IP is a valid IPv4 address";
            return $ipval;
        } else {
            $ipval = "IP is not a valid IP address";
            return $ipval;
        }
    }



    /**
     * Set the view to be used for the layout.
     *
     * @param array $view configuration to create up the view.
     *
     * @return $this
     */
    public function getDomain($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $host = gethostbyaddr("$ip");
            return $host;
        } elseif (filter_var($ip, FILTER_VALIDATE_IP)) {
            $host = gethostbyaddr("$ip");
            return $host;
        } else {
            $host = "No valid domain";
            return $host;
        }
    }


    /**
     * Set the view to be used for the layout.
     *
     * @param array $view configuration to create up the view.
     *
     * @return $this
     */
    public function getCurl($ip)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "{$this->url}/{$ip}?access_key={$this->apikey}");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $decoded_result = json_decode($result);
        return $decoded_result;
    }
}
