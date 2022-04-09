<?php

namespace Hikingyo\Ovh\EndPoint\Domain;

use Hikingyo\Ovh\EndPoint\AbstractEndPoint;

class Domain extends AbstractEndPoint
{
    public function zone(): Zone
    {
        return new Zone($this->getClient());
    }

    public function list(string $whoIsOwner = null): array
    {
        $optionsResolver = $this->getOptionResolver()
            ->setDefined('whoIsOwner')
            ->setAllowedTypes('whoIsOwner', ['string', 'null'])
            ->setDefault('whoIsOwner', null)
        ;
        $optionsResolver->resolve([
            'whoIsOwner' => $whoIsOwner,
        ]);

        return $this->get('/domain', [
            'owner' => $whoIsOwner,
        ]);
    }
}
