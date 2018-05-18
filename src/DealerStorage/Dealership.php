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
     * @param array $pagination - params for list pagination, can contain keys: limit, offset
     * @param array $filter - params for list filtering
     * @param array $select - selection fields
     * @param array $with - references
     * @param array $order - params for ordering list
     * @param null $version - method version
     * @return ResponseInterface
     */
    public function getList(
        array $pagination = [],
        array $filter = [],
        array $select = [],
        array $with = [],
        array $order = [],
        $version = null)
    {
        return $this->_callMethod('get', $this->baseRoute, [
            'page' => $pagination,
            'filter' => $filter,
            'select' => $select,
            'with' => $with,
            'order' => $order
        ], [], $version);
    }

}