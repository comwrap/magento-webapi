<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Model;

use Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterface;

/**
 * Class SourceFormatCsv
 */
class SourceFormatCsv extends \Magento\Framework\DataObject implements SourceFormatCsvInterface
{
    /**
     * @inheritDoc
     */
    public function getCsvSeparator(): ?string
    {
        return $this->getData(self::CSV_SEPARATOR) ?? self::DEFAULT_CSV_SEPARATOR;
    }

    /**
     * @inheritDoc
     */
    public function setCsvSeparator(string $csvSeparator): SourceFormatCsvInterface
    {
        return $this->setData(self::CSV_SEPARATOR, $csvSeparator);
    }

    /**
     * @inheritDoc
     */
    public function getCsvEnclosure(): ?string
    {
        return $this->getData(self::CSV_ENCLOSURE) ?? self::DEFAULT_CSV_ENCLOSURE;
    }

    /**
     * @inheritDoc
     */
    public function setCsvEnclosure(string $csvEnclosure): SourceFormatCsvInterface
    {
        return $this->setData(self::CSV_ENCLOSURE, $csvEnclosure);
    }

    /**
     * @inheritDoc
     */
    public function getCsvDelimiter(): ?string
    {
        return $this->getData(self::CSV_DELIMITER) ?? self::DEFAULT_CSV_DELIMITER;
    }

    /**
     * @inheritDoc
     */
    public function setCsvDelimiter(string $csvDelimiter): SourceFormatCsvInterface
    {
        return $this->setData(self::CSV_DELIMITER, $csvDelimiter);
    }
}
