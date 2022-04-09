<?php

namespace Hikingyo\Ovh\Validator;

interface SpecificationInterface
{
    public function isSatisfyBy($value): bool;
}
