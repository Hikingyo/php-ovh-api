<?php

namespace Hikingyo\Ovh\EndPoint\Service;

use Hikingyo\Ovh\EndPoint\AbstractEndPoint;
use Http\Client\Exception;

class Service extends AbstractEndPoint
{
    /**
     * GET /service.
     *
     * @throws Exception
     */
    public function list()
    {
        return $this->get('/service');
    }
}
