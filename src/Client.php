<?php

declare(strict_types=1);

namespace Rugaard\DMI;

use GeoJson\Exception\UnserializationException;
use GeoJson\GeoJson;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Uri;
use JsonException;
use Rugaard\DMI\Enums\Service;
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
 */
abstract class Client
{
    /**
     * Client version.
     *
     * @const string
     */
    public const VERSION = '2.0';

    /**
     * Underlying HTTP Client instance.
     *
     * @var GuzzleClient
     */
    protected GuzzleClient $client;

    /**
     * API key for DMI service.
     *
     * @var string
     */
    protected readonly string $apiKey;

    /**
     * Client constructor.
     *
     * @param string|null $apiKey
     * @throws DMIException
     */
    public function __construct(?string $apiKey)
    {
        if (empty($apiKey)) {
            throw new DMIException(message: 'Missing API key for DMI service [' . static::class .']', code: 500);
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
     * Build and send request to DMI API.
     *
     * @param string $method
     * @param string $url
     * @param array $query
     * @param array $headers
     * @return GeoJson|null
     * @throws ParsingFailedException|ServerException|ClientException|RequestException
     */
    protected function request(string $method, string $url, array $query = [], array $headers = []): ?GeoJson
    {
        // Build request for service.
        $request = $this->buildRequest(
            method: $method,
            url: $url,
            query: $query,
            headers: $headers
        );

        // Send request to service.
        $response = $this->sendRequest(request: $request);

        try {
            // Parse GeoJSON response.
            return !empty($response) ? GeoJson::jsonUnserialize(json: $response) : null;
        } catch (UnserializationException) {
            return null;
        }
    }

    /**
     * Generate request instance.
     *
     * @param string $method
     * @param string $url
     * @param array $query
     * @param array $headers
     * @return GuzzleRequest
     */
    protected function buildRequest(string $method, string $url, array $query = [], array $headers = []): GuzzleRequest
    {
        // Naturally sort query array.
        natsort($query);

        // Generate URI instance.
        $uri = Uri::withQueryValues(
            uri: new Uri(uri: "/v{$this->serviceVersion()}/{$this->service()->value}/collections/{$url}"),
            keyValueArray: $query
        );

        return new GuzzleRequest(
            method: $method,
            uri: $uri,
            headers: [
                ...$headers,
                'Accept-Encoding' => 'br;q=1.0, gzip;q=0.8, *;q=0.5',
                'X-Gravitee-Api-Key' => $this->apiKey,
            ],
        );
    }

    /**
     * Send request to DMI API.
     *
     * @param GuzzleRequest $request
     * @param array $options
     * @return array
     * @throws ParsingFailedException|ServerException|ClientException|RequestException
     */
    protected function sendRequest(GuzzleRequest $request, array $options = []): array
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
            return (array) json_decode(json: $body, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new ParsingFailedException(sprintf('Could not decode response. Reason: %s.', json_last_error_msg()), 400);
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
     * @return Service
     */
    abstract public function service(): Service;

    /**
     * Get service version.
     *
     * @return string
     */
    abstract public function serviceVersion(): string;
}
