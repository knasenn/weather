<?php

namespace Anax\IpVal;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

// use Anax\Commons\ContainerInjectableInterface;
// use Anax\Commons\ContainerInjectableTrait;

/**
 * Test the SampleController.
 */
class IpValControllerTest extends TestCase
{
    // use ContainerInjectableTrait;
    /**
     * Test the route "index".
     */
    public function testIndexActionGet()
    {
        //Start
        global $di;

        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //cache
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        //setup
        $test = new IpValController();
        $test->setDI($di);
        // $test->initialize();

        //Test
        $res = $test->indexActionGet();
        $this->assertIsObject($res);
    }



      /**
     * Test the route "index".
     */
    public function testIndexActionPost()
    {
        //Start
        global $di;

        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //cache
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        //setup
        $test = new IpValController();
        $test->setDI($di);

        //Test1
        // $_POST["ip"] = "8.8.8.8";
        $di->get("request")->setPost("ip", "2a03:2880:f21a:e5:face:b00c::4420");
        $res = $test->indexActionPost();
        $this->assertIsObject($res);

        //Test2
        // $_POST["ip"] = "8.8.8.8";
        $di->get("request")->setPost("ip", "8.8.8.8");
        $res = $test->indexActionPost();
        $this->assertIsObject($res);

        //Test3
        // $_POST["ip"] = "123";
        $di->get("request")->setPost("ip", "asd");
        $res = $test->indexActionPost();
        $this->assertIsObject($res);
    }
}
