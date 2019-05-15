<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Api;

use Magento\ImportServiceCsv\Api\Data\SourceCsvInterface;

/**
 * Class ImportProcessor
 */
interface SourceUploadCsvInterface
{
    /**
     * Upload source.
     *
     * @param \Magento\ImportServiceCsv\Api\Data\SourceCsvInterface $source
     * @return \Magento\ImportService\Api\Data\SourceUploadResponseInterface
     */
    public function execute(SourceCsvInterface $source);
}
