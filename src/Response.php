<?php
/**
 * <pre>
 * Created by: KODIX 16.05.18 16:00
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api;


use Kodix\Api\Exceptions\ResponseExceptions;

/**
 * Class Response
 * @package Kodix\Api
 */
class Response
{
    private $data = null;
    private $meta = null;
    private $links = null;
    private $errors = null;
    private $code = null;

    /**
     * Response constructor.
     * @param integer $statusCode - code of http status
     * @param array $response - request answer
     */
    public function __construct($statusCode, array $response = [])
    {
        $this->_setCode($statusCode);
        $this->_setData((isset($response['data'])) ? $response['data'] : null);
        $this->_setMeta((isset($response['meta'])) ? $response['meta'] : null);
        $this->_setLinks((isset($response['links'])) ? $response['links'] : null);
        $this->_setErrors((isset($response['errors'])) ? $response['errors'] : null);

    }

    /**
     * Set http code
     *
     * @param integer $code
     * @return $this
     * @throws ResponseExceptions
     */
    private function _setCode($code)
    {
        if($code <= 100 || $code >= 600){
            throw new ResponseExceptions('Incorrect HTTP-code');
        }

        $this->code = $code;

        return $this;
    }

    /**
     * Get http code
     *
     * @return null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set data
     *
     * @param null $data - response data
     * @return $this
     */
    private function _setData($data = null)
    {
        if(!is_null($data)){
            $this->data = $data;
        }

        return $this;
    }

    /**
     * Get data
     *
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set meta
     *
     * @param null $meta
     * @return $this
     */
    private function _setMeta($meta = null)
    {
        if(!is_null($meta)){
            $this->meta = $meta;
        }

        return $this;
    }

    /**
     * Get meta
     *
     * @return null
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set links
     *
     * @param null $links
     * @return $this
     */
    private function _setLinks($links = null)
    {
        if(!is_null($links)){
            $this->links = $links;
        }

        return $this;
    }

    /**
     * Get links
     *
     * @return null
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set errors
     *
     * @param null $errors
     * @return $this
     */
    private function _setErrors($errors = null)
    {
        if(!is_null($errors)){
            $this->errors = $errors;
        }

        return $this;
    }

    /**
     * Get errors
     *
     * @return null
     */
    public function getErrors()
    {
        return $this->errors;
    }

}