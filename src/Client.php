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
use Kodix\Api\Exceptions\Exception;
use Kodix\Api\Exceptions\NotAllowedMethodException;
use Kodix\Api\Exceptions\TokenException;
use GuzzleHttp\Client as Guzzle;

/**
 * Class Client
 * @package Kodix\Api
 */
class Client implements ApiInterface
{
    private $accessToken = null;

    private $version = '1.0';

    private $availableHttpMethods = ['GET', 'POST', 'PATCH', 'DELETE'];

    const API_DOMAIN = 'http://api.dbay.kodixauto.ru';

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

    public function getApiVersion()
    {
        return $this->version;
    }

    public function auth($login, $password)
    {
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

        $client = new Guzzle();
        $response = $client->request($httpMethod, $url, $requestOptions);
        $body = json_decode($response->getBody()->getContents(),true);

        //todo: проверка статуса на истечение токена, исключение

        return new Response($response->getStatusCode(), $body);
    }


}