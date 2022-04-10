<?php

namespace Hikingyo\Ovh\EndPoint\Domain;

use Hikingyo\Ovh\EndPoint\AbstractEndPoint;
use Http\Client\Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Domain extends AbstractEndPoint
{
    /**
     * @codeCoverageIgnore because the test brings nothing more than a coverage
     */
    public function zone(): Zone
    {
        return new Zone($this->getClient());
    }

    /**
     * GET /domain.
     *
     * @throws Exception
     */
    public function list(string $whoIsOwner = null): array
    {
        $optionsResolver = (new OptionsResolver())
            ->setDefined('whoisOwner')
            ->setAllowedTypes('whoisOwner', ['string', 'null'])
            ->setDefault('whoisOwner', null)
        ;

        return $this->get(
            '/domain',
            $optionsResolver->resolve(
                [
                    'whoisOwner' => $whoIsOwner,
                ]
            )
        );
    }
}
