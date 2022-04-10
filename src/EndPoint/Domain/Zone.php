<?php

namespace Hikingyo\Ovh\EndPoint\Domain;

use Hikingyo\Ovh\EndPoint\AbstractEndPoint;
use Hikingyo\Ovh\Validator\DomainValidator;
use Http\Client\Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Zone extends AbstractEndPoint
{
    /**
     * @var string
     */
    private const URL = '/domain/zone';

    /**
     * GET /domain/zone.
     *
     * @throws Exception
     */
    public function list()
    {
        return $this->get(self::URL);
    }

    /**
     * GET /domain/zone/{zoneName}.
     *
     * @throws Exception
     */
    public function one(string $zoneName)
    {
        return $this->get(self::URL . '/' . $zoneName);
    }

    /**
     * GET /domain/zone/{zoneName}/record.
     *
     * @throws Exception
     */
    public function getRecords(string $domain, string $fieldType = null, string $subDomain = null): array
    {
        $recordUri = sprintf('%s/%s/record', self::URL, $domain);

        $optionsResolver = new OptionsResolver();

        $optionsResolver
            ->setDefined('subDomain')
            ->setAllowedTypes('subDomain', 'string')
            ->setAllowedValues('subDomain', function ($value): bool {
                return (new DomainValidator())->isSatisfyBy($value);
            })
        ;
        $optionsResolver
            ->setDefined('fieldType')
            ->setAllowedTypes('fieldType', 'string')
            ->setAllowedValues('fieldType', NamedResolutionFieldTypeEnum::toArray())
        ;

        $options = [];

        if (!empty($fieldType)) {
            $options = [
                'fieldType' => $fieldType,
            ];
        }

        if (!empty($subDomain)) {
            $options['subDomain'] = $subDomain;
        }

        return $this->get($recordUri, $optionsResolver->resolve($options));
    }
}
