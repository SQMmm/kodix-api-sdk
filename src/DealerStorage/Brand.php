<?php
/**
 * <pre>
 * Created by: KODIX 17.05.18 12:14
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api\DealerStorage;

use Kodix\Api\Contracts\ResponseInterface;
use Kodix\Api\Exceptions\MethodParametersException;

/**
 * Class Brand
 * @package Kodix\Api\DealerStorage
 */
class Brand extends Entity
{
    private $baseRoute = 'brands';

    protected function _getBaseRoute()
    {
        return $this->baseRoute;
    }

    /**
     * Get elements list
     *
     * @param array $parameters - query parameters
     * @param null $version - method version
     * @throws MethodParametersException
     * @return ResponseInterface
     */
    public function getList(array $parameters = [], $version = null)
    {
        $getParams = [];
        if(isset($parameters['with'])){
            if(!is_array($parameters['with'])){
                throw new MethodParametersException('Parameter \'with\' must be array');
            }
            $getParams['with'] = $parameters['with'];
        }
        if(isset($parameters['order'])){
            if(!is_array($parameters['order'])){
                throw new MethodParametersException('Parameter \'order\' must be array');
            }
            $getParams['order'] = $parameters['order'];
        }

        return $this->_callMethod('get', $this->_getBaseRoute(), $getParams, [], $version);
    }



}