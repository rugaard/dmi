<?php
declare(strict_types=1);

namespace Rugaard\DMI\Tests;

use Rugaard\DMI\Client;
use Rugaard\DMI\Exceptions\ClientException;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use Rugaard\DMI\Exceptions\RequestException;
use Rugaard\DMI\Exceptions\ServerException;
use Rugaard\DMI\Tests\Support\MockedResponses\MockedResponses;

/**
 * Class DMITest.
 *
 * @package Rugaard\DMI\Tests\Endpoints
 */
class DMITest extends AbstractTestCase
{
    use MockedResponses;

    /**
     * Test invalid JSON response.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function testInvalidJson() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockInvalidJsonRequest());

        // Expect exception.
        $this->expectException(ParsingFailedException::class);
        $this->expectExceptionMessage('Could not JSON decode response. Reason: Syntax error.');

        // Request data.
        $this->invokeMethod($dmi, 'request', ['http://mocked.url']);
    }

    /**
     * Test "204 No Content" request.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function testNoContentRequest() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockNoContentRequest());

        // Request data.
        $data = $this->invokeMethod($dmi, 'request', ['http://mocked.url']);

        // Assertions.
        $this->assertIsArray($data);
        $this->assertCount(0, $data);
    }

    /**
     * Test client exception.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function testClientException() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockNotFoundRequest());

        // Expect exception.
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Client error: `GET http://mocked.url` resulted in a `404 Not Found` response');

        // Request data.
        $this->invokeMethod($dmi, 'request', ['http://mocked.url']);
    }

    /**
     * Test server exception.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function testServerException() : void
    {
        // Instantiate DMI with mocked client.
        $dmi = (new Client)->setClient($this->mockInternalErrorRequest());

        // Expect exception.
        $this->expectException(ServerException::class);
        $this->expectExceptionMessage('Server error: `GET http://mocked.url` resulted in a `500 Internal Server Error` response');

        // Request data.
        $this->invokeMethod($dmi, 'request', ['http://mocked.url']);
    }

    /**
     * Test request exception.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function testRequestException() : void
    {
        // Instantiate DMI.
        $dmi = new Client;

        // Expect exception.
        $this->expectException(RequestException::class);

        // Request data.
        $this->invokeMethod($dmi, 'request', ['http://mockedurl']);
    }
}
