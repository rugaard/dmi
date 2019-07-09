<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler as GuzzleMockHandler;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class AbstractTestCase
 *
 * @package Rugaard\DMI\Tests
 */
abstract class AbstractTestCase extends TestCase
{

    /**
     * Create a Guzzle Client with mocked responses.
     *
     * @param  array $responses
     * @return \GuzzleHttp\Client
     */
    protected function createMockedGuzzleClient(array $responses) : GuzzleClient
    {
        return new GuzzleClient([
            'handler' => GuzzleHandlerStack::create(
                new GuzzleMockHandler($responses)
            ),
        ]);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param  object &$object
     * @param  string $methodName
     * @param  array  $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Tear down test case after all tests are done.
     *
     * @return void
     */
    public function tearDown() : void
    {
        Mockery::close();
    }
}