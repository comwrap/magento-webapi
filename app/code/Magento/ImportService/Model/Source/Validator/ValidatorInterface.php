<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Validator Interface
 */
interface ValidatorInterface
{
    /**
     * return error messages in array
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return array
     */
    public function validate(SourceInterface $source);
}
