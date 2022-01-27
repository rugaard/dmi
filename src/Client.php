<?php

declare(strict_types=1);

namespace Rugaard\DMI;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Uri;
use JsonException;
use Rugaard\DMI\Exceptions\ClientException;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use Rugaard\DMI\Exceptions\RequestException;
use Rugaard\DMI\Exceptions\ServerException;

use function json_decode;
use function json_last_error_msg;
use function natsort;
use function sprintf;

/**
 * Class Client.
 *
 * @abstract
 * @package Rugaard\DMI
 */
abstract class Client
{
    /**
     * Current version.
     *
     * @const string
     */
    public const VERSION = '2.0';

    /**
     * HTTP Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected GuzzleClient $client;

    /**
     * API key for DMI service.
     *
     * @var string
     */
    protected string $apiKey;

    /**
     * Client constructor.
     *
     * @param string|null $apiKey
     * @throws \Exception
     */
    public function __construct(?string $apiKey)
    {
        if (empty($apiKey)) {
            throw new DMIException('Missing API key for DMI service');
        }

        // Set API key.
        $this->apiKey = $apiKey;

        // Generate HTTP client.
        $this->client = new GuzzleClient([
            'base_uri' => 'https://dmigw.govcloud.dk',
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'User-Agent' => 'Rugaard DMI/' . self::VERSION . ' (https://github.com/rugaard/dmi) PHP/' . PHP_VERSION
            ]
        ]);
    }

    /**
     * Generate request instance.
     *
     * @param string $method
     * @param string $url
     * @param array $query
     * @param array $headers
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function buildRequest(string $method, string $url, array $query = [], array $headers = []): GuzzleRequest
    {
        // Add API key to query.
        $query['api-key'] = $this->apiKey;

        // Naturally sort query array.
        natsort($query);

        // Generate URI instance.
        $uri = Uri::withQueryValues(
            new Uri('/v' . $this->getServiceVersion() . '/' . $this->getServiceName() . '/collections/' . $url . '?api-key=' . $this->apiKey),
            $query
        );

        return new GuzzleRequest($method, $uri, $headers);
    }

    /**
     * Send request to DMI API.
     *
     * @param \GuzzleHttp\Psr7\Request $request
     * @param array $options
     * @return array
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    protected function request(GuzzleRequest $request, array $options = []): array
    {
        try {
            // Send request.
            $response = $this->client->send($request, $options);

            // If response is being returned with "204 No Content"
            // we'll just return an empty array.
            if ($response->getStatusCode() === 204) {
                return [];
            }

            // Extract body from response.
            $body = (string) $response->getBody();

            // JSON Decode response.
            return (array) json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new ParsingFailedException(sprintf('Could not JSON decode response. Reason: %s.', json_last_error_msg()), 400);
        } catch (GuzzleServerException $e) {
            throw new ServerException($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
        } catch (GuzzleClientException $e) {
            throw new ClientException($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
        } catch (GuzzleException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get name of service.
     *
     * @return string
     */
    abstract protected function getServiceName(): string;

    /**
     * Get service version.
     *
     * @return int|float
     */
    abstract protected function getServiceVersion(): int|float;
}
