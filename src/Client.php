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
use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\ClientException;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use Rugaard\DMI\Exceptions\RequestException;
use Rugaard\DMI\Exceptions\ServerException;

use function json_decode;
use function json_last_error_msg;
use function natsort;
use function str_starts_with;

use const JSON_THROW_ON_ERROR;

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
     * Build and send request to DMI API.
     *
     * @param string $method
     * @param string $uri
     * @param array $query
     * @param array $headers
     * @return array|string|null
     * @throws ParsingFailedException|ServerException|ClientException|RequestException
     */
    protected function request(string $method, string $uri, array $query = [], array $headers = []): array|string|null
    {
        // Build request for service.
        $request = $this->buildRequest(
            method: $method,
            uri: $uri,
            query: $query,
            headers: $headers
        );

        // Send request to service.
        $response = $this->sendRequest(request: $request);

        return !empty($response) ? $response : null;
    }

    /**
     * Generate request instance.
     *
     * @param string $method
     * @param string $uri
     * @param array $query
     * @param array $headers
     * @return GuzzleRequest
     */
    protected function buildRequest(string $method, string $uri, array $query = [], array $headers = []): GuzzleRequest
    {
        // Naturally sort query array.
        natsort($query);

        // Generate URI instance.
        $uri = Uri::withQueryValues(
            uri: new Uri(uri: "/v{$this->serviceVersion()}/{$this->service()->value}/{$uri}"),
            keyValueArray: $query
        );

        return new GuzzleRequest(
            method: $method,
            uri: $uri,
            headers: $headers,
        );
    }

    /**
     * Send request to DMI API.
     *
     * @param GuzzleRequest $request
     * @param array $options
     * @return array|string
     * @throws ParsingFailedException|ServerException|ClientException|RequestException
     */
    protected function sendRequest(GuzzleRequest $request, array $options = []): array|string
    {
        try {
            // Create Guzzle client instance.
            $client = new GuzzleClient(config: [
                'base_uri' => 'https://opendataapi.dmi.dk',
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'br;q=1.0, gzip;q=0.8, *;q=0.5',
                    'User-Agent' => 'Rugaard DMI/' . self::VERSION . ' (https://github.com/rugaard/dmi) PHP/' . PHP_VERSION
                ]
            ]);

            // Send request.
            $response = $client->send(request: $request, options: $options);

            // If response is being returned with "204 No Content"
            // we'll just return an empty array.
            if ($response->getStatusCode() === 204) {
                return [];
            }

            // Get body from response.
            $body = (string) $response->getBody();

            return str_starts_with(haystack: $response->getHeaderLine(header: 'Content-Type'), needle: 'application/json')
                ? (array) json_decode(json: $body, associative: true, flags: JSON_THROW_ON_ERROR)
                : $body;
        } catch (JsonException $e) {
            throw new ParsingFailedException(message: 'Could not decode response. Reason: ' . json_last_error_msg(), code: 400, previous: $e);
        } catch (GuzzleServerException $e) {
            throw new ServerException(message: $e->getMessage(), request: $e->getRequest(), response: $e->getResponse(), previous: $e);
        } catch (GuzzleClientException $e) {
            throw new ClientException(message: $e->getMessage(), request: $e->getRequest(), response: $e->getResponse(), previous: $e);
        } catch (GuzzleException $e) {
            throw new RequestException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
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
