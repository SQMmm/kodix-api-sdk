<?php
/**
 * <pre>
 * Created by: KODIX 17.05.18 11:18
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api\DealerStorage;


use Kodix\Api\Contracts\ResponseInterface;
use Kodix\Api\Exceptions\MethodParametersException;

/**
 * Class Dealership
 * @package Kodix\Api\DealerStorage
 */
class Dealership extends Entity
{
    private $baseRoute = 'dealerships';

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

        if(isset($parameters['page'])){
            if(!is_array($parameters['page'])){
                throw new MethodParametersException('Parameter \'page\' must be array');
            }
            $getParams['page'] = $parameters['page'];
        }

        if(isset($parameters['filter'])){
            if(!is_array($parameters['filter'])){
                throw new MethodParametersException('Parameter \'filter\' must be array');
            }
            $getParams['filter'] = $parameters['filter'];
        }

        if(isset($parameters['select'])){
            if(!is_array($parameters['select'])){
                throw new MethodParametersException('Parameter \'select\' must be array');
            }
            $getParams['select'] = $parameters['select'];
        }

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

        return $this->_callMethod('get', $this->baseRoute, $getParams, [], $version);
    }

}