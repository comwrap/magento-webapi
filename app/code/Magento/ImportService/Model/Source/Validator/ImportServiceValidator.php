<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;

/**
 * Class ImportServiceValidator
 */
class ImportServiceValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    private $validators;

    /**
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        $validators = []
    ) {
        $this->validators = $validators;
    }

    /**
     * return error messages in array
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return array
     */
    public function validate(SourceInterface $source)
    {
        $errors = [];

        /** check for validations from validators */
        foreach($this->validators as $validator) {
            /** collect errors */
            $errors = array_merge($errors, $validator->validate($source));
        }

        /** throw errros if there is any */
        if(count($errors)) {
            throw new ImportServiceException(
                __('Invalid request: %1', implode(", ", $errors))
            );
        }

        return $errors;
    }
}
