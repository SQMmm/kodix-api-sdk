<?php
/**
 * <pre>
 * Created by: KODIX 17.05.18 12:22
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api\DealerStorage;


use Kodix\Api\BaseEntity;
use Kodix\Api\Exceptions\MethodParametersException;

/**
 * Class Entity
 * @package Kodix\Api\DealerStorage
 */
abstract class Entity extends BaseEntity
{
    /**
     * Get base entity route (ex. dealerships or holdings)
     *
     * @return string
     */
    abstract protected function _getBaseRoute();

    /**
     * Get element by id
     *
     * @param $id - element id
     * @param array $select - fields for getting
     * @param null $version - method version
     * @return \Kodix\Api\Response
     * @throws MethodParametersException
     */
    public function get($id, array $select = [], $version = null)
    {
        if(strlen($id) === 0){
            throw new MethodParametersException('Does not set $id parameter');
        }

        $route = $this->_getBaseRoute(). '/' . $id;

        return $this->_callMethod('get', $route, [
            'select' => $select
        ], [], $version);
    }

    /**
     * Add new element
     *
     * @param array $fields - adding fields
     * @param null $version - method version
     * @return \Kodix\Api\Response
     */
    public function add(array $fields = [], $version = null)
    {
        return $this->_callMethod('post', $this->_getBaseRoute(), [], $fields, $version);
    }

    /**
     * Update element by id
     *
     * @param $id - element id
     * @param array $fields - updating fields
     * @param null $version - method version
     * @return \Kodix\Api\Response
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
     * Delete element by id
     *
     * @param $id - element id
     * @param null $version - method version
     * @return \Kodix\Api\Response
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

    protected function _getScope()
    {
        return 'dealer.storage';
    }

}