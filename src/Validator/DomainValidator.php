<?php

namespace Hikingyo\Ovh\Validator;

class DomainValidator implements SpecificationInterface
{
    public function isSatisfyBy($value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
    }
}
