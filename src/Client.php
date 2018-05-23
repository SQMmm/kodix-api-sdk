<?php
/**
 * <pre>
 * Created by: KODIX 16.05.18 13:02
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api;


use Kodix\Api\Contracts\ApiInterface;
use Kodix\Api\Exceptions\AuthException;
use Kodix\Api\Exceptions\NotAllowedMethodException;
use Kodix\Api\Exceptions\TokenException;
use GuzzleHttp\Client as Guzzle;
use Kodix\Api\Exceptions\TokenExpiredException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Client
 * @package Kodix\Api
 */
class Client implements ApiInterface
{
    /**
     * @var string|null - access token
     */
    private $accessToken = null;

    /**
     * @var string - auth login
     */
    private $login;

    /**
     * @var string - auth password
     */
    protected $password;

    /**
     * @var string - default api version
     */
    private $version = '1.0';

    /**
     * @var callable - Callback function with will be run if token has expired. It must return bool
     */
    private $onTokenExpired;

    /**
     * @var array - available http methods
     */
    private $availableHttpMethods = ['GET', 'POST', 'PATCH', 'DELETE'];

    const API_DOMAIN = 'http://api.dbay.kodixauto.ru';

    public function getAccessLogin()
    {
        return $this->login;
    }

    public function setAccessLogin($login)
    {
        $this->login = $login;
    }

    public function getAccessPassword()
    {
        return $this->password;
    }

    public function setAccessPassword($password)
    {
        $this->password = $password;
    }

    public function getAccessToken()
    {

        return $this->accessToken;
    }

    public function setAccessToken($token)
    {
        if(strlen($token) < 4){
            throw new Exception('The access token is to small');
        }

        if(!is_string($token)){
            throw new Exception('The access token is not string');
        }

        $this->accessToken = $token;

    }

    public function setApiVersion($version)
    {
        $this->version = $version;
    }

    public function setOnTokenExpiredFunction(callable $function)
    {
        $this->onTokenExpired = $function;
    }

    public function getApiVersion()
    {
        return $this->version;
    }

    public function auth()
    {
        $login = $this->getAccessLogin();
        $password = $this->getAccessPassword();

        if(strlen($login) === 0 || strlen($password) === 0){
            throw new AuthException('Login or password is not set');
        }

        $client = new Guzzle();

        $response = $client->request('POST', self::API_DOMAIN . '/auth', [
            'form_params' => [
                'login' => $login,
                'password' => $password
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $token = $data['data']['access_token'];

        $this->setAccessToken($token);

        return $token;
    }

    public function call($scope, $route, $httpMethod, array $getParameters = [], array $postParameters = [], $version = null)
    {
        if(is_null($version)){
            $version = $this->getApiVersion();
        }

        $httpMethod = strtoupper($httpMethod);

        if(!in_array($httpMethod, $this->availableHttpMethods)){
            throw new NotAllowedMethodException('Http method is not allowed');
        }

        if(is_null($this->accessToken)){
            throw new TokenException('Please set access token');
        }

        $url = self::API_DOMAIN . '/api/' . $scope . '/' . $version . '/' . $route;

        $requestOptions = [
            'headers' => [
                'Authorization' => 'bearer ' . $this->accessToken
            ]
        ];

        if(count($postParameters) > 0){
            $requestOptions['form_params'] = $postParameters;
        }

        if(count($getParameters) > 0){
            $requestOptions['query'] = $getParameters;
        }

        try{
            $response = $this->_call($httpMethod, $url, $requestOptions);
        }catch (TokenExpiredException $e){
            if(!is_callable($this->onTokenExpired)){
                throw $e;
            }

            $result = call_user_func($this->onTokenExpired, $this);

            if($result === false){
                throw $e;
            }
            $response = $this->_call($httpMethod, $url, $requestOptions);
        }catch(RequestException $e){

            $response = $e->getResponse();
        }

        $body = json_decode($response->getBody()->getContents(),true);

        return new Response($response->getStatusCode(), $body);
    }

    /**
     * @param string $httpMethod -
     * @param string $url
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws TokenExpiredException
     * @throws Exception
     */
    private function _call($httpMethod, $url, array $options = [])
    {
        $client = new Guzzle();
        $response = $client->request($httpMethod, $url, $options);

        //check if token has expired
        if($response->getStatusCode() === 461){
            throw new TokenExpiredException('Token has expired');
        }

        //check if method forbidden
        if($response->getStatusCode() === 403){
            throw new Exception('Method forbidden');
        }

        return $response;
    }


}