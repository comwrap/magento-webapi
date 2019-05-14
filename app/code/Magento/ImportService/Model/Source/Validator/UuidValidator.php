<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Ramsey\Uuid\Uuid;

/**
 * Class UuidValidator
 */
class UuidValidator implements ValidatorInterface
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

        if ($source->getUuid() && !Uuid::isValid($source->getUuid())) {
            $errors[] = __('The uuid %1 is not valid.', $source->getUuid());
        }

        return $errors;
    }
}
