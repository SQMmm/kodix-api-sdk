<?php
/**
 * <pre>
 * Created by: KODIX 18.05.18 13:16
 * Email:      support@kodix.ru
 * Web:        www.kodix.ru
 * Developer:  Maria Ivanova
 * </pre>
 */

namespace Kodix\Api\Contracts;


interface ResponseInterface
{
    public function getData();
    public function getMeta();
    public function getLinks();
    public function getErrors();
}