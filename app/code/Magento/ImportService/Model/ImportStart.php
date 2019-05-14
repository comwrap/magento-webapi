<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\ImportConfigInterface;
use Magento\ImportService\Api\Data\ImportStartResponseInterface;
use Magento\ImportService\Api\ImportStartInterface;

/**
 * Class ImportStart
 */
class ImportStart implements ImportStartInterface
{
    /**
     * @var ImportStartResponseFactory
     */
    private $importStartResponseFactory;

    /**
     * ImportStart constructor.
     *
     * @param ImportStartResponseFactory $importStartResponseFactory
     */
    public function __construct(
        ImportStartResponseFactory $importStartResponseFactory
    ) {
        $this->importStartResponseFactory = $importStartResponseFactory;
    }

    /**
     * Import start
     *
     * @param ImportConfigInterface $importConfig
     * @return ImportStartResponseInterface
     */
    public function execute(ImportConfigInterface $importConfig)
    {
        $importStartResponse = $this->importStartResponseFactory->create();

        return $importStartResponse;
    }
}
