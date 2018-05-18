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
use Kodix\Api\Exceptions\AuthException;
use Kodix\Api\Exceptions\NotAllowedMethodException;
use Kodix\Api\Exceptions\TokenException;

interface ApiInterface
{
    /**
     * @return mixed
     */
    public function getAccessLogin();

    /**
     * @param string $login
     * @return mixed
     */
    public function setAccessLogin($login);

    /**
     * @return mixed
     */
    public function getAccessPassword();

    /**
     * @param string $password
     * @return mixed
     */
    public function setAccessPassword($password);

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
     * @return string
     * @throws AuthException
     */
    public function auth();

    /**
     * @param string $scope - name of scope (ex. dealer.storage)
     * @param string $route - route of scope (ex. dealerships)
     * @param string $method - http method (ex. get)
     * @param array $getParameters
     * @param array $postParameters
     * @param null $version
     * @throws NotAllowedMethodException
     * @throws TokenException
     * @return ResponseInterface
     */
    public function call($scope, $route, $method, array $getParameters = [], array $postParameters = [], $version = null);

}