<?php

namespace Hikingyo\Ovh\EndPoint\Auth;

use Hikingyo\Ovh\EndPoint\AbstractEndPoint;
use Http\Client\Exception;

class Auth extends AbstractEndPoint
{
    /**
     * GET /auth/time.
     *
     * @throws Exception
     */
    public function time()
    {
        return $this->get('/auth/time', [], [], false);
    }
}
