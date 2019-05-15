<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Type;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Source Type Interface
 */
interface SourceTypeInterface
{
    // todo discuss the name of constant
    const IMPORT_SOURCE_FILE_PATH = "import/";

    /**
     * save source content
     *
     * @param SourceInterface $source
     * @throws ImportServiceException
     * @return SourceInterface
     */
    public function save(SourceInterface $source);

    /**
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return string
     */
    public function getAbsolutePathToFile(SourceInterface $source);
}
