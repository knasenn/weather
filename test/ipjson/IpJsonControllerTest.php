<?php

namespace Anax\IpJson;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpJsonControllerTest extends TestCase
{
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
        $test = new IpJsonController();
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
        $test = new IpJsonController();
        $test->setDI($di);

        //Test1
        // $_POST["ip"] = "8.8.8.8";
        $di->get("request")->setPost("ip", "2a03:2880:f21a:e5:face:b00c::4420");
        $res = $test->indexActionPost();
        $this->assertIsArray($res);

        //Test2
        // $_POST["ip"] = "8.8.8.8";
        $di->get("request")->setPost("ip", "8.8.8.8");
        $res = $test->indexActionPost();
        $this->assertIsArray($res);

        //Test3
        // $_POST["ip"] = "123";
        $di->get("request")->setPost("ip", "asd");
        $res = $test->indexActionPost();
        $this->assertIsArray($res);
    }


    //
    // /**
    //  * Test the route "info".
    //  */
    // public function testInfoActionGet()
    // {
    //     $controller = new SampleController();
    //     $controller->initialize();
    //     $res = $controller->infoActionGet();
    //     $this->assertContains("db is active", $res);
    // }
    //
    //
    //
    // /**
    //  * Test the route "dump-di".
    //  */
    // public function testDumpDiActionGet()
    // {
    //     // Setup di
    //     $di = new DIFactoryConfig();
    //     $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
    //
    //     // Use a different cache dir for unit test
    //     $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
    //
    //     // Setup the controller
    //     $controller = new SampleController();
    //     $controller->setDI($di);
    //     $controller->initialize();
    //
    //     // Do the test and assert it
    //     $res = $controller->dumpDiActionGet();
    //     $this->assertContains("di contains", $res);
    //     $this->assertContains("configuration", $res);
    //     $this->assertContains("request", $res);
    //     $this->assertContains("response", $res);
    // }
}
