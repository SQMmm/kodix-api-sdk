<?php
/**
 * <pre>
 * Created by: KODIX 16.05.18 12:55
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api\Contracts;


use Kodix\Api\Exception;
use Kodix\Api\Exceptions\NotAllowedMethodException;
use Kodix\Api\Exceptions\TokenException;
use Kodix\Api\Response;

interface ApiInterface
{

    /**
     * Set access token
     *
     * @return mixed
     */
    public function getAccessToken();

    /**
     * Get access token
     *
     * @param string $token
     * @throws Exception
     * @return string
     */
    public function setAccessToken($token);

    /**
     * Set default api version for all methods
     *
     * @param string $version
     * @return mixed
     */
    public function setApiVersion($version);

    /**
     * Get default api version
     *
     * @return string
     */
    public function getApiVersion();

    /**
     * Set api token and return it
     *
     * @param string $login
     * @param string $password
     * @return string
     */
    public function auth($login, $password);

    /**
     * @param string $scope - name of scope (ex. dealer.storage)
     * @param string $route - route of scope (ex. dealerships)
     * @param string $method - http method (ex. get)
     * @param array $getParameters
     * @param array $postParameters
     * @param null $version
     * @throws NotAllowedMethodException
     * @throws TokenException
     * @return Response
     */
    public function call($scope, $route, $method, array $getParameters = [], array $postParameters = [], $version = null);

}