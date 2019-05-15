<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Request processor interface
 */
interface SourceProcessorInterface
{

    // todo discuss the name of constant
    const IMPORT_SOURCE_FILE_PATH = "var/import";

    /**
     * @param SourceInterface $source
     * @param SourceUploadResponseInterface $response
     * @throws ImportServiceException
     * @return SourceUploadResponseInterface
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response);
}
