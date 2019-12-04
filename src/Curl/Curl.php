<?php

namespace Aiur\Curl;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * To ease rendering a page consisting of several views.
 */
class Curl implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $urlipstack;
    private $urldarksky;
    private $apikeyIpstack;
    private $apikeyDarksky;



    public function __construct()
    {
        //Set url
        $this->urlipstack = "http://api.ipstack.com";
        $this->urldarksky = "https://api.darksky.net/forecast";
        //Get apikey
        $apikeys  = require __DIR__ . "/../../config/apikeys.php";
        //Set apikey
        $this->apikeyIpstack = $apikeys["ipstack"];
        $this->apikeyDarksky = $apikeys["darksky"];
    }


    /**
     * Set the view to be used for the layout.
     *
     * @param array $view configuration to create up the view.
     *
     * @return $this
     */
    public function getCurlAdress($ip, $valid)
    {
        $checkValid = explode(' ', $valid);

        if ($checkValid[2] == "not") {
            $result = array_map('floatval', explode(',', $ip));
            if (count($result) == 2) {
                if ($result[0] <= 90 && $result[1] <= 90 && $result[0] >= -90 && $result[1] >= -90) {
                    return $result;
                } else {
                    $result = array("testing", "testing123");
                    return $result;
                }
            } else {
                $result = array("testing", "testing123");
                return $result;
            }
        } else {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "{$this->urlipstack}/{$ip}?access_key={$this->apikeyIpstack}");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            $decoded_result = json_decode($result);
            return $decoded_result;
        }
    }


    /**
     * Set the view to be used for the layout.
     *
     * @param array $view configuration to create up the view.
     *
     * @return $this
     */
    public function getCurlTemp($lat, $long, $date)
    {
        if ($date == "plusweek") {
            $url = "$this->urldarksky/{$this->apikeyDarksky}";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "$url/{$lat},{$long}");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            $decoded_result = json_decode($result);

            // Changes UNIX-date to "normal"
            foreach ($decoded_result->daily->data as $key => $value) {
                $timestamp=$decoded_result->daily->data[$key]->time;
                $decoded_result->daily->data[$key]->time = gmdate("Y-m-d", $timestamp);
            }

            return $decoded_result;
        } elseif ($date == "minusmonth") {
            $month = [
                strtotime('-1 day'), strtotime('-2 day'), strtotime('-3 day'),
                strtotime('-4 day'), strtotime('-5 day'), strtotime('-6 day'),
                strtotime('-7 day'), strtotime('-8 day'), strtotime('-9 day'),
                strtotime('-10 day'), strtotime('-11 day'), strtotime('-12 day'),
                strtotime('-13 day'), strtotime('-14 day'), strtotime('-15 day'),
                strtotime('-16 day'), strtotime('-17 day'), strtotime('-18 day'),
                strtotime('-19 day'), strtotime('-20 day'), strtotime('-21 day'),
                strtotime('-22 day'), strtotime('-23 day'), strtotime('-24 day'),
                strtotime('-25 day'), strtotime('-26 day'), strtotime('-27 day'),
                strtotime('-28 day'), strtotime('-29 day'), strtotime('-30 day')
            ];

            $url = "$this->urldarksky/{$this->apikeyDarksky}/{$lat},{$long}";
            $options = [
                CURLOPT_RETURNTRANSFER => true,
            ];

            //Add all curl handles and remember theme
            //Init the multi curl dba_handler
            $mh = curl_multi_init();
            $chAll = [];
            foreach ($month as $id) {
                $ch = curl_init("$url,$id");
                curl_setopt_array($ch, $options);
                curl_multi_add_handle($mh, $ch);
                $chAll[] = $ch;
            }

            //execute all queries simult
            // and cont. when compl.
            $running = null;
            do {
                curl_multi_exec($mh, $running);
            } while ($running);

            //close the handles
            foreach ($chAll as $ch) {
                curl_multi_remove_handle($mh, $ch);
            }
            curl_multi_close($mh);

            //done with result
            $response = [];
            foreach ($chAll as $ch) {
                $data = curl_multi_getcontent($ch);
                $response[] = json_decode($data, true);
            }
            foreach ($response as $key => $value) {
                $response[$key]["currently"]["time"] = gmdate("Y-m-d", $response[$key]["currently"]["time"]);
            }

            return $response;
        } else {
            $url = "$this->urldarksky/{$this->apikeyDarksky}";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "$url/{$lat},{$long}");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            $decoded_result = json_decode($result);
            return $decoded_result;
        }
    }
}
