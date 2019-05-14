<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Validator;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Magento\Framework\Filesystem\Driver\Http\Proxy as Http;
use Magento\ImportService\Model\Import\SourceTypePool;

/**
 * Class RemoteUrlValidator
 */
class RemoteUrlValidator implements ValidatorInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Driver\Http
     */
    private $httpDriver;

    /**
     * @param Http $httpDriver
     */
    public function __construct(
        Http $httpDriver
    ) {
        $this->httpDriver = $httpDriver;
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

        /** check empty variable */
        $importData = $source->getImportData();

        if(isset($importData) && $importData != "") {
            $externalSourceUrl = preg_replace("(^https?://)", "", $importData);

            /** check for file exists */
            if(!$this->httpDriver->isExists($externalSourceUrl)) {
                $errors[] = __('Remote file %1 does not exist.', $importData);
            }
        }

        return $errors;
    }
}
