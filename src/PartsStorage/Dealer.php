<?php
/**
 * <pre>
 * Created by: KODIX 28.06.18 16:23
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api\PartsStorage;

use Kodix\Api\Exceptions\MethodParametersException;

class Dealer extends Entity
{
    private $baseRoute = 'dealers';

    /**
     * @return string
     */
    protected function _getBaseRoute()
    {
        return $this->baseRoute;
    }

    public function getParts($dealerId, array $parameters = [], $version = null)
    {

        if(strlen($dealerId) === 0){
            throw new MethodParametersException('Does not set parameter $id of dealer');
        }
        $getParameters = [];

        $route = $this->_getBaseRoute(). '/' . $dealerId . '/parts';

        return $this->_callMethod('get', $route, $getParameters, [], $version);
    }


}