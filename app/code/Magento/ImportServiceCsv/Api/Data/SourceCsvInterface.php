<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Api\Data;

use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Interface SourceInterface
 */
interface SourceCsvInterface extends SourceInterface
{

    /**
     * Retrieve Source Format
     *
     * @return \Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterface|null
     */
    public function getFormat(): ?SourceFormatCsvInterface;

    /**
     * Set Source Format
     *
     * @param \Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterface $format
     * @return $this
     */
    public function setFormat(SourceFormatCsvInterface $format): SourceCsvInterface;
}
