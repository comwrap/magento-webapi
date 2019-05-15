<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

/**
 * Interface SourceFormatInterface
 */
interface SourceFormatInterface
{
    const MAPPING = 'mapping';

    /**
     * @return \Magento\ImportService\Api\Data\SourceFormatMappingInterface[]|null
     */
    public function getMapping(): ?array;

    /**
     * Set multiple mapping
     *
     * @param \Magento\ImportService\Api\Data\SourceFormatMappingInterface[] $mapping
     * @return \Magento\ImportService\Api\Data\SourceFormatInterface
     */
    public function setMapping(array $mapping): SourceFormatInterface;
}