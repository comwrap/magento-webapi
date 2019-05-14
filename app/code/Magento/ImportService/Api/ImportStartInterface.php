<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\ImportConfigInterface;

/**
 * ImportStartInterface interface
 */
interface ImportStartInterface
{
    /**
     * Start import
     *
     * @param \Magento\ImportService\Api\Data\ImportConfigInterface $importConfig
     * @return \Magento\ImportService\Api\Data\ImportStartResponseInterface
     */
    public function execute(ImportConfigInterface $importConfig);
}
