<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceCsv\Api\Data;

/**
 * Interface SourceFormatCsvInterface
 */
interface SourceFormatCsvInterface
{
    const CSV_SEPARATOR = 'csv_separator';
    const CSV_ENCLOSURE = 'csv_enclosure';
    const CSV_DELIMITER = 'csv_delimiter';

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
     * @return \Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterface
     */
    public function setCsvSeparator(string $csvSeparator): SourceFormatCsvInterface;

    /**
     * @return string|null
     */
    public function getCsvEnclosure(): ?string;

    /**
     * Set CSV Enclosure
     *
     * @param string $csvEnclosure
     * @return \Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterface
     */
    public function setCsvEnclosure(string $csvEnclosure): SourceFormatCsvInterface;

    /**
     * @return string|null
     */
    public function getCsvDelimiter(): ?string;

    /**
     * Set CSV Delimiter
     *
     * @param string $csvDelimiter
     * @return \Magento\ImportServiceCsv\Api\Data\SourceFormatCsvInterface
     */
    public function setCsvDelimiter(string $csvDelimiter): SourceFormatCsvInterface;
}
