<?php
/**
 * <pre>
 * Created by: KODIX 28.06.18 16:07
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api\PartsStorage;

use Kodix\Api\Exceptions\MethodParametersException;

class Part extends Entity
{
    private $baseRoute = 'parts';

    /**
     * @return string
     */
    protected function _getBaseRoute()
    {
        return $this->baseRoute;
    }

    /**
     * @param array $parameters
     * @param null $version
     * @return \Kodix\Api\Contracts\ResponseInterface
     * @throws MethodParametersException
     */
    public function getList(array $parameters = [], $version = null)
    {
        $getParams = [];

        if(isset($parameters['page'])){
            if(!is_array($parameters['page'])){
                throw new MethodParametersException('Parameter \'page\' must be array');
            }
            $getParams['page'] = $parameters['page'];
        }


        if(isset($parameters['order'])){
            if(!is_array($parameters['order'])){
                throw new MethodParametersException('Parameter \'order\' must be array');
            }
            $getParams['order'] = $parameters['order'];
        }

        return $this->_callMethod('get', $this->_getBaseRoute(), $getParams, [], $version);
    }

    /**
     * @param $id
     * @param array $parameters
     * @param null $version
     * @return \Kodix\Api\Contracts\ResponseInterface
     * @throws MethodParametersException
     */
    public function get($id, array $parameters = [], $version = null)
    {
        if(strlen($id) === 0){
            throw new MethodParametersException('Does not set $id parameter');
        }
        $getParameters = [];

        $route = $this->_getBaseRoute(). '/' . $id;

        return $this->_callMethod('get', $route, $getParameters, [], $version);
    }

    /**
     * @param array $fields
     * @param null $version
     * @return \Kodix\Api\Contracts\ResponseInterface
     */
    public function add(array $fields = [], $version = null)
    {
        return $this->_callMethod('post', $this->_getBaseRoute(), [], $fields, $version);
    }

    /**
     * @param $id
     * @param array $fields
     * @param null $version
     * @return \Kodix\Api\Contracts\ResponseInterface
     * @throws MethodParametersException
     */
    public function update($id, array $fields = [], $version = null)
    {
        if(strlen($id) === 0){
            throw new MethodParametersException('Does not set $id parameter');
        }

        $route = $this->_getBaseRoute() . '/' . $id;

        return $this->_callMethod('patch', $route, [], $fields, $version);
    }

    /**
     * @param $id
     * @param null $version
     * @return \Kodix\Api\Contracts\ResponseInterface
     * @throws MethodParametersException
     */
    public function delete($id, $version = null)
    {
        if(strlen($id) === 0){
            throw new MethodParametersException('Does not set $id parameter');
        }

        $route = $this->_getBaseRoute() . '/' . $id;
        return $this->_callMethod('delete', $route, [], [], $version);
    }

}