<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Class ImportProcessor
 */
interface SourceUploadInterface
{
    /**
     * Upload source.
     *
     * @param string $sourceType
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return \Magento\ImportService\Api\Data\SourceUploadResponseInterface
     */
    public function execute(string $sourceType, SourceInterface $source);
}
