<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportService\Api\Data\SourceFormatInterface;

/**
 * Class SourceFormat
 */
class SourceFormat extends AbstractModel implements SourceFormatInterface
{
    /**
     * @inheritDoc
     */
    public function getCsvSeparator(): ?string
    {
        return $this->getData(self::CSV_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setCsvSeparator(string $csvSeparator): SourceFormatInterface
    {
        return $this->setData(self::CSV_SEPARATOR, $csvSeparator);
    }

    /**
     * @inheritDoc
     */
    public function getCsvEnclosure(): ?string
    {
        return $this->getData(self::CSV_ENCLOSURE);
    }

    /**
     * @inheritDoc
     */
    public function setCsvEnclosure(string $csvEnclosure): SourceFormatInterface
    {
        return $this->setData(self::CSV_ENCLOSURE, $csvEnclosure);
    }

    /**
     * @inheritDoc
     */
    public function getCsvDelimiter(): ?string
    {
        return $this->getData(self::CSV_DELIMITER);
    }

    /**
     * @inheritDoc
     */
    public function setCsvDelimiter(string $csvDelimiter): SourceFormatInterface
    {
        return $this->setData(self::CSV_DELIMITER, $csvDelimiter);
    }

    /**
     * @inheritDoc
     */
    public function getMultipleValueSeparator(): ?string
    {
        return $this->getData(self::MULTIPLE_VALUE_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): SourceFormatInterface
    {
        return $this->setData(self::MULTIPLE_VALUE_SEPARATOR, $multipleValueSeparator);
    }

    /**
     * @inheritDoc
     */
    public function getMapping(): ?array
    {
        return $this->getData(self::MAPPING);
    }

    /**
     * @inheritDoc
     */
    public function setMapping(array $mapping): SourceFormatInterface
    {
        return $this->setData(self::MAPPING, $mapping);
    }
}
