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

/**
 * Class Holding
 * @package Kodix\Api\DealerStorage
 */
class Holding extends Entity
{
    private $baseRoute = 'holdings';

    protected function _getBaseRoute()
    {
        return $this->baseRoute;
    }

    /**
     * Get elements list
     *
     * @param array $filter - params for list filtering
     * @param array $select - selection fields
     * @param array $order - params for ordering list
     * @param null $version - method version
     * @return \Kodix\Api\Response
     */
    public function getList(array $filter = [], array $select = [], array $order = [], $version = null)
    {
        return $this->_callMethod('get', $this->_getBaseRoute(), [
            'filter' => $filter,
            'select' => $select,
            'order' => $order
        ], [], $version);
    }



}