<?php

namespace Hikingyo\Ovh\EndPoint\Domain;

use Hikingyo\Ovh\EndPoint\AbstractEndPoint;
use Hikingyo\Ovh\Exception\InvalidParameterException;
use Hikingyo\Ovh\Validator\DomainValidator;
use Http\Client\Exception;

class Zone extends AbstractEndPoint
{
    /**
     * @var string
     */
    private const URL = '/domain/zone';

    /**
     * GET /domain/zone.
     *
     * @throws InvalidParameterException
     * @throws Exception
     */
    public function list()
    {
        return $this->get(self::URL);
    }

    /**
     * GET /domain/zone/{zoneName}.
     *
     * @throws InvalidParameterException
     * @throws Exception
     */
    public function one(string $zoneName)
    {
        return $this->get(self::URL.'/'.$zoneName);
    }

    /**
     * GET /domain/zone/{zoneName}/record.
     *
     * @throws InvalidParameterException
     * @throws Exception
     */
    public function getRecords(string $domain, string $fieldType = '', string $subDomain = ''): array
    {
        $recordUri = sprintf('%s/%s/record', self::URL, $domain);

        $optionResolver = $this->getOptionResolver();

        $optionResolver
            ->setDefined('subDomain')
            ->setAllowedTypes('subDomain', 'string')
            ->setAllowedValues('subDomain', function ($value) {
                return (new DomainValidator())->isSatisfyBy($value);
            })
        ;
        $optionResolver
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

        return $this->get($recordUri, $optionResolver->resolve($options));
    }
}
