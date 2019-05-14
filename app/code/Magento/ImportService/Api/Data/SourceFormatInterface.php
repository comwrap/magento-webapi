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
    const CSV_SEPARATOR = 'csv_separator';
    const CSV_ENCLOSURE = 'csv_enclosure';
    const CSV_DELIMITER = 'csv_delimiter';
    const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';
    const MAPPING = 'mapping';

    const DEFAULT_CSV_SEPARATOR = ',';
    const DEFAULT_CSV_ENCLOSURE = '"';
    const DEFAULT_CSV_DELIMITER = ',';
    const DEFAULT_MULTIPLE_VALUE_SEPARATOR = '|';

    /**
     * @return string|null
     */
    public function getCsvSeparator(): ?string;

    /**
     * Set CSV Separator
     *
     * @param string $csvSeparator
     * @return \Magento\ImportService\Api\Data\SourceFormatInterface
     */
    public function setCsvSeparator(string $csvSeparator): SourceFormatInterface;

    /**
     * @return string|null
     */
    public function getCsvEnclosure(): ?string;

    /**
     * Set CSV Enclosure
     *
     * @param string $csvEnclosure
     * @return \Magento\ImportService\Api\Data\SourceFormatInterface
     */
    public function setCsvEnclosure(string $csvEnclosure): SourceFormatInterface;

    /**
     * @return string|null
     */
    public function getCsvDelimiter(): ?string;

    /**
     * Set CSV Delimiter
     *
     * @param string $csvDelimiter
     * @return \Magento\ImportService\Api\Data\SourceFormatInterface
     */
    public function setCsvDelimiter(string $csvDelimiter): SourceFormatInterface;

    /**
     * @return string|null
     */
    public function getMultipleValueSeparator(): ?string;

    /**
     * Set Multiple Value Separator
     *
     * @param string $multipleValueSeparator
     * @return \Magento\ImportService\Api\Data\SourceFormatInterface
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): SourceFormatInterface;

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