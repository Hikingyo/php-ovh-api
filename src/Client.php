<?php

namespace Hikingyo\Ovh;

use Hikingyo\Ovh\EndPoint\Auth\Auth;
use Hikingyo\Ovh\EndPoint\Domain\Domain;
use Hikingyo\Ovh\Exception\InvalidParameterException;
use Hikingyo\Ovh\HttpClient\HttpClientFactory;
use Hikingyo\Ovh\HttpClient\Plugin\Authentication;
use Hikingyo\Ovh\HttpClient\Plugin\ExceptionThrower;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Psr\Http\Client\ClientInterface;

class Client
{
    /**
     * @var string
     */
    public const USER_AGENT = 'hikingyo-php-ovh-client/0.0.1';

    /**
     * @var array<string, string>
     */
    private const ENDPOINTS = [
        'ovh-eu'        => 'https://eu.api.ovh.com/1.0',
        'ovh-ca'        => 'https://ca.api.ovh.com/1.0',
        'ovh-us'        => 'https://api.us.ovhcloud.com/1.0',
        'kimsufi-eu'    => 'https://eu.api.kimsufi.com/1.0',
        'kimsufi-ca'    => 'https://ca.api.kimsufi.com/1.0',
        'soyoustart-eu' => 'https://eu.api.soyoustart.com/1.0',
        'soyoustart-ca' => 'https://ca.api.soyoustart.com/1.0',
        'runabove-ca'   => 'https://api.runabove.com/1.0',
    ];

    private HttpClientFactory $httpClientFactory;

    /**
     * @throws Exception\InvalidParameterException
     */
    public function __construct(HttpClientFactory $httpClientFactory = null, string $endPoint = null)
    {
        $this->httpClientFactory = $httpClientFactory ?? new HttpClientFactory();
        $this->httpClientFactory->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => self::USER_AGENT,
        ]));
        $this->httpClientFactory->addPlugin(new RedirectPlugin());
        if (null !== $endPoint) {
            $this->setEndPoint($endPoint);
        }

        $this->httpClientFactory->addPlugin(new ExceptionThrower());
    }

    /**
     * @throws InvalidParameterException
     */
    public function setEndPoint(string $apiEndpoint): void
    {
        if (preg_match('#^https?:\/\/..*#', $apiEndpoint)) {
            $endpoint = $apiEndpoint;
        } else {
            if (!array_key_exists($apiEndpoint, self::ENDPOINTS)) {
                throw new InvalidParameterException('Unknown provided endpoint');
            }

            $endpoint = self::ENDPOINTS[$apiEndpoint];
        }

        $uri = $this->httpClientFactory->getUriFactory()->createUri($endpoint);

        $this->httpClientFactory->removePlugin(BaseUriPlugin::class);
        $this->httpClientFactory->addPlugin(new BaseUriPlugin($uri));
    }

    /**
     * @throws Exception\InvalidParameterException
     */
    public static function createWithHttpClient(ClientInterface $httpClient, string $endPoint = null): Client
    {
        $httpClientFactory = new HttpClientFactory($httpClient);

        return new self($httpClientFactory, $endPoint);
    }

    public function getHttpClientFactory(): HttpClientFactory
    {
        return $this->httpClientFactory;
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->httpClientFactory->getHttpClient();
    }

    public function authenticate(string $applicationKey, string $applicationSecret, string $consumerKey): void
    {
        $this->httpClientFactory->removePlugin(Authentication::class);
        $deltaTime = $this->auth()->time() - time();
        $this->httpClientFactory->addPlugin(new Authentication($applicationKey, $applicationSecret, $consumerKey, $deltaTime));
    }

    // //////////////////////////////////////////////////////////////////////////////
    //                             End Points Level 1                              //
    // //////////////////////////////////////////////////////////////////////////////

    public function auth(): Auth
    {
        return new Auth($this);
    }

    public function domain(): Domain
    {
        return new Domain($this);
    }
}
