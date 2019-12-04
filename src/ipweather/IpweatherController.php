<?php

namespace Anax\Ipweather;

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
class IpweatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;




    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        // $adress = $_SERVER["REMOTE_ADDR"] ?? "";
        $adress = $_SERVER["HTTP_X_FORWARDED_FOR"] ?? "";

        $data = [
            "test" => "testing",
            "adress" => $adress,
        ];

        $page->add("ipweather/index", $data);

        return $page->render();
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexActionPost() : object
    {
        //gets pagestuff?
        $page = $this->di->get("page");
        //get ip
        $ip = $this->di->request->getPOST("ip");
        //get dateChecked
        $dateChecked = $this->di->request->getPOST("dateChecked");

        //Creates validate-class object
        $validate = $this->di->get("validator");
        //Validates ip
        $resValidateIp = $validate->validateIp($ip);
        //Gets hostname
        $resDomain = $validate->getDomain($ip);

        $curl = new \Aiur\Curl\Curl();
        //Gets curl adress
        $resCurlAdress = $curl->getCurlAdress($ip, $resValidateIp);


        if (is_array($resCurlAdress)) {
            if (is_float($resCurlAdress[0])) {
                if ($dateChecked == "plusweek") {
                    $resCurlTempWeek = $curl->getCurlTemp($resCurlAdress[0], $resCurlAdress[1], $dateChecked);
                } elseif ($dateChecked == "minusmonth") {
                    $resCurlTempMonth = $curl->getCurlTemp($resCurlAdress[0], $resCurlAdress[1], $dateChecked);
                }
            } elseif (is_string($resCurlAdress[0])) {
                $notValid = "Search was not valid!";
            }
        } else {
            if ($dateChecked == "plusweek") {
                $resCurlTempWeek = $curl->getCurlTemp($resCurlAdress->latitude, $resCurlAdress->longitude, $dateChecked);
            } elseif ($dateChecked == "minusmonth") {
                $resCurlTempMonth = $curl->getCurlTemp($resCurlAdress->latitude, $resCurlAdress->longitude, $dateChecked);
            }
        }
        $data = [
            "ipval" => $resValidateIp,
            "host" => $resDomain,
            "latitude" => $resCurlAdress->latitude ?? "",
            "longitude" => $resCurlAdress->longitude ?? "",
            "country_name" => $resCurlAdress->country_name ?? "",
            "region_name" => $resCurlAdress->region_name ?? "",
            "resTempWeek" => $resCurlTempWeek->daily->data ?? "",
            "resTempMonth" => $resCurlTempMonth ?? "",
            "notValid" => $notValid ?? ""
        ];

        $page->add("ipweather/weather", $data);


        return $page->render();
    }
}
