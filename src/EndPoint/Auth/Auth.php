<?php

namespace Hikingyo\Ovh\EndPoint\Auth;

use Hikingyo\Ovh\EndPoint\AbstractEndPoint;

class Auth extends AbstractEndPoint
{
    public function time()
    {
        return $this->get('/auth/time', [], [], false);
    }
}
