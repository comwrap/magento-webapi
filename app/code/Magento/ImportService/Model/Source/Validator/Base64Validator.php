<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;

/**
 * Class Base64Validator
 */
class Base64Validator implements ValidatorInterface
{
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

        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $source->getImportData())) {
            $errors[] = __('Base64 import data string is invalid.');
        }

        return $errors;
    }
}
