<?php
/**
 * <pre>
 * Created by: KODIX 17.05.18 11:13
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api;

use Kodix\Api\Contracts\ResponseInterface;

/**
 * Class BaseEntity
 * @package Kodix\Api
 */
abstract class BaseEntity
{
    /**
     * @var Client|null
     */
    protected $client = null;
    /**
     * @var string - scope name
     */
    private $scope;

    /**
     * @param $client Client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->scope = $this->_getScope();
    }

    /**
     * Get scope name
     *
     * @return string
     */
    abstract protected function _getScope();

    /**
     * @param string $httpMethod - http method (ex. get)
     * @param string $route - scope route (ex. dealerships)
     * @param array $getParameters
     * @param array $postParameters
     * @param null $version
     * @return ResponseInterface
     */
    protected function _callMethod($httpMethod, $route, array $getParameters = [], array $postParameters = [], $version = null)
    {
        return $this->client->call($this->scope, $route, $httpMethod, $getParameters, $postParameters, $version);
    }
}