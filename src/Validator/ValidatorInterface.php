<?php

namespace CleverAge\SyliusColissimoPlugin\Validator;

interface ValidatorInterface
{
    /**
     * Validate the data passed in parameter mapped to paramsToValidate.
     */
    public function validate($data, array $paramsToValidate): array;
}
