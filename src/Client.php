<?php
declare(strict_types=1);

namespace Rugaard\DMI;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use GuzzleHttp\Exception\GuzzleException;
use Rugaard\DMI\Exceptions\ClientException;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use Rugaard\DMI\Exceptions\ServerException;
use Rugaard\DMI\Exceptions\RequestException;
use JsonException;
use Throwable;

/**
 * Class Client.
 *
 * @abstract
 * @package Rugaard\DMI
 */
abstract class Client
{
    /**
     * Base URL of client.
     *
     * @var string
     */
    protected string $baseUrl = 'https://dmigw.govcloud.dk';

    /**
     * API key.
     *
     * @var string
     */
    protected string $apiKey;

    /**
     * Client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected ClientInterface $client;

    /**
     * Version of client.
     *
     * @var string
     */
    private string $version = '1.0';

    /**
     * DMI constructor.
     *
     * @param string $apiKey
     * @param \GuzzleHttp\ClientInterface|null $client
     */
    public function __construct(string $apiKey, ?ClientInterface $client = null)
    {
        $this->apiKey = $apiKey;

        if ($client !== null) {
            $this->setClient($client);
        } else {
            $this->defaultClient();
        }
    }

    /**
     * Send request to DMI.
     *
     * @param string $collection
     * @param string|null $itemId
     * @param array $parameters
     * @return array
     * @throws \Rugaard\DMI\Exceptions\ServerException
     * @throws \Rugaard\DMI\Exceptions\ClientException
     * @throws \Rugaard\DMI\Exceptions\RequestException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     * @throws \Rugaard\DMI\Exceptions\DMIException|
     */
    public function request(string $collection, ?string $itemId = null, array $parameters = []): array
    {
        try {
            // Send request.
            $response = $this->getClient()->request(
                'get',
                $this->baseUrl . '/' . $this->getServiceVersion() . '/' . $this->getServiceName() . '/collections/' . $collection . '/items' . (!empty($itemId) ? '/' . $itemId : ''),
                [
                    'query' => array_merge($parameters, [
                        'api-key' => $this->apiKey
                    ]),
                    'headers' => [
                        'Accept' => 'application/json',
                        'Accept-Encoding' => 'gzip',
                        'User-Agent' => 'Rugaard DMI/' . $this->version
                    ]
                ]
            );

            // If response is being returned with "204 No Content"
            // we'll just return an empty array.
            if ($response->getStatusCode() === 204) {
                return [];
            }

            // Extract body from response.
            $body = (string) $response->getBody();

            // JSON Decode response.
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (GuzzleServerException $e) {
            throw new ServerException($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
        } catch (GuzzleClientException $e) {
            throw new ClientException($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
        } catch (GuzzleException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        } catch (JsonException $e) {
            throw new ParsingFailedException('Could not JSON decode response. Reason: ' . $e->getMessage(), 400, $e);
        } catch (Throwable $e) {
            throw new DMIException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Set a default client.
     *
     * @return $this
     */
    protected function defaultClient(): self
    {
        return $this->setClient(
            new GuzzleClient
        );
    }

    /**
     * Set client instance.
     *
     * @param  \GuzzleHttp\ClientInterface $client
     * @return $this
     */
    public function setClient(ClientInterface $client) : self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get client instance.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient() : ClientInterface
    {
        return $this->client;
    }
}
